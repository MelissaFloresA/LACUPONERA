<?php
require_once 'Model.php';
class OfertasModel extends Model
{
    public function __construct()
    {
        parent::open_db(); // inciar la conexión a la base de datos
    }

    //FUNCIÓN PARA OBTENER LOS CUPONES en interfaz publica
    public function get($rubro = null)
    { //sin filtro
        if ($rubro == null && $rubro == '') {
            $query = "SELECT * FROM cupones WHERE Fecha_Final >= CURDATE() AND Estado_Cupon = 'Disponible' AND stock > 0";
            $parametros = []; //alamacena rubros
        } else {
            $query = "SELECT * FROM cupones WHERE Fecha_Final >= CURDATE() AND Estado_Cupon = 'Disponible' AND stock > 0 AND ID_Empresa IN (SELECT ID_Empresa FROM empresa WHERE ID_Rubro = :rubro)";
            $parametros[':rubro'] = $rubro;
        }

        return $this->get_query($query, $parametros);
    }

    //FUNCION PARA OBTENER LOS RUBROS
    public function getRubros()
    {
        $query = "SELECT ID_Rubro, Nombre FROM rubros";
        return $this->get_query($query);
    }

    //FUNCION PARA VERIFICAR SI EL CUPON YA ESTA EN EL CARRITO
    public function existeCupon($ID_Cupon, $ID_Cliente)
    {
        $query = "SELECT * FROM ventas WHERE ID_Cupon = :ID_Cupon AND ID_Cliente = :ID_Cliente AND Estado = 0"; 
        $parametros = [':ID_Cupon' => $ID_Cupon, ':ID_Cliente' => $ID_Cliente];
        return $this->get_query($query, $parametros);
    }

    //FUNCION PARA AGREGAR CUPONES AL CARRITO
    public function agregarCupon($datos)
    {
        parent::open_db();
        $sql = "INSERT INTO ventas (ID_Cupon, ID_Cliente, Cantidad, Monto, Metodo_Pago, Estado) 
                VALUES (:ID_Cupon, :ID_Cliente, :Cantidad, :Monto, :Metodo_Pago, :Estado)";

        $stmt = $this->conn->prepare($sql);

        // Ejecutamos la consulta pasando los datos
        return $stmt->execute($datos);
    }

    //FUNCION PARA OBTENER LOS CUPONES DEL CARRITO
    public function getCarrito()
    {
        $query = "SELECT * FROM cupones 
                  INNER JOIN ventas ON cupones.ID_Cupon = ventas.ID_Cupon
                  WHERE ID_Cliente = :ID_Cliente AND Estado = 0";
        $parametros = [':ID_Cliente' => $_SESSION["ID_Cliente"] ?? ''];
        return $this->get_query($query, $parametros);
    }

    //FUNCION PARA OBTENER EL STOCK DE UN CUPON
    public function getStock($ID_Cupon)
    {
        $query = "SELECT Stock FROM cupones WHERE ID_Cupon = :ID_Cupon";
        $parametros = [':ID_Cupon' => $ID_Cupon];
        return $this->get_query($query, $parametros);
    }

    //FUNCION PARA ACTUALIZAR LA CANTIDAD DE UN CUPON
    public function actualizarCantidad($ID_Venta, $Cantidad)
    {
        $query = "SELECT PrecioO FROM cupones INNER JOIN ventas ON cupones.ID_Cupon = ventas.ID_Cupon WHERE ID_Venta = :ID_Venta";
        $parametros = [':ID_Venta' => $ID_Venta];
        $PrecioO = $this->get_query($query, $parametros);

        parent::open_db();

        $sql = "UPDATE ventas SET Cantidad = :Cantidad, Monto = :Cantidad * :PrecioO WHERE ID_Venta = :ID_Venta";

        $stmt = $this->conn->prepare($sql);

        // Ejecutamos la consulta pasando los datos
        return $stmt->execute([':Cantidad' => $Cantidad, ':PrecioO' => $PrecioO[0]['PrecioO'], ':ID_Venta' => $ID_Venta]);
    }

    //FUNCION PARA ELIMINAR UN CUPON DEL CARRITO
    public function eliminarCupon($ID_Venta)
    {
        $sql = "DELETE FROM ventas WHERE ID_Venta = :ID_Venta";

        $stmt = $this->conn->prepare($sql);

        // Ejecutamos la consulta pasando los datos
        return $stmt->execute([':ID_Venta' => $ID_Venta]);
    }

    //FUNCION PARA FINALIZAR LA COMPRA
    public function comprarCupones($Metodo_Pago)
    {
        $sql = "UPDATE ventas SET Estado = 1, Metodo_Pago = :Metodo_Pago WHERE ID_Cliente = :ID_Cliente AND Estado = 0";

        $stmt = $this->conn->prepare($sql);

        // Ejecutamos la consulta pasando los datos
        return $stmt->execute([':Metodo_Pago' => $Metodo_Pago, ':ID_Cliente' => $_SESSION["ID_Cliente"]]);
    }

    //FUNCION PARA OBTENER EL HISTORIAL DE CUPONES
    public function getHistorialCupones()
    {
        $query = "SELECT * FROM cupones 
                  INNER JOIN ventas ON cupones.ID_Cupon = ventas.ID_Cupon
                  WHERE ID_Cliente = :ID_Cliente AND Estado = 1";
        $parametros = [':ID_Cliente' => $_SESSION["ID_Cliente"]];
        return $this->get_query($query, $parametros);
    }
}
