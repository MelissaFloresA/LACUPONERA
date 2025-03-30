<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Token</title>
    <base href="/LACUPONERA/Views/ofertas"> <link rel="stylesheet" href="../Style/tokenstyle.css">
    <script>
        // Mostrar alerta si hay error en la URL
        if(window.location.search.includes('error=invalid_token')) {
            alert('Token inválido. Por favor, intente nuevamente.');
        }
    </script>
</head>
<body>

<form action="/LACUPONERA/verificar-token" method="POST">
    <label for="token">Ingresa el token que recibiste por correo:</label>
    <input type="text" id="token" name="token" required>
    <button type="submit">Verificar</button>
</form>

</body>
</html>