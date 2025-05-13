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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&family=Poppins:wght@400;600&display=swap"
        rel="stylesheet">
    <base href="/LACUPONERA/Views/ofertas">
    <link rel="stylesheet" href="../Style/OfertasStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="../resources/icionito.ico" type="image/png">
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="ms-3  navbar-brand text-white" href="/LACUPONERA/ofertas">
                <i class="fas fa-tag"></i> Cuponera
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
                aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
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

        <!-- Pestañas para categorías -->
        <ul class="nav nav-tabs mb-4" id="cuponesTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="disponibles-tab" data-bs-toggle="tab" data-bs-target="#disponibles"
                    type="button" role="tab">
                    Disponibles (<?= count($cupones['disponibles']) ?>)
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="canjeados-tab" data-bs-toggle="tab" data-bs-target="#canjeados"
                    type="button" role="tab">
                    Canjeados (<?= count($cupones['canjeados']) ?>)
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="vencidos-tab" data-bs-toggle="tab" data-bs-target="#vencidos" type="button"
                    role="tab">
                    Vencidos (<?= count($cupones['vencidos']) ?>)
                </button>
            </li>
        </ul>

        <!-- Contenido de las pestañas -->
        <div class="tab-content" id="cuponesTabsContent">
            <!-- Cupones Disponibles -->
            <div class="tab-pane fade show active" id="disponibles" role="tabpanel">
                <?php if (!empty($cupones['disponibles'])): ?>
                    <div class="row">
                        <?php foreach ($cupones['disponibles'] as $cupon): ?>
                            <div class="col-md-6 mb-4">
                                <div class="card coupon-card position-relative overflow-hidden border-0  rounded-4">
                                    <div class="card-body d-flex flex-column justify-content-between h-100 text-white">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <img src="<?= $cupon['Imagen'] ?>" class="img-fluid h-100 rounded-start object-fit-cover">
                                            </div>
                                            <div class="col-md-8">
                                                <h5 class="card-title fw-bold"><?= $cupon['Titulo'] ?></h5>
                                                <p class="fw-bold mb-1">
                                                    $<?= number_format($cupon['PrecioO'], 2) ?>
                                                    <small class="text-muted text-decoration-line-through">
                                                        $<?= number_format($cupon['PrecioR'], 2) ?>
                                                    </small>
                                                </p>
                                                <p class="card-text small"><?= $cupon['Descripcion'] ?></p>
                                                <div class="mt-3">
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check-circle me-1"></i> Disponible
                                                    </span>
                                                    <small class="text-muted float-end">
                                                        Usos: <?= $cupon['Veces_Canje'] ?>/<?= $cupon['Cantidad'] ?>
                                                    </small>
                                                </div>
                                                <div class="mt-2">
                                                    <small class="text-muted d-block">
                                                        <i class="fas fa-calendar-alt me-1"></i>
                                                        Comprado: <?= $cupon['Fecha_Compra'] ?>
                                                    </small>
                                                    <small class="text-muted d-block">
                                                        <i class="fas fa-clock me-1"></i>
                                                        Válido hasta: <?= $cupon['Fecha_Final'] ?>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">No tienes cupones disponibles.</div>
                <?php endif; ?>
            </div>

            <!-- Cupones Canjeados -->
            <div class="tab-pane fade" id="canjeados" role="tabpanel">
                <?php if (!empty($cupones['canjeados'])): ?>
                    <div class="row">
                        <?php foreach ($cupones['canjeados'] as $cupon): ?>
                            <div class="col-md-6 mb-4">
                                <div class="card coupon-card position-relative overflow-hidden border-0  rounded-4">
                                    <div class="card-body d-flex flex-column justify-content-between h-100 text-white">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <img src="<?= $cupon['Imagen'] ?>" class="img-fluid h-100 rounded-start object-fit-cover">
                                            </div>
                                            <div class="col-md-8">
                                                <h5 class="card-title fw-bold"><?= $cupon['Titulo'] ?></h5>
                                                <p class="fw-bold mb-1">
                                                    $<?= number_format($cupon['PrecioO'], 2) ?>
                                                </p>
                                                <p class="card-text small"><?= $cupon['Descripcion'] ?></p>
                                                <div class="mt-3">
                                                    <span class="badge bg-secondary">
                                                        <i class="fas fa-check-circle me-1"></i> Canjeado
                                                    </span>
                                                    <small class="text-muted float-end">
                                                        Usado <?= $cupon['Veces_Canje'] ?> veces
                                                    </small>
                                                </div>
                                                <div class="mt-2">
                                                    <small class="text-muted d-block">
                                                        <i class="fas fa-calendar-alt me-1"></i>
                                                        Comprado: <?= $cupon['Fecha_Compra'] ?>
                                                    </small>
                                                    <small class="text-muted d-block">
                                                        <i class="fas fa-clock me-1"></i>
                                                        Válido hasta: <?= $cupon['Fecha_Final'] ?>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">No tienes cupones canjeados.</div>
                <?php endif; ?>
            </div>
            <!-- Cupones Vencidos -->
            <div class="tab-pane fade" id="vencidos" role="tabpanel">
                <?php if (!empty($cupones['vencidos'])): ?>
                    <div class="row">
                        <?php foreach ($cupones['vencidos'] as $cupon): ?>
                            <div class="col-md-6 mb-4">
                                <div class="card coupon-card position-relative overflow-hidden border-0  rounded-4">
                                    <div class="card-body d-flex flex-column justify-content-between h-100 text-white">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <img src="<?= $cupon['Imagen'] ?>" class="img-fluid h-100 rounded-start object-fit-cover">
                                            </div>
                                            <div class="col-md-8">
                                                <h5 class="card-title fw-bold"><?= $cupon['Titulo'] ?></h5>
                                                <p class="fw-bold mb-1">
                                                    $<?= number_format($cupon['PrecioO'], 2) ?>
                                                </p>
                                                <p class="card-text small"><?= $cupon['Descripcion'] ?></p>
                                                <div class="mt-3">
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-clock me-1"></i> Vencido
                                                    </span>
                                                    <small class="text-muted float-end">
                                                        No usado (0/<?= $cupon['Cantidad'] ?>)
                                                    </small>
                                                </div>
                                                <div class="mt-2">
                                                    <small class="text-muted d-block">
                                                        <i class="fas fa-calendar-alt me-1"></i> Comprado:
                                                        <?= $cupon['Fecha_Compra'] ?>
                                                    </small>
                                                    <small class="text-muted d-block">
                                                        <i class="fas fa-clock me-1"></i>
                                                        Venció el: <?= $cupon['Fecha_Final'] ?>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">No tienes cupones vencidos.</div>
                <?php endif; ?>
            </div>
        </div>
    </div> <!--Fin clase container-->


    <!--Toast de Mensajes-->
    <button type="button" class="d-none" id="toastBtn"></button>

    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="toast"
            class="toast align-items-center <?= $_SESSION['Result']['status'] ? 'text-bg-success' : 'text-bg-danger' ?> border-0"
            role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <?php echo htmlspecialchars($_SESSION['Result']['mensaje']); ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
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