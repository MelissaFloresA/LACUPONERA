<?php
session_start();
require_once '../../Models/Clientes/ClienteModel.php';

// Función para redireccionar con mensaje de error
function redirectWithError($message, $location = '/LACUPONERA/Login') {
    $_SESSION['login_error'] = $message;
    header("Location: $location");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validación más estricta de campos vacíos
    $username = isset($_POST["username"]) ? trim($_POST["username"]) : '';
    $password = isset($_POST["password"]) ? trim($_POST["password"]) : '';

    // Verificar campos vacíos (incluyendo strings con solo espacios)
    if (strlen($username) === 0 || strlen($password) === 0) {
        redirectWithError("Debe completar todos los campos");
    }

    try {
        $clienteModel = new ClienteModel();
        $user = $clienteModel->obtenerClientePorCorreo($username);

        if ($user) {
            if (hash('sha256',$password) === $user[0]["Contrasena"]) {
                if ($user[0]["Estado"] == 0) {
                    // Login exitoso
                    $_SESSION["usuario"] = $username;
                    unset($_SESSION['login_error']);
                    header("Location: /LACUPONERA/dashboard");
                    exit;
                } else {
                    redirectWithError(
                        "Cuenta no activada. Active su cuenta con el token enviado por correo",
                        '/LACUPONERA/confirmar_token'
                    );
                }
            }
        }
        
        // Credenciales incorrectas (usuario no existe o contraseña no coincide)
        redirectWithError("Usuario o contraseña incorrectos");
        
    } catch (PDOException $e) {
        error_log("Error en login: " . $e->getMessage());
        redirectWithError("Error en el sistema. Intente nuevamente más tarde");
    }
}

// Redirección por si acceden directamente al script
header("Location: /LACUPONERA/Login");
exit;
?>