<?php
require_once 'Model.php';
require_once __DIR__ . '/../vendor/autoload.php'; // Ajusta la ruta si es necesario

use PHPMailer\PHPMailer\PHPMailer;
use Dompdf\Dompdf;

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
        $this->open_db();

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



    public function enviarCuponConPDF($correo, $nombre, $cupones)
    {
        // Aplanar los cupones por cantidad y procesar imagenes
        $cuponesExpandido = [];

        foreach ($cupones as $cupon) {
            for ($i = 0; $i < $cupon['Cantidad']; $i++) {
                $nuevoCupon = $cupon;

                // Si querés códigos únicos por unidad, descomenta la siguiente línea:
                // $nuevoCupon['Codigo_Cupon'] .= '-' . ($i + 1);

                $nuevoCupon['ImagenBase64'] = '';
                if (@file_get_contents($nuevoCupon['Imagen'])) {
                    $imgData = file_get_contents($nuevoCupon['Imagen']);
                    $imgType = pathinfo($nuevoCupon['Imagen'], PATHINFO_EXTENSION);
                    $nuevoCupon['ImagenBase64'] = 'data:image/' . $imgType . ';base64,' . base64_encode($imgData);
                }

                $cuponesExpandido[] = $nuevoCupon;
            }
        }

        // Calcular total general
        $totalGeneral = 0;
        foreach ($cupones as $cupon) {
            $totalGeneral += $cupon['Cantidad'] * $cupon['PrecioO'];
        }

        // Generar HTML
        ob_start();
?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <style>
                body {
                    font-family: 'Poppins', sans-serif;
                    background-color: #f4f4f4;
                    padding: 20px;
                    color: #333;
                }

                h1 {
                    color: #173C74;
                }

                .coupon-container {
                    background-color: #2e79ea;
                    border-radius: 1.5rem;
                    color: white;
                    margin-bottom: 20px;
                    padding: 0;
                    width: 100%;
                    font-size: 14px;
                    overflow: hidden;
                }

                .coupon-table {
                    width: 100%;
                    border-collapse: collapse;
                    table-layout: fixed;
                    height: 200px;
                }

                .coupon-table td {
                    vertical-align: top;
                    padding: 0;
                }

                .coupon-img {
                    width: 80px;
                    height: 200px;
                    overflow: hidden;
                }

                .coupon-img img {
                    width: 100%;
                    height: 200px;
                    object-fit: cover;
                    display: block;
                }

                .coupon-details {
                    padding: 15px;
                    height: 200px;
                    box-sizing: border-box;
                }

                .coupon-details h2 {
                    margin: 0 0 5px 0;
                    font-size: 18px;
                    color: white;
                }

                .coupon-details p {
                    margin: 4px 0;
                    color: white;
                }

                .coupon-footer {
                    background-color: #173C74;
                    width: 100%;
                    padding: 8px 12px;
                    font-size: 12px;
                    margin-top: 10px;
                    border-radius: 0 0 1rem 0;
                    color: #ccc;
                }
            </style>
        </head>

        <body>
            <h1>Gracias por tu compra, <?= htmlspecialchars($nombre) ?></h1>
            <p><strong>Total pagado:</strong> $<?= number_format($totalGeneral, 2) ?></p>
            <p>Aquí están tus cupones:</p>

            <?php foreach ($cuponesExpandido as $cupon): ?>
                <div class="coupon-container">
                    <table class="coupon-table">
                        <tr>
                            <td class="coupon-img">
                                <?php if (!empty($cupon['ImagenBase64'])): ?>
                                    <img src="<?= $cupon['ImagenBase64'] ?>" alt="Imagen del cupón">
                                <?php endif; ?>
                            </td>
                            <td class="coupon-details" style="padding-left: 20px; padding-right: 20px;">
                                <h2 style="margin-top: 20px;"><?= htmlspecialchars($cupon['Titulo']) ?></h2>
                                <p style="margin-top: 10px;"><strong>$<?= $cupon['PrecioO'] ?></strong> <del>$<?= $cupon['PrecioR'] ?></del></p>
                                <p style="margin-top: 10px;"><?= htmlspecialchars($cupon['Descripcion']) ?></p>
                                <p style="margin-top: 10px;"><strong>Código:</strong> <?= $cupon['Codigo_Cupon'] ?></p>
                                <p style="margin-top: 10px;"><strong>Cantidad:</strong> <?= $cupon['Cantidad'] ?></p>
                                <div class="coupon-footer">
                                    Válido hasta <?= $cupon['Fecha_Final'] ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php endforeach; ?>
        </body>

        </html>
<?php
        $html = ob_get_clean();

        // Crear el PDF
        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter', 'portrait');
        $dompdf->render();
        $pdfOutput = $dompdf->output();

        // Enviar el correo con PHPMailer
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'udbcuponera@gmail.com';
            $mail->Password   = 'risc ioii rtyj hwgn';
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('udbcuponera@gmail.com', 'Cuponera UDB');
            $mail->addAddress($correo, $nombre);
            $mail->Subject = 'Detalle de tu compra - Cuponera UDB';
            $mail->isHTML(true);
            $mail->Body    = "Hola $nombre,<br><br>Gracias por tu compra. Adjuntamos el detalle en PDF.<br><br>¡Disfruta tus cupones!";

            $mail->addStringAttachment($pdfOutput, 'DetalleCompra.pdf', 'base64', 'application/pdf');

            $mail->send();
            echo "Correo enviado correctamente.";
        } catch (\PHPMailer\PHPMailer\Exception $e) {
            echo "Error al enviar correo: {$mail->ErrorInfo}";
        }
    }
}
