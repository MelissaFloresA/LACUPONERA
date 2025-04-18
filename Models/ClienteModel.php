<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/Model.php';
class ClienteModel extends Model
{
    public function __construct()
    {
        parent::open_db(); // inciar la conexión a la base de datos
    }


    //funcion para generar token
    private function generateToken($length = 10)
    {
        $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($cadena), 0, $length);
    }

    //funcion para verificar token
    public function verificarToken($token)
    {
        try {
            // Consulta para buscar el cliente con el token proporcionado
            $sql = "SELECT * FROM cliente WHERE Token = :token";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':token' => $token]);

            // Si el token existe, retornamos los datos del client
            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna los datos del cliente
            } else {
                return false;
            }
        } catch (PDOException $e) {
            die("Error al verificar el token: " . $e->getMessage());
        }
    }

    //registro de cliente con token aleatorio UwU

    public function registrarCliente($datos)
{
    try {
        // Generamos un token aleatorio
        $token = $this->generateToken(10);
        $datos[':token'] = $token;
        $datos[':estado'] = 1; // estado inicial como no verificado

        // Consulta SQL para insertar el cliente
        $sql = "INSERT INTO cliente (Nombre, Apellido, Dui, Telefono, Direccion, Correo, Contrasena, Token, Estado)
        VALUES (:nombre, :apellido, :dui, :telefono, :direccion, :correo, SHA2(:contrasena, 256), :token, :estado)";
        
        // Depuración: muestra los datos que se están enviando
        var_dump($datos);

        // Preparamos la consulta
        $stmt = $this->conn->prepare($sql);
        
        // Intentamos ejecutar la consulta
        $ejecucion = $stmt->execute($datos);

        // Verificamos si la ejecución fue exitosa
        if ($ejecucion) {
            // Si la consulta fue exitosa, enviamos el correo
            $this->enviarCorreo($datos[':correo'], $datos[':nombre'], $datos[':apellido'], $token);
            return true; // Registro exitoso
        } else {
            // Si la ejecución falla, mostramos el error
            $errorInfo = $stmt->errorInfo();
        }
        
    } catch (PDOException $e) {
        // Captura los errores relacionados con la base de datos (conexión, consulta, etc.)
        die("Error en la base de datos al registrar cliente: " . $e->getMessage());
    } catch (Exception $e) {
        // Captura cualquier otro tipo de error (como error en la ejecución, en el correo, etc.)
        die("Error general al registrar cliente: " . $e->getMessage());
    } finally {
        // Cerramos la conexión a la base de datos
        $this->close_db();
    }
}


    //funcion para enviar correo

    public function enviarCorreo($correo, $nombre, $apellido, $token)
    {
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP de Gmail
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'udbcuponera@gmail.com';
            $mail->Password   = 'risc ioii rtyj hwgn';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Configuración del correo
            $mail->setFrom('udbcuponera@gmail.com', 'Cuponera UDB');
            $mail->addAddress($correo, $nombre);
            $mail->Subject = 'Gracias por registrate en Cuponera UDB';

            $mail->isHTML(true);
            $mail->Body    = "¡Hola! $nombre $apellido <br><br> Gracias por registrarte. Tu código de verificación es: <b>$token</b>. <br>Por favor, ingrésalo en el formulario de verificación.";

            // Enviar correo
            $mail->send();
            // echo 'Correo enviado correctamente';
        } catch (Exception $e) {
            echo "
            <script>
            alert('Error al enviar el correo: {$mail->ErrorInfo}');
            window.location.href = '../Views/Registro_cliente.php';
            </script>";
        }
    }

    //funcion para cambiar esyado de cliente
    public function activarCliente($token)
    {
        try {
            // Actualizar el estado del cliente a '0' (verificado)
            $sql = "UPDATE cliente SET Estado = 0 WHERE Token = :token";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([':token' => $token]);
        } catch (PDOException $e) {
            die("Error al activar cliente: " . $e->getMessage());
        }
    }

    //funcion para obtener cliente por correo
    public function obtenerClientePorCorreo($correo)
    {
        $query = "SELECT * FROM cliente WHERE Correo = :correo";
        $params = ['correo' => $correo];
        return $this->get_query($query, $params);
    }

    //funcion para verificar dui o correo duplicados
    public function verificarDuplicados($correo, $dui)
    {
        try {
            $sql = "SELECT * FROM cliente WHERE Correo = :correo OR Dui = :dui";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':correo' => $correo, ':dui' => $dui]);
            return $stmt->rowCount() > 0; // Retorna true si hay duplicados
        } catch (PDOException $e) {
            die("Error al verificar duplicados: " . $e->getMessage());
        }
    }

    public function actualizarContrasena($correo, $contrasenaPlana) {
        try {
            if (!$this->conn) {
                $this->open_db();
            }
            
            // Usamos SHA2 en la consulta SQL y enviamos la contraseña en texto plano
            $sql = "UPDATE cliente SET Contrasena = SHA2(:contrasena, 256) WHERE Correo = :correo";
            $stmt = $this->conn->prepare($sql);
            
            return $stmt->execute([
                ':contrasena' => $contrasenaPlana, // Enviamos texto plano aquí
                ':correo' => $correo
            ]);
            
        } catch (PDOException $e) {
            error_log("Error al actualizar contraseña: " . $e->getMessage());
            return false;
        }
    }
}
