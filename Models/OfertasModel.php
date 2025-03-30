<?php
require_once 'Model.php';
class OfertasModel extends Model {
    //FUNCIÓN PARA OBTENER LOS CUPONES en interfaz publica
    public function get($rubro = null) { //sin filtro
        if($rubro == null && $rubro == '') {
        $query = "SELECT * FROM cupones WHERE Fecha_Final >= CURDATE() AND Estado_Cupon = 'Disponible'";
        $parametros = [];//alamacena rubros
        }
        else{
            $query = "SELECT * FROM cupones WHERE Fecha_Final >= CURDATE() AND Estado_Cupon = 'Disponible' AND ID_Empresa IN (SELECT ID_Empresa FROM empresa WHERE ID_Rubro = :rubro)";
            $parametros[':rubro'] = $rubro;
        }

        return $this->get_query($query, $parametros);
    }

    //FUNCION PARA OBTENER LOS RUBROS
    public function getRubros() {
        $query = "SELECT ID_Rubro, Nombre FROM rubros";
        return $this->get_query($query);
    }
}
?>