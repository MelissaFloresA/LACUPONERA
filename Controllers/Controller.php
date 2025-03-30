<?php
abstract class Controller {
    protected $modelo;

    // Método para cargar un modelo modelo con controller
     protected function loadModel($modelName) {
        $cadenamodelo = 'Models/' . $modelName . '.php';
        if (file_exists($cadenamodelo)) {
            require_once $cadenamodelo;
            $this->modelo = new $modelName();
        } else {
            die("Error: El modelo '$modelName' no existe.");
        }
    }

    //conexion de controller con vistas
    protected function VerOfertas($viewName, $data = []) {
        $viewPath = 'Views/' . $viewName . '.php';
        if (file_exists($viewPath)) {
            extract($data);
            require_once $viewPath;
        } else {
            die("Error: La vista '$viewName' no existe.");
        }
    }

    public function __construct() {
        //  común para todos los controladores
    }
}
?>