<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <base href="/LACUPONERA/Views/ofertas"> <link rel="stylesheet" href="../Style/registrostyle.css">
    <style>
    <style>
        .error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body class="container">

<div>
    <h1>Registro de Clientes</h1>
    <form id="formRegistro" action="/LACUPONERA/clientes/registrar" method="POST" onsubmit="return validarFormulario(event);">
        <div class="mb-3">
            <label class="form-label">Nombres</label>
            <input type="text" class="form-control" id="txtnombre" name="txtnombre">
            <span id="errorNombre" class="error"></span>
        </div>

        <div class="mb-3">
            <label class="form-label">Apellidos</label>
            <input type="text" class="form-control" id="txtapellido" name="txtapellido">
            <span id="errorApellido" class="error"></span>
        </div>

        <div class="mb-3">
            <label class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="txttelefono" name="txttelefono">
            <span id="errorTelefono" class="error"></span>
        </div>

        <div class="mb-3">
            <label class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="txtcorreo" name="txtcorreo">
            <span id="errorCorreo" class="error"></span>
        </div>

        <div class="mb-3">
            <label class="form-label">Dirección</label>
            <input type="text" class="form-control" id="txtdireccion" name="txtdireccion">
            <span id="errorDireccion" class="error"></span>
        </div>

        <div class="mb-3">
            <label class="form-label">DUI</label>
            <input type="text" class="form-control" id="txtdui" name="txtdui">
            <span id="errorDUI" class="error"></span>
        </div>


        <div class="mb-3">
            <label class="form-label"> Contraseña</label>
            <input type="password" class="form-control" id="txtcontraseña" name="txtcontraseña">
            <span id="errorContraseña" class="error"></span>
        </div>

        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/LACUPONERA/Views/Clientes/js/ClienteValidacion.js"></script>

</body>
</html>