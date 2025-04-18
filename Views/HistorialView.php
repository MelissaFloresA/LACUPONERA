<?php
include_once __DIR__ . '/../Controllers/OfertasController.php';

if (!isset($_SESSION['ID_Cliente'])) {
    header("Location: /LACUPONERA/");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cupones de Descuento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <base href="/LACUPONERA/Views/ofertas">
    <link rel="stylesheet" href="../Style/OfertasStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="../resources/icionito.ico" type="image/png">
</head>

<body>
<nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="ms-3  navbar-brand text-white" href="/LACUPONERA/ofertas">
                <i class="fas fa-tag"></i> Cuponera
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse text-white" id="navbar">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <?php if (isset($_SESSION['ID_Cliente'])): ?>
                        <li class="nav-item ">
                            <a class="nav-link text-white" href="/LACUPONERA/mi-carrito">
                                <i class="fas fa-shopping-cart"></i> Mi Carrito
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/LACUPONERA/mis-cupones">
                                <i class="fas fa-ticket-alt"></i> Mis Cupones
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/LACUPONERA/clientes/do-logout">
                                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/LACUPONERA/login">
                                <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <?php if (isset($_SESSION['Nombre'])): ?>
            <h1 class="my-4">Cupones de <strong> <?= $_SESSION['Nombre'] ?> </strong></h1>
        <?php endif; ?>

        <div class="row">
            <?php if (!empty($historial)): ?>
                <?php foreach ($historial as $cupon): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card coupon-card flex-row text-white border-0 py-4 px-5 overflow-hidden mb-4">
                            <div class="card-body p-0 mb-4">
                                <h4 class="card-title fw-bold"><?= $cupon['Titulo'] ?></h4>
                                <h5 class="fw-bold mb-1">$<?= $cupon['PrecioO'] ?> <del class="text-muted">$<?= $cupon['PrecioR'] ?></del></h5>
                                <p><?= $cupon['Descripcion'] ?></p>
                                <h5 class=""><span class="text-muted">Código:</span> <?= $cupon['Codigo_Cupon'] ?></h5>
                            </div>
                            <div class="w-100 bg-black bg-opacity-50 d-flex justify-content-between text-white-50 py-1 px-2 rounded rounded-top-0 position-absolute bottom-0 start-0">
                                <p class="m-0">Válido hasta <?= $cupon['Fecha_Final'] ?></p>
                                <p class="m-0">Cantidad: <?= $cupon['Cantidad'] ?></p>
                            </div>
                            <div class="d-flex align-items-center">
                                <img src="<?= $cupon['Imagen'] ?>" alt="Coupon Image" class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center w-100 font-weight-bold">No has comprado cupones.</p>
            <?php endif; ?>
        </div>
    </div>


    <!--Toast de Mensajes-->
    <button type="button" class="d-none" id="toastBtn"></button>

    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="toast" class="toast align-items-center <?= $_SESSION['Result']['status'] ? 'text-bg-success' : 'text-bg-danger' ?> border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <?php echo htmlspecialchars($_SESSION['Result']['mensaje']); ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!--Mensajes-->
    <?php if (isset($_SESSION['Result'])): ?>
        <script>
            const toastTrigger = document.getElementById('toastBtn')
            const toast = document.getElementById('toast')

            if (toastTrigger) {
                const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast)
                toastTrigger.addEventListener('click', () => {
                    toastBootstrap.show()
                })
            }

            toastTrigger.click();
        </script>
        <?php unset($_SESSION['Result']); ?>
    <?php endif; ?>

</body>

</html>