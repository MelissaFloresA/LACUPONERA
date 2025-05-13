<?php
require_once __DIR__ . '/../Models/ClienteModel.php';

// Función para redireccionar con mensaje de error
function redirectWithError($message, $location = '/LACUPONERA/login')
{
    $_SESSION['Result'] = [
        "status" => false,
        "mensaje" => $message
    ];
    header("Location: $location");
    exit;
}

//VALIDACIONES DE PARTE DE SERVIDOR
function validarDatosRegistro($datosPost)
{
    $errores = [];
    $regexNombre = '/^[a-zA-ZÁÉÍÓÚáéíóúÑñ\s]+$/';
    $regexDUI = '/^\d{8}-\d{1}$/';
    $regexTelefono = '/^[267]\d{3}-\d{4}$/';
    $regexCorreo = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

    // Validación de campos (usando los mismos nombres del formulario)
    if (empty($datosPost['txtnombre'])) {
        $errores[] = "Ingrese su nombre";
    } elseif (!preg_match($regexNombre, $datosPost['txtnombre'])) {
        $errores[] = "Solo se permiten letras en el nombre";
    }
    if (empty($datosPost['txtapellido'])) {
        $errores[] = "Ingrese su apellido";
    } elseif (!preg_match($regexNombre, $datosPost['txtapellido'])) {
        $errores[] = "Solo se permiten letras en el apellido";
    }

    if (empty($datosPost['txtdui'])) {
        $errores[] = "Ingrese su DUI";
    } elseif (!preg_match($regexDUI, $datosPost['txtdui'])) {
        $errores[] = "Formato de DUI incorrecto (ej: 12345678-9)";
    }

    if (empty($datosPost['txttelefono'])) {
        $errores[] = "Ingrese su teléfono";
    } elseif (!preg_match($regexTelefono, $datosPost['txttelefono'])) {
        $errores[] = "Teléfono debe comenzar con 2,6 o 7 y tener formato 1234-5678";
    }
    if (empty($datosPost['txtdireccion'])) {
        $errores[] = "Ingrese su dirección";
    }

    if (empty($datosPost['txtcorreo'])) {
        $errores[] = "Ingrese su correo";
    } elseif (!preg_match($regexCorreo, $datosPost['txtcorreo'])) {
        $errores[] = "Formato de correo incorrecto";
    }

    if (empty($datosPost['txtcontraseña'])) {
        $errores[] = "Ingrese una contraseña";
    } elseif (strlen($datosPost['txtcontraseña']) < 6) {
        $errores[] = "La contraseña debe tener al menos 6 caracteres";
    }
    if (empty($datosPost['txtcontraseña2'])) {
        $errores[] = "Repita su contraseña";
    } elseif ($datosPost['txtcontraseña'] !== $datosPost['txtcontraseña2']) {
        $errores[] = "Las contraseñas no coinciden";
    }

    return $errores;
}

//inicio de acciones de controlador
if (isset($_GET['action'])) {
    session_start();
    $clienteModel = new ClienteModel();

    switch ($_GET['action']) {
        case 'registrar':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Aplicar validaciones der servidor antes de procesar
                $errores = validarDatosRegistro($_POST);
                if (!empty($errores)) {
                    redirectWithError(implode("<br>", $errores), '/LACUPONERA/registro');
                    exit;
                }

                // datos en array
                $datos = [
                    ':nombre' => $_POST["txtnombre"] ?? '',
                    ':apellido' => $_POST["txtapellido"] ?? '',
                    ':dui' => $_POST["txtdui"] ?? '',
                    ':telefono' => $_POST["txttelefono"] ?? '',
                    ':direccion' => $_POST["txtdireccion"] ?? '',
                    ':correo' => $_POST["txtcorreo"] ?? '',
                    ':contrasena' => $_POST["txtcontraseña"] ?? '',
                    ':token' => '',
                    ':estado' => 1
                ];
                // validacion de campos vacios
                if (
                    !empty($datos[':nombre']) && !empty($datos[':apellido']) && !empty($datos[':dui']) &&
                    !empty($datos[':telefono']) && !empty($datos[':direccion']) && !empty($datos[':correo']) &&
                    !empty($datos[':contrasena'])
                ) {

                    try {
                        if ($clienteModel->verificarDuplicados($datos[':correo'], $datos[':dui'])) {
                            redirectWithError(
                                "El correo o el DUI ya están registrados. Por favor, utiliza otros datos.",
                                '/LACUPONERA/registro'
                            );
                            exit;
                        }
                        // Llamamos al método para registrar el cliente, pasando los datos
                        $resultado = $clienteModel->registrarCliente($datos);

                        // Verificamos si la operación fue exitosa
                        if ($resultado) {
                            $_SESSION['Result'] = [
                                "status" => true,
                                "mensaje" => "Registro exitoso. Por favor, verifica tu correo para activar tu cuenta."
                            ];
                            header("Location: /LACUPONERA/confirmar_token");
                            exit;
                        } else {
                            redirectWithError(
                                "Error al registrar el cliente. Por favor, intenta nuevamente.",
                                '/LACUPONERA/registro'
                            );
                            exit;
                        }
                    } catch (Exception $e) {
                        echo "Error: " . $e->getMessage();
                    }
                } else {
                    echo "Complete todos los campos";
                }
            }
            break;
        case 'verificarToken':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $tokenIngresado = $_POST['token'];

                $clienteModel = new ClienteModel();
                $cliente = $clienteModel->verificarToken($tokenIngresado);

                if ($cliente) {
                    $clienteModel->activarCliente($tokenIngresado);
                    $_SESSION['Result'] = [
                        "status" => true,
                        "mensaje" => "Cuenta activada con éxito. Ahora puedes iniciar sesión."
                    ];
                    header("Location: /LACUPONERA/login");
                    exit;
                } else {
                    redirectWithError("El token ingresado es incorrecto.", '/LACUPONERA/confirmar_token');
                    exit;
                }
            }
            break;
        case 'login':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Validación más estricta de campos vacíos
                $username = isset($_POST["username"]) ? trim($_POST["username"]) : '';
                $password = isset($_POST["password"]) ? trim($_POST["password"]) : '';

                // Verificar campos vacíos (incluyendo strings con solo espacios)
                if (strlen($username) === 0 || strlen($password) === 0) {
                    redirectWithError("Debe completar todos los campos");
                }

                try {
                    $user = $clienteModel->obtenerClientePorCorreo($username);

                    if ($user) {
                        if (hash('sha256', $password) === $user[0]["Contrasena"]) {
                            if ($user[0]["Estado"] == 0) {
                                // Login exitoso
                                $_SESSION["ID_Cliente"] = $user[0]["ID_Cliente"];
                                $_SESSION["Nombre"] = $user[0]["Nombre"];
                                $_SESSION["Correo"] = $user[0]["Correo"];
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
                exit;
            }
            break;
        case 'logout':
            session_unset();
            session_destroy();
            header("Location: /LACUPONERA/ofertas");
            exit;
            break;

        case 'actualizarContrasena':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $email = $_POST['email'] ?? '';
                $password = trim($_POST['password'] ?? '');
                $confirm_password = trim($_POST['confirm_password'] ?? '');

                try {
                    $clienteModel = new ClienteModel();
                    $user = $clienteModel->obtenerClientePorCorreo($email);

                    if (!$user) {
                        redirectWithError("Correo no registrado", '/LACUPONERA/recuperar-contrasena');
                        exit;
                    }

                    // Enviamos la contraseña en texto plano al modelo
                    if ($clienteModel->actualizarContrasena($email, $password)) {
                        $_SESSION['Result'] = [
                            'status' => true,
                            'mensaje' => 'Contraseña actualizada correctamente'
                        ];
                        header("Location: /LACUPONERA/login");
                        exit;
                    } else {
                        redirectWithError("Error al actualizar", '/LACUPONERA/recuperar-contrasena');
                        exit;
                    }
                } catch (Exception $e) {
                    error_log("Error: " . $e->getMessage());
                    redirectWithError("Error del sistema", '/LACUPONERA/recuperar-contrasena');
                    exit;
                }
            }
            break;

        default:
            header("Location: /LACUPONERA/");
            exit;
            break;
    }
}


// Redirección por si acceden directamente al script
header("Location: /LACUPONERA/");
exit;
