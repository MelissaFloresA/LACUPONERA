<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cupones de Descuento</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <base href="/LACUPONERA/Views/ofertas"> <link rel="stylesheet" href="../Style/OfertasStyle.css">
</head>

<body>

    <div class="container">
    <a href="/LACUPONERA/Login" class="btn btn-login">Iniciar Sesión</a><!--con ruta amigable-->
        <h2 class="text-center">Cupones de Descuento</h2>

        <form method="get" class="mb-5 filtro-rubro" id="rubroForm">
            <label for="rubro">Filtrar por Rubro:</label>
            <select name="rubro" id="rubro" onchange="cadenaRubro(this.value);">
                <option value="">Todos los rubros</option>
                <?php if (!empty($rubros)): ?>
                    <?php foreach ($rubros as $r): ?>
                        <option value="<?= $r['ID_Rubro'] ?>" <?= (isset($_GET['rubro']) && $_GET['rubro'] == $r['ID_Rubro']) ? 'selected' : '' ?>>
                            <?= $r['Nombre'] ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </form>

        <div class="row">
            <?php if (!empty($ofertas)): ?>
                <?php foreach ($ofertas as $oferta): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="<?= $oferta['Imagen'] ?>" class="card-img-top" alt="Imagen del cupón">
                            <div class="card-body">
                                <h5 class="card-title"><?= $oferta['Titulo'] ?></h5>
                                <div class="descripcion">
                                    <p><strong>Descripción:</strong> <?= $oferta['Descripcion'] ?></p>
                                </div>
                                <div class="info-extra">
                                    <p><strong>Precio Oferta: $</strong> <?= $oferta['PrecioO'] ?> <del
                                            class="text-muted">$<?= $oferta['PrecioR'] ?></del></p>
                                    <p><strong>Fecha Fin:</strong> <?= $oferta['Fecha_Final'] ?></p>
                                    <p><strong>Disponibles:</strong> <?= $oferta['Stock'] ?></p>
                                </div>
                            <!--BOTON-->
                                <button type="button" class="btn btn-comprar">Comprar</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center w-100 font-weight-bold">No se encontraron cupones disponibles.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function cadenaRubro(rubroId) { //js para que me de url amigable ofertas/1 ...
            if (rubroId) {
                window.location.href = '/LACUPONERA/ofertas/' + rubroId;
            } else {
                window.location.href = '/LACUPONERA/ofertas/';
            }
        }
    </script>

</body>

</html>