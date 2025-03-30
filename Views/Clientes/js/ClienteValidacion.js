function validarFormulario(event) {
    let esValido = true;

    let nombre = document.getElementById("txtnombre").value.trim();
    let apellido = document.getElementById("txtapellido").value.trim();
    let telefono = document.getElementById("txttelefono").value.trim();
    let correo = document.getElementById("txtcorreo").value.trim();
    let direccion = document.getElementById("txtdireccion").value.trim();
    let dui = document.getElementById("txtdui").value.trim();
    let contraseña = document.getElementById("txtcontraseña").value.trim();

    let regexNombre = /^[a-zA-ZÁÉÍÓÚáéíóúÑñ\s]+$/;
    let regexDUI = /^\d{8}-?\d{1}$/; 
    let regexTelefono = /^\d{8}$/; 
    let regexCorreo = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;  

    
    document.getElementById("errorNombre").textContent = "";
    document.getElementById("errorApellido").textContent = "";
    document.getElementById("errorTelefono").textContent = "";
    document.getElementById("errorCorreo").textContent = "";
    document.getElementById("errorDireccion").textContent = "";
    document.getElementById("errorDUI").textContent = "";
    document.getElementById("errorContraseña").textContent = "";

    if (nombre === "") {
        document.getElementById("errorNombre").textContent = "Ingrese su nombre.";
        esValido = false;
    } else if (!regexNombre.test(nombre)) {
        document.getElementById("errorNombre").textContent = "Solo se permiten letras.";
        esValido = false;
    }

    if (apellido === "") {
        document.getElementById("errorApellido").textContent = "Ingrese su apellido.";
        esValido = false;
    } else if (!regexNombre.test(apellido)) {
        document.getElementById("errorApellido").textContent = "Solo se permiten letras.";
        esValido = false;
    }

    if (telefono === "") {
        document.getElementById("errorTelefono").textContent = "Ingrese su teléfono.";
        esValido = false;
    } else if (!regexTelefono.test(telefono)) {
        document.getElementById("errorTelefono").textContent = "El teléfono debe tener 8 dígitos.";
        esValido = false;
    }

    if (correo === "") {
        document.getElementById("errorCorreo").textContent = "Ingrese su correo.";
        esValido = false;
    } else if (!regexCorreo.test(correo)) {
        document.getElementById("errorCorreo").textContent = "Formato de correo incorrecto.";
        esValido = false;
    }

    if (direccion === "") {
        document.getElementById("errorDireccion").textContent = "Ingrese su dirección.";
        esValido = false;
    }

    if (dui === "") {
        document.getElementById("errorDUI").textContent = "Ingrese su DUI.";
        esValido = false;
    } else if (!regexDUI.test(dui)) {
        document.getElementById("errorDUI").textContent = "Formato de DUI incorrecto (ej: 12345678-9).";
        esValido = false;
    }

    if (contraseña === "") {
        document.getElementById("errorContraseña").textContent = "Ingrese una contraseña.";
        esValido = false;
    }
    
    if (esValido) {
        document.getElementById("formRegistro").submit(); // Envía manualmente
    }
    
    return esValido;
}