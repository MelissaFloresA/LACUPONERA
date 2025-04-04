<?php
session_start();

if (isset($_SESSION['ID_Cliente'])) {
	header("Location: /LACUPONERA/");
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Iniciar Sesion</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
	<base href="/LACUPONERA/Views/">
	<link rel="stylesheet" href="../Style/LoginStyle.css">

</head>

<body>
	<div class="container vh-100">
		<div class="row h-100 align-items-center">
			<div class="col-md-6 d-flex flex-column align-items-center">
				<img src="../resources/savings.svg" alt="" width="500" height="500">
				<a href="/LACUPONERA/"><button type="button" class="btn btn-outline-dark rounded-pill px-4">Regresar</button></a>
			</div>
			<div class="col-md-6">
				<div class="card text-white p-4">
					<div class="card-header bg-transparent">
						<h2 class="card-title fw-bold">Iniciar Sesión</h2>
					</div>
					<div class="card-body">
						<form action="/LACUPONERA/clientes/do-login" method="POST">
							<div class="mb-3">
								<label for="exampleInputEmail1" class="form-label">Correo Electrónico</label>
								<input type="email" class="form-control" id="username" name="username" aria-describedby="emailHelp">
							</div>
							<div class="mb-3">
								<label for="exampleInputPassword1" class="form-label">Contraseña</label>
								<input type="password" class="form-control" id="password" name="password">
							</div>
							<div class="row">
								<div class="col d-flex justify-content-between align-items-center">
									<button type="submit" class="btn btn-dark rounded-pill px-4">Ingresar</button>
									<a href="/LACUPONERA/registro" class="link-offset-3 link-underline-light text-white link-underline-opacity-0 link-underline-opacity-100-hover">¿No tienes cuenta con nosotros? Regístrate</a>
								</div>
							</div>
						</form>
					</div>
				</div>
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