document.addEventListener('DOMContentLoaded', function() {
    const paymentForm = document.getElementById('paymentForm');
    const cardNumberInput = document.getElementById('cardNumber');
    const expiryDateInput = document.getElementById('expiryDate');
    const cvvInput = document.getElementById('cvv');
    const submitButton = document.getElementById('submitButton');

    const cardNumberError = document.getElementById('cardNumberError');
    const expiryDateError = document.getElementById('expiryDateError');
    const cvvError = document.getElementById('cvvError');

    // Función para verificar si todos los campos son válidos
    function checkFormValidity() {
        const isCardValid = validarNumeroTarjeta(cardNumberInput);
        const isExpiryValid = validarFechaVencimiento(expiryDateInput);
        const isCvvValid = validarCVV(cvvInput);
        
        submitButton.disabled = !(isCardValid && isExpiryValid && isCvvValid);
    }

    function validarNumeroTarjeta(input) {
        const cardNumberValue = input.value.replace(/\s/g, '');
        let isValid = /^[0-9]{16}$/.test(cardNumberValue); // Exactamente 16 dígitos
        cardNumberError.textContent = isValid ? '' : 'Número de tarjeta inválido (16 dígitos).';
        return isValid;
    }

    function validarFechaVencimiento(input) {
        const expiryDateValue = input.value;
        const expiryRegex = /^(0[1-9]|1[0-2])\/([0-9]{2})$/;
        let isValid = expiryRegex.test(expiryDateValue);
        if (isValid) {
            const [month, yearShort] = expiryDateValue.split('/');
            const currentYearShort = new Date().getFullYear() % 100;
            const currentMonth = new Date().getMonth() + 1;
            const year = parseInt(yearShort, 10);
            const monthInt = parseInt(month, 10);

            if (year < currentYearShort || (year === currentYearShort && monthInt < currentMonth)) {
                expiryDateError.textContent = 'La fecha de vencimiento ya pasó.';
                isValid = false;
            } else {
                expiryDateError.textContent = '';
            }
        } else {
            expiryDateError.textContent = 'Fecha de vencimiento inválida (MM/AA).';
        }
        return isValid;
    }

    function validarCVV(input) {
        const cvvValue = input.value;
        let isValid = /^[0-9]{3}$/.test(cvvValue);
        cvvError.textContent = isValid ? '' : 'CVV inválido (3 dígitos).';
        return isValid;
    }

    window.formatearNumeroTarjeta = function(input) {
        const value = input.value.replace(/[^0-9]/g, '').replace(/(\d{4})(?=\d)/g, '$1 ');
        input.value = value;
        validarNumeroTarjeta(input);
        checkFormValidity();
        return value;
    };

    window.formatearFechaVencimiento = function(input) {
        const value = input.value.replace(/[^0-9\/]/g, '').replace(/(\d{2})(?=\d)/g, '$1/').substring(0, 5);
        input.value = value;
        validarFechaVencimiento(input);
        checkFormValidity();
        return value;
    };

    window.formatearCVV = function(input) {
        const value = input.value.replace(/[^0-9]/g, '').substring(0, 4);
        input.value = value;
        validarCVV(input);
        checkFormValidity();
        return value;
    };

    // Validar al perder el foco (blur)
    if (cardNumberInput) {
        cardNumberInput.addEventListener('blur', function() {
            validarNumeroTarjeta(this);
            checkFormValidity();
        });
    }
    if (expiryDateInput) {
        expiryDateInput.addEventListener('blur', function() {
            validarFechaVencimiento(this);
            checkFormValidity();
        });
    }
    if (cvvInput) {
        cvvInput.addEventListener('blur', function() {
            validarCVV(this);
            checkFormValidity();
        });
    }

    // Validar también mientras se escribe (input)
    if (cardNumberInput) {
        cardNumberInput.addEventListener('input', function() {
            validarNumeroTarjeta(this);
            checkFormValidity();
        });
    }
    if (expiryDateInput) {
        expiryDateInput.addEventListener('input', function() {
            validarFechaVencimiento(this);
            checkFormValidity();
        });
    }
    if (cvvInput) {
        cvvInput.addEventListener('input', function() {
            validarCVV(this);
            checkFormValidity();
        });
    }

    // Interceptar el envío del formulario
    if (paymentForm) {
        paymentForm.addEventListener('submit', function(event) {
            const isCardValid = validarNumeroTarjeta(cardNumberInput);
            const isExpiryValid = validarFechaVencimiento(expiryDateInput);
            const isCvvValid = validarCVV(cvvInput);

            if (!(isCardValid && isExpiryValid && isCvvValid)) {
                event.preventDefault();
                // Mostrar todos los errores si hay alguno
                validarNumeroTarjeta(cardNumberInput);
                validarFechaVencimiento(expiryDateInput);
                validarCVV(cvvInput);
            }
        });
    } else {
        console.error('No se encontró el formulario con el ID "paymentForm".');
    }
});