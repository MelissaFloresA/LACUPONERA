<?php
include_once '../Controllers/OfertasController.php';
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

    <!-- Agregar Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    </nav>

    <div class="container mt-4">
        <?php if (isset($_SESSION['Nombre'])): ?>
            <h1>Hola, <strong> <?= $_SESSION['Nombre'] ?> </strong></h1>
        <?php endif; ?>

        <form method="get" class="my-4 filtro-rubro" id="rubroForm">
            <div class="row">
                <div class="col-auto">
                    <label class="col-form-label" for="rubro">Filtrar por Rubro:</label>
                </div>
                <div class="col-auto">
                    <select class="form-select" name="rubro" id="rubro" onchange="cadenaRubro(this.value);">
                        <option value="">Todos los rubros</option>
                        <?php if (!empty($rubros)): ?>
                            <?php foreach ($rubros as $r): ?>
                                <option value="<?= $r['ID_Rubro'] ?>" <?= (isset($_GET['rubro']) && $_GET['rubro'] == $r['ID_Rubro']) ? 'selected' : '' ?>>
                                    <?= $r['Nombre'] ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
        </form>

        <div class="row align-items-center">
            <?php if (!empty($ofertas)): ?>
                <?php foreach ($ofertas as $oferta): ?>
                    <div class="col-md-6 mb-4">
    <div class="card coupon-card position-relative overflow-hidden border-0  rounded-4">
        <div class="row g-0">
            <div class="col-4">
                <img src="<?= $oferta['Imagen'] ?>" alt="Coupon Image" class="img-fluid h-100 rounded-start object-fit-cover">
            </div>
            <div class="col-8 pb-4">
                <div class="card-body d-flex flex-column justify-content-between h-100 text-white">
                    <div>
                        <h4 class="card-title fw-bold"><?= $oferta['Titulo'] ?></h4>
                        <h5 class="fw-bold mb-1">$<?= $oferta['PrecioO'] ?> <del class="text-muted">$<?= $oferta['PrecioR'] ?></del></h5>
                        <p class="small mb-2"><?= $oferta['Descripcion'] ?></p>
                    </div>
                    <?php if (isset($_SESSION['ID_Cliente'])): ?>
                        <form action="/LACUPONERA/cupones/do-agregar" method="POST" class="mb-3">
                            <input type="hidden" name="ID_Cupon" value="<?= $oferta['ID_Cupon'] ?>">
                            <input type="hidden" name="Monto" value="<?= $oferta['PrecioO'] ?>">
                            <button class="btn btn-dark rounded-pill mt-3 px-4">Añadir al <i class="fa-solid fa-cart-shopping"></i></button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="coupon-footer  text-white-50 d-flex justify-content-between align-items-center px-3 py-2 position-absolute bottom-0 start-0 end-0 rounded-bottom-4 small">
            <span>Válido hasta <?= $oferta['Fecha_Final'] ?></span>
            <span>Disponibles <?= $oferta['Stock'] ?></span>
        </div>
        <!-- Circles -->
        <div class="circle-left"></div>
        <div class="circle-right"></div>
    </div>
</div>

                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center w-100 font-weight-bold">No se encontraron cupones disponibles.</p>
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
    <script>
        function cadenaRubro(rubroId) { //js para que me de url amigable ofertas/1 ...
            if (rubroId) {
                window.location.href = '/LACUPONERA/ofertas/' + rubroId;
            } else {
                window.location.href = '/LACUPONERA/ofertas/';
            }
        }
    </script>
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