<?php
session_start();

// Verificar sesión activa
if (!isset($_SESSION["usuario"])) {
    header("Location: /LACUPONERA/Login");
    exit;
}

// Mostrar alerta de sesión iniciada si es la primera vez
if (!isset($_SESSION['sesion_iniciada'])) {
    echo "<script>alert('Has iniciado sesión correctamente.');</script>";
    $_SESSION['sesion_iniciada'] = true;
}

// Redirigir al controlador de ofertas
header("Location: /LACUPONERA/ofertas");
exit;
?>