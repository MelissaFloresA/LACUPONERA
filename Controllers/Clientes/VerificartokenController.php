<?php
require_once '../../Models/Clientes/ClienteModel.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tokenIngresado = $_POST['token'];

    $clienteModel = new ClienteModel();
    $cliente = $clienteModel->verificarToken($tokenIngresado);

    if ($cliente) {
        $clienteModel->activarCliente($tokenIngresado);
        echo "<script>
                alert('Cuenta activada correctamente. Inicia sesión para continuar.');
                window.location.href = '/LACUPONERA/Login';
              </script>";
        exit;
    } else {
        header("Location: /LACUPONERA/confirmar_token?error=invalid_token");
        exit;
    }
}

// Redirección si se accede directamente
header("Location: /LACUPONERA/confirmar_token");
exit;
?>