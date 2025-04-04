<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Token</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <base href="/LACUPONERA/Views/ofertas">
    <link rel="stylesheet" href="../Style/LoginStyle.css">
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card text-white p-4">
            <div class="card-header bg-transparent">
                <h1 class="card-title fw-bold">Ingreso Token</h1>
            </div>
            <div class="card-body">
                <form action="/LACUPONERA/clientes/verificar-token" method="POST">
                    <div class="row">
                        <div class="col">
                            <label class="form-label" for="token">Ingresa el token que recibiste por correo:</label>
                            <input type="text" class="form-control mb-4" id="token" name="token" required>
                            <button class="btn btn-dark rounded-pill px-4" type="submit">Verificar</button>
                        </div>
                    </div>
                </form>
            </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="/LACUPONERA/Views/Clientes/js/ClienteValidacion.js"></script>

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