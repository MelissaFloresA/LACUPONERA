<?php
require_once __DIR__ . '/../Models/OfertasModel.php';

if (isset($_GET['action'])) {
    session_start();
    $OfertasModel = new OfertasModel();

    switch ($_GET['action']) {
        case 'getCupones':
            $ofertas = $OfertasModel->get($_GET['rubro'] ?? null);
            $rubros = $OfertasModel->getRubros();
            break;
        case 'agregarCupon':
            $datos = [
                ':ID_Cupon'     => $_POST["ID_Cupon"] ?? '',
                ':ID_Cliente'   => $_SESSION["ID_Cliente"] ?? '',
                ':Cantidad'     => 1,
                ':Monto'        => $_POST["Monto"] ?? '',
                ':Metodo_Pago'  => '',
                ':Estado'       => 0,
            ];

            $existeCupon = $OfertasModel->existeCupon($datos[':ID_Cupon'], $datos[':ID_Cliente']);
            if ($existeCupon) {
                $_SESSION["Result"] = [
                    "status" => false,
                    "mensaje" => "El cupón ya se añadió al carrito",
                ];
            } else {
                $resultado = $OfertasModel->agregarCupon($datos);
                if ($resultado) {
                    $_SESSION["Result"] = [
                        "status" => true,
                        "mensaje" => "Cupón añadido al carrito con éxito",
                    ];
                } else {
                    $_SESSION["Result"] = [
                        "status" => false,
                        "mensaje" => "Error al añadir el cupón al carrito",
                    ];
                }
            }
            header("Location: /LACUPONERA/");
            break;
        case 'getCarrito':
            $carrito = $OfertasModel->getCarrito();
            break;
        case 'actualizarCantidad':
            if ($_POST["Cantidad"] == 0) {
                $resultado = $OfertasModel->eliminarCupon($_POST["ID_Venta"]);
                if ($resultado) {
                    $_SESSION["Result"] = [
                        "status" => true,
                        "mensaje" => "Cupon eliminado con éxito",
                    ];
                }
            } else if ($_POST["Cantidad"] > 0) {
                $stock = $OfertasModel->getStock($_POST["ID_Cupon"]);
                if ($stock[0]["Stock"] >= $_POST["Cantidad"]) {
                    $resultado = $OfertasModel->actualizarCantidad($_POST["ID_Venta"], $_POST["Cantidad"]);
                    if ($resultado) {
                        $_SESSION["Result"] = [
                            "status" => true,
                            "mensaje" => "Cantidad actualizada con éxito",
                        ];
                    } else {
                        $_SESSION["Result"] = [
                            "status" => false,
                            "mensaje" => "Error al actualizar la cantidad",
                        ];
                    }
                } else {
                    $_SESSION["Result"] = [
                        "status" => false,
                        "mensaje" => "No hay suficiente stock",
                    ];
                }
            } else {
                $_SESSION["Result"] = [
                    "status" => false,
                    "mensaje" => "Ingrese una cantidad válida",
                ];
            }
            header("Location: /LACUPONERA/mi-carrito");
            break;
            case 'comprarCupones':
                // 1. Obtener cupones que están en el carrito (los que se van a comprar)
                $cuponesAEnviar = $OfertasModel->getCarrito();
            
                // 2. Intentar enviar el correo primero (con los cupones que se van a comprar)
                $correo = $_SESSION["Correo"];
                $nombre = $_SESSION["Nombre"];
                $envioExitoso = false;
            
                // Intentamos enviar el correo
                try {
                    $OfertasModel->enviarCuponConPDF($correo, $nombre, $cuponesAEnviar);
                    $envioExitoso = true;
                } catch (Exception $e) {
                    // Si el correo falla, podemos capturar el error aquí
                    $_SESSION["Result"] = [
                        "status" => false,
                        "mensaje" => "Error al enviar el correo: " . $e->getMessage(),
                    ];
                }
            
                // 3. Si el correo fue enviado correctamente, procesamos la compra
                if ($envioExitoso) {
                    // 4. Ejecutar compra (cambia Estado = 1)
                    $resultado = $OfertasModel->comprarCupones('Tarjeta');
            
                    if ($resultado) {
                        $_SESSION["Result"] = [
                            "status" => true,
                            "mensaje" => "Cupones comprados con éxito. Revisa tu correo.",
                        ];
                    } else {
                        $_SESSION["Result"] = [
                            "status" => false,
                            "mensaje" => "Error al comprar los cupones",
                        ];
                    }
                }
            
                header("Location: /LACUPONERA/");
                break;
                  
        case 'getHistorialCupones':
            $historial = $OfertasModel->getHistorialCupones();
            break;
        default:
            header("Location: /LACUPONERA/");
            break;
    }
} else {
    // Redirección por default
    header("Location: /LACUPONERA/");
}
