<?php

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestUri = trim(str_replace('/LACUPONERA', '', $requestUri), '/');

// Rutas tipo "GET" (vistas)
switch (true) {
    case $requestUri === '':
    case $requestUri === 'ofertas':
        $_GET['action'] = 'getCupones';
        include 'Views/OfertasViews.php';
        break;

    case preg_match('#^ofertas/([0-9]+)$#', $requestUri, $matches):
        $_GET['action'] = 'getCupones';
        $_GET['rubro'] = $matches[1];
        include 'Views/OfertasViews.php';
        break;

    case $requestUri === 'mi-carrito':
        $_GET['action'] = 'getCarrito';
        include 'Views/CarritoView.php';
        break;

    case $requestUri === 'mis-cupones':
        $_GET['action'] = 'getHistorialCupones';
        include 'Views/HistorialView.php';
        break;

    case $requestUri === 'login':
        include 'Views/Clientes/Login.php';
        break;

    case $requestUri === 'registro':
        include 'Views/Clientes/Registro_cliente.php';
        break;

    case $requestUri === 'confirmar_token':
        include 'Views/Clientes/Confirmar_token.php';
        break;

    case $requestUri === 'dashboard':
        include 'Views/Clientes/dashboard.php';
        break;

    case $requestUri === 'recuperar-contrasena':
        include 'Views/Clientes/RecuperarPassword.php';
        break;

// Rutas tipo "POST" o de acción
    case $requestUri === 'cupones/do-agregar':
        $_GET['action'] = 'agregarCupon';
        include 'Controllers/OfertasController.php';
        break;

    case $requestUri === 'cupones/do-actualizar-cantidad':
        $_GET['action'] = 'actualizarCantidad';
        include 'Controllers/OfertasController.php';
        break;

    case $requestUri === 'cupones/do-comprar':
        $_GET['action'] = 'comprarCupones';
        include 'Controllers/OfertasController.php';
        break;

    case $requestUri === 'clientes/registrar':
        $_GET['action'] = 'registrar';
        include 'controllers/ClientesController.php';
        break;

    case $requestUri === 'clientes/verificar-token':
        $_GET['action'] = 'verificarToken';
        include 'controllers/ClientesController.php';
        break;

    case $requestUri === 'clientes/do-login':
        $_GET['action'] = 'login';
        include 'controllers/ClientesController.php';
        break;

    case $requestUri === 'clientes/do-logout':
        $_GET['action'] = 'logout';
        include 'controllers/ClientesController.php';
        break;

    case $requestUri === 'recuperar-contrasena/actualizar':
        $_GET['action'] = 'actualizarContrasena';
        include 'controllers/ClientesController.php';
        break;

    default:
        http_response_code(404);
        echo "Página no encontrada.";
        break;
}
