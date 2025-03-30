<?php
require_once 'Controllers/OfertasController.php';

//OFERTAS VIEWS
$controller = new OfertasController();
$rubro = isset($_GET['rubro']) ? $_GET['rubro'] : null;// Obtener el valor del rubro de la URL
$controller->index($rubro);// Llamar al método index en ofertasController
?>