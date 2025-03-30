<?php
require_once 'Controller.php';
require_once __DIR__ . '/../Models/OfertasModel.php';
//Dir es el direcctoriao actual
class OfertasController extends Controller {
    private $OfertasModelo;

    public function __construct() {
        parent::__construct();
        $this->OfertasModelo = new OfertasModel();
    }

    public function index($rubro = null) {
        $ofertas = $this->OfertasModelo->get($rubro);
        $rubros = $this->OfertasModelo->getRubros();
        $this->VerOfertas('OfertasViews', ['ofertas' => $ofertas, 'rubros' => $rubros]);
    }
}
?>