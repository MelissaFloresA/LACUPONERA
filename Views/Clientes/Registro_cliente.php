<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <base href="/LACUPONERA/Views/ofertas">
    <link rel="stylesheet" href="../Style/LoginStyle.css">
    <link rel="icon" href="../resources/icionito.ico" type="image/png">
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card text-white p-4">
            <div class="card-header bg-transparent">
                <h1 class="card-title fw-bold">Registro de Clientes</h1>
            </div>
            <div class="card-body">
                <form id="formRegistro" action="/LACUPONERA/clientes/registrar" method="POST" onsubmit="return validarFormulario(event);">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Nombres</label>
                            <input type="text" class="form-control" id="txtnombre" name="txtnombre">
                            <span id="errorNombre" class="fw-bold text-dark"></span>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="txtapellido" name="txtapellido">
                            <span id="errorApellido" class="fw-bold text-dark"></span>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="txttelefono" name="txttelefono" maxlength="9" oninput="formatearTelefono(this)" inputmode="numeric">
                            <span id="errorTelefono" class="fw-bold text-dark"></span>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" id="txtcorreo" name="txtcorreo">
                            <span id="errorCorreo" class="fw-bold text-dark"></span>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="txtdireccion" name="txtdireccion">
                            <span id="errorDireccion" class="fw-bold text-dark"></span>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">DUI</label>
                            <input type="text" class="form-control" id="txtdui" name="txtdui" maxlength="10" oninput="formatearDUI(this)" inputmode="numeric">
                            <span id="errorDUI" class="fw-bold text-dark"></span>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="txtcontraseña" name="txtcontraseña">
                            <span id="errorContraseña" class="fw-bold text-dark"></span>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Repetir Contraseña</label>
                            <input type="password" class="form-control" id="txtcontraseña2" name="txtcontraseña2">
                            <span id="errorContraseña2" class="fw-bold text-dark"></span>
                        </div>
                    </div>

                    <div class="d-flex w-100">
                        <a href="/LACUPONERA/login" class="ms-auto">
                            <button type="button" class="btn btn-outline-dark rounded-pill px-4">Regresar</button>
                        </a>
                        <button type="submit" class="btn btn-dark rounded-pill px-4 ms-3">Registrar</button>
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