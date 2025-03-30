<?php
require_once __DIR__ . '/../../Models/Clientes/ClienteModel.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // datos en array
    $datos = [
        ':nombre'     => $_POST["txtnombre"] ?? '',
        ':apellido'   => $_POST["txtapellido"] ?? '',
        ':dui'        => $_POST["txtdui"] ?? '',
        ':telefono'   => $_POST["txttelefono"] ?? '',
        ':direccion'  => $_POST["txtdireccion"] ?? '',
        ':correo'     => $_POST["txtcorreo"] ?? '',
        ':contrasena' => $_POST["txtcontraseña"] ?? '',
        ':token'      => '',
        ':estado'     => 1
    ];
    var_dump($datos);
    // validacion de campos vacios
    if (!empty($datos[':nombre']) && !empty($datos[':apellido']) && !empty($datos[':dui']) &&
        !empty($datos[':telefono']) && !empty($datos[':direccion']) && !empty($datos[':correo']) &&
        !empty($datos[':contrasena'])) {

        try {
            // Instanciamos el modelo correctamente
            $clienteModel = new ClienteModel();

            if($clienteModel->verificarDuplicados($datos[':correo'], $datos[':dui'])) {
                echo "<script>
                        alert('El correo o el DUI ya están registrados. Por favor, utiliza otros datos.');
                        window.location.href = '/LACUPONERA/registro';
                      </script>";
                exit;
            }
            // Llamamos al método para registrar el cliente, pasando los datos
            $resultado = $clienteModel->registrarCliente($datos);

            // Verificamos si la operación fue exitosa
            if ($resultado) {
                echo "<script>
                        alert('Cliente registrado correctamente. Por favor, verifica tu correo para activar tu cuenta.');
                        window.location.href = '/LACUPONERA/confirmar_token';
                      </script>";
                exit;
            } else {
                echo "<script>
                        alert('Error al registar.');
                        window.location.href = '/LACUPONERA/registro';
                      </script>";
                exit;
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

    } else {
        echo "Complete todos los campos";
    }
}
?>