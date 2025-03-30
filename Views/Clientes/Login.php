<?php
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar Sesion</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <base href="/LACUPONERA/Views/ofertas"> <link rel="stylesheet" href="../Style/loginstyle.css">

  </head>

<body class="container">

  <h2 class="m-3 p-3 text-center">Iniciar Sesion</h2>
  <form action="/LACUPONERA/controllers/Clientes/ProcesarloginController.php" method="POST">
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Correo Electronico</label>
      <input type="email" class="form-control" id="username" name="username" aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
      <label for="exampleInputPassword1" class="form-label">Contraseña</label>
      <input type="password" class="form-control" id="password" name="password">
    </div>
    <div class="row">
      <div class="col">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
      <div class="col">
        <a href="/LACUPONERA/registro">¿No tienes cuenta con nosotros?</a>
      </div>
    </div>

  </form>
  <!--Mensajes-->
  <div class="container">
    <?php if (isset($_SESSION['login_error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?php echo htmlspecialchars($_SESSION['login_error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['login_error']); ?>
    <?php endif; ?>

</div>
  
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>