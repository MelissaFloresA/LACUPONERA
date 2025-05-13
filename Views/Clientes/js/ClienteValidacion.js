function validarFormulario(event) {
    let esValido = true;

    let nombre = document.getElementById("txtnombre").value.trim();
    let apellido = document.getElementById("txtapellido").value.trim();
    let telefono = document.getElementById("txttelefono").value.trim();
    let correo = document.getElementById("txtcorreo").value.trim();
    let direccion = document.getElementById("txtdireccion").value.trim();
    let dui = document.getElementById("txtdui").value.trim();
    let contraseña = document.getElementById("txtcontraseña").value.trim();
    let contraseña2 = document.getElementById("txtcontraseña2").value.trim();

    let regexNombre = /^[a-zA-ZÁÉÍÓÚáéíóúÑñ\s]+$/;
    let regexDUI = /^\d{8}-?\d{1}$/; 
    let regexTelefono = /^[267]{1}[0-9]{3}-[0-9]{4}$/;
    let regexCorreo = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;  

    // Limpiar mensajes de error
    document.getElementById("errorNombre").textContent = "";
    document.getElementById("errorApellido").textContent = "";
    document.getElementById("errorTelefono").textContent = "";
    document.getElementById("errorCorreo").textContent = "";
    document.getElementById("errorDireccion").textContent = "";
    document.getElementById("errorDUI").textContent = "";
    document.getElementById("errorContraseña").textContent = "";
    document.getElementById("errorContraseña2").textContent = "";

    // Validaciones
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
        document.getElementById("errorTelefono").textContent = "El teléfono debe tener 8 dígitos y comenzar con 2, 6 o 7.";
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
    } else if (contraseña.length < 6) {
        document.getElementById("errorContraseña").textContent = "La contraseña debe tener al menos 6 caracteres.";
        esValido = false;
    }

    if (contraseña2 === "") {
        document.getElementById("errorContraseña2").textContent = "Repita su contraseña.";
        esValido = false;
    } else if (contraseña !== contraseña2) {
        document.getElementById("errorContraseña2").textContent = "Las contraseñas no coinciden.";
        esValido = false;
    }

    return esValido;
}
function soloNumeros(e) {
    const tecla = e.key;
    return /^[0-9]$/.test(tecla);
}

function soloNumerosDUI(e) {
    const tecla = e.key;
    return /^[0-9\-]$/.test(tecla);
}

function formatearTelefono(input) {
    let valor = input.value.replace(/\D/g, ''); // Solo dígitos
    if (valor.length > 4) {
        valor = valor.slice(0, 4) + '-' + valor.slice(4, 8);
    }
    input.value = valor.slice(0, 9); // Limita a 9 caracteres totales
}

function formatearDUI(input) {
    let valor = input.value.replace(/\D/g, ''); // Solo dígitos
    if (valor.length > 8) {
        valor = valor.slice(0, 8) + '-' + valor.slice(8, 9);
    }
    input.value = valor.slice(0, 10); // Limita a 10 caracteres totales
}