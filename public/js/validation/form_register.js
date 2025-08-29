class BaseValidator {
    constructor(inputId, errorId = null) {
        this.elementInput = document.getElementById(inputId);
        this.errorElement = errorId ? document.getElementById(errorId) : this.findErrorElement(inputId);
        this.timeout = null;
        this.isFieldValid = false;
        
        if (!this.elementInput) {
            console.error(`Input ${inputId} no encontrado`);
            return;
        }
        
        this.initEvents();
    }

    findErrorElement(inputId) {
        const errorElement = document.getElementById(`${inputId}-error`);
        if (errorElement) return errorElement;
        
        const newErrorElement = document.createElement('div');
        newErrorElement.id = `${inputId}-error`;
        newErrorElement.className = 'invalid-feedback';
        this.elementInput.parentNode.appendChild(newErrorElement);
        return newErrorElement;
    }

    initEvents() {
        this.elementInput.addEventListener('input', () => this.validateWithDebounce());
        this.elementInput.addEventListener('blur', () => this.validate());
    }

    validateWithDebounce() {
        clearTimeout(this.timeout);
        this.timeout = setTimeout(() => this.validate(), 300);
    }

    resetValidation() {
        this.elementInput.classList.remove('is-invalid', 'is-valid');
        if (this.errorElement) {
            this.errorElement.textContent = '';
            this.errorElement.style.display = 'none';
        }
    }

    setError(message) {
        this.isFieldValid = false;
        this.elementInput.classList.add('is-invalid');
        this.elementInput.classList.remove('is-valid');
        if (this.errorElement) {
            this.errorElement.textContent = message;
            this.errorElement.style.display = 'block';
        }
        return false;
    }

    setSuccess() {
        this.isFieldValid = true;
        this.elementInput.classList.add('is-valid');
        this.elementInput.classList.remove('is-invalid');
        if (this.errorElement) {
            this.errorElement.style.display = 'none';
        }
    }

    isValid() {
        return this.isFieldValid;
    }
}

class NombresValidator extends BaseValidator {
    constructor() {
        super('nombre');
        this.regex = /^[A-Za-zÁÉÍÓÚáéíóúñÑ]{2,15}(?:\s[A-Za-zÁÉÍÓÚáéíóúñÑ]{2,15}){0,4}$/;
    }

    validate() {
        const value = this.elementInput.value.trim();
        
        // Resetear estado primero
        this.resetValidation();
        
        // Validaciones
        if (!value) {
            return this.setError('El nombre es obligatorio');
        }
        
        // Validar con expresión regular
        if (!this.regex.test(value)) {
            return this.analyzeError(value);
        }
        
        // Validaciones adicionales
        if (!this.hasValidWordCount(value)) {
            return this.setError('Máximo 5 nombres permitidos');
        }
        
        if (!this.hasValidWordLengths(value)) {
            return this.setError('Cada nombre debe tener 2-15 caracteres');
        }
        
        // Si pasa todas las validaciones
        this.setSuccess();
        return true;
    }

    analyzeError(value) {
        const words = value.split(/\s+/).filter(word => word.length > 0);
        
        // Validar número de palabras
        if (words.length > 5) {
            return this.setError('Máximo 5 nombres permitidos');
        }
        
        // Validar longitud de cada palabra
        for (let i = 0; i < words.length; i++) {
            if (words[i].length < 2) {
                return this.setError(`"${words[i]}" es muy corto (mínimo 2 caracteres)`);
            }
            if (words[i].length > 15) {
                return this.setError(`"${words[i]}" es muy largo (máximo 15 caracteres)`);
            }
        }
        
        // Validar caracteres especiales
        if (!/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]+$/.test(value)) {
            return this.setError('Solo se permiten letras y espacios');
        }
        
        // Validar espacios múltiples
        if (/\s{2,}/.test(value)) {
            return this.setError('No se permiten espacios múltiples');
        }
        
        return this.setError('Formato de nombre inválido');
    }

    hasValidWordCount(value) {
        const words = value.split(/\s+/).filter(word => word.length > 0);
        return words.length >= 1 && words.length <= 5;
    }

    hasValidWordLengths(value) {
        const words = value.split(/\s+/).filter(word => word.length > 0);
        return words.every(word => word.length >= 2 && word.length <= 30);
    }
}

class ApellidosValidator extends BaseValidator {
    constructor() {
        super('apellidos');
        this.regex = /^[A-Za-zÁÉÍÓÚáéíóúñÑ]{2,15}(?:\s[A-Za-zÁÉÍÓÚáéíóúñÑ]{2,15}){0,4}$/;
    }

    validate() {
        const value = this.elementInput.value.trim();
        
        // Resetear estado primero
        this.resetValidation();
        
        // Validaciones
        if (!value) {
            return this.setError('Debe ingresar su(s) apellido(s)');
        }
        
        // Validar con expresión regular
        if (!this.regex.test(value)) {
            return this.analyzeError(value);
        }
        
        // Validaciones adicionales
        if (!this.hasValidWordCount(value)) {
            return this.setError('Se acepta como máximo 5 palabras para su(s) apellido(s)');
        }
        
        if (!this.hasValidWordLengths(value)) {
            return this.setError('Cada palabra de su(s) apellido(s) debe tener entre 2 y 15 caracteres');
        }
        
        // Si pasa todas las validaciones
        this.setSuccess();
        return true;
    }

    analyzeError(value) {
        const words = value.split(/\s+/).filter(word => word.length > 0);
        
        // Validar número de palabras
        if (words.length > 5) {
            return this.setError('Máximo 5 palabras permitidas en caso de tener apellido(s) compuesto(s)');
        }
        
        // Validar longitud de cada palabra
        for (let i = 0; i < words.length; i++) {
            if (words[i].length < 2) {
                return this.setError(`"${words[i]}" es muy corto (mínimo 2 caracteres)`);
            }
            if (words[i].length > 15) {
                return this.setError(`"${words[i]}" es muy largo (máximo 15 caracteres)`);
            }
        }
        
        // Validar caracteres especiales
        if (!/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]+$/.test(value)) {
            return this.setError('Solo se permiten letras y espacios');
        }
        
        // Validar espacios múltiples
        if (/\s{2,}/.test(value)) {
            return this.setError('No se permiten espacios múltiples');
        }
        
        return this.setError('Formato de apellido inválido');
    }

    hasValidWordCount(value) {
        const words = value.split(/\s+/).filter(word => word.length > 0);
        return words.length >= 1 && words.length <= 5;
    }

    hasValidWordLengths(value) {
        const words = value.split(/\s+/).filter(word => word.length > 0);
        return words.every(word => word.length >= 2 && word.length <= 30);
    }
}

class UsernameValidator extends BaseValidator {
    constructor() {
        super('username', 'username-error');
    }

    validate() {
        const value = this.elementInput.value.trim();
        
        // Resetear estado primero
        this.resetValidation();
        
        // Validaciones
        if (!value) {
            return this.setError('El usuario es obligatorio');
        }
        
        if (value.length < 3) {
            return this.setError('Mínimo 3 caracteres');
        }

        if (value.length > 20) {
            return this.setError('Máximo 20 caracteres');
        }
        
        if (!/^(?!admin$)[a-zA-Z0-9_-]{3,20}$/.test(value)) {
            return this.setError('Solo letras, números, guiones y guiones bajos, sin admin');
        }
        
        // Si pasa todas las validaciones
        this.setSuccess();
        return true;
    }
}

class EmailValidator extends BaseValidator {
    constructor() {
        super('email', 'email-error');
    }

    validate() {
        const value = this.elementInput.value.trim();
        
        // Resetear estado primero
        this.resetValidation();
        
        // Validaciones
        if (!value) {
            return this.setError('El correo electrónico es obligatorio');
        }
        
        if (!this.isValidEmail(value)) {
            return this.setError('Formato de email inválido');
        }
        
        if (value.length > 254) {
            return this.setError('Máximo 254 caracteres permitidos');
        }
        
        // Validar dominio (opcional pero recomendado)
        if (!this.isValidDomain(value)) {
            return this.setError('Dominio no válido');
        }
        
        // Si pasa todas las validaciones
        this.setSuccess();
        return true;
    }

    isValidEmail(email) {
        // Expresión regular más robusta para validación de email
        const emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
        return emailRegex.test(email);
    }

    isValidDomain(email) {
        // Validación básica de dominio
        const domain = email.split('@')[1];
        if (!domain) return false;
        
        // Verificar que el dominio tenga al menos un punto
        if (!domain.includes('.')) {
            return false;
        }
        
        // Verificar que no termine con punto
        if (domain.endsWith('.')) {
            return false;
        }
        
        return true;
    }
}

class PasswordValidator extends BaseValidator {
    constructor() {
        super('password', 'password-error');
        this.strengthMeter = document.getElementById('password-strength');
    }

    validate() {
        const value = this.elementInput.value;
        this.resetValidation();

        if (!value) {
            return this.setError('La contraseña es obligatoria');
        }

        if (value.length < 8) {
            return this.setError('Mínimo 8 caracteres');
        }

        // Validaciones individuales para mejor feedback
        const hasUpperCase = /[A-Z]/.test(value);
        const hasLowerCase = /[a-z]/.test(value);
        const hasNumber = /\d/.test(value);
        const hasSpecialChar = /[@$!%*?&.]/.test(value);

        if (!hasUpperCase) {
            return this.setError('Falta una letra mayúscula');
        }

        if (!hasLowerCase) {
            return this.setError('Falta una letra minúscula');
        }

        if (!hasNumber) {
            return this.setError('Falta un número');
        }

        if (!hasSpecialChar) {
            return this.setError('Falta un carácter especial (@$!%*?&)');
        }

        // Calcular fortaleza
        const strength = this.calculateStrength(value);
        this.showStrength(strength);

        this.setSuccess();
        return true;
    }

    calculateStrength(password) {
        let strength = 0;
        
        // Longitud
        if (password.length >= 12) strength += 2;
        else if (password.length >= 8) strength += 1;

        // Diversidad de caracteres
        const hasUpperCase = /[A-Z]/.test(password);
        const hasLowerCase = /[a-z]/.test(password);
        const hasNumber = /\d/.test(password);
        const hasSpecialChar = /[@$!%*?&.]/.test(password);

        if (hasUpperCase && hasLowerCase) strength += 1;
        if (hasNumber) strength += 1;
        if (hasSpecialChar) strength += 1;

        return Math.min(strength, 5); // Máximo 5
    }

    showStrength(strength) {
        if (!this.strengthMeter) return;

        const strengthText = ['Muy débil', 'Débil', 'Regular', 'Fuerte', 'Muy fuerte'];
        const strengthColors = ['#dc3545', '#fd7e14', '#ffc107', '#20c997', '#198754'];
        
        this.strengthMeter.textContent = `Fortaleza: ${strengthText[strength]}`;
        this.strengthMeter.style.color = strengthColors[strength];
    }
}

class PasswordConfirmationValidator extends BaseValidator {
    constructor() {
        super('password_confirmation', 'password_confirmation-error');
        this.passwordInput = document.getElementById('password');
    }

    initEvents() {
        // Validar cuando se escribe en la confirmación
        this.elementInput.addEventListener('input', () => this.validate());
        this.elementInput.addEventListener('blur', () => this.validate());
        
        // También validar cuando cambia la contraseña principal
        if (this.passwordInput) {
            this.passwordInput.addEventListener('input', () => this.validate());
        }
    }

    validate() {
        const passwordValue = this.passwordInput ? this.passwordInput.value.trim() : '';
        const confirmationValue = this.elementInput.value.trim();
        
        // Resetear estado primero
        this.resetValidation();
        
        // Validaciones
        if (!confirmationValue) {
            return this.setError('Por favor confirma tu contraseña');
        }
        
        if (!passwordValue) {
            return this.setError('Primero debes escribir tu contraseña');
        }
        
        if (confirmationValue !== passwordValue) {
            return this.setError('Las contraseñas no coinciden');
        }
        
        // Si pasa todas las validaciones
        this.setSuccess();
        return true;
    }
}

class FechaNacimientoValidator extends BaseValidator {
    constructor() {
        super('fecha_nacimiento');
        this.minDate = this.calculateMinDate();
    }

    calculateMinDate() {
        // Calcular fecha mínima (18 años atrás desde hoy)
        const today = new Date();
        const minDate = new Date();
        minDate.setFullYear(today.getFullYear() - 18);
        return minDate;
    }

    initEvents() {
        this.elementInput.addEventListener('change', () => this.validate());
        this.elementInput.addEventListener('blur', () => this.validate());
    }

    validate() {
        const value = this.elementInput.value;
        
        // Resetear estado primero
        this.resetValidation();
        
        // Validaciones
        if (!value) {
            return this.setError('La fecha de nacimiento es obligatoria');
        }
        
        const selectedDate = new Date(value);
        const today = new Date();
        
        // Validar que sea una fecha válida
        if (isNaN(selectedDate.getTime())) {
            return this.setError('Fecha inválida');
        }
        
        // Validar que no sea fecha futura
        if (selectedDate > today) {
            return this.setError('La fecha no puede ser futura');
        }
        
        // Validar edad mínima (18 años)
        if (!this.isAtLeast18YearsOld(selectedDate)) {
            return this.setError('Debes ser mayor de 18 años');
        }
        
        // Validar que no sea demasiado antigua (opcional)
        if (this.isTooOld(selectedDate)) {
            return this.setError('La fecha parece demasiado antigua');
        }
        
        // Si pasa todas las validaciones
        this.setSuccess();
        return true;
    }

    isAtLeast18YearsOld(birthDate) {
        const today = new Date();
        const minDate = new Date();
        minDate.setFullYear(today.getFullYear() - 18);
        
        return birthDate <= minDate;
    }

    isTooOld(birthDate) {
        // Opcional: validar que no sea demasiado antigua (ej: +120 años)
        const today = new Date();
        const maxOldDate = new Date();
        maxOldDate.setFullYear(today.getFullYear() - 120);
        
        return birthDate < maxOldDate;
    }
}

class FormValidator {
    constructor() {
        this.form = document.getElementById('register-form');
        this.submitButton = document.getElementById('submit-button');
        this.validators = [];
        
        if (this.form && this.submitButton) {
            this.init();
            this.updateSubmitButton(); // Estado inicial
        }
    }

    init() {
        // Crear instancias de todos los validadores
        this.validators = [
            new NombresValidator(),
            new ApellidosValidator(),
            new UsernameValidator(),
            new EmailValidator(),
            new PasswordValidator(),
            new PasswordConfirmationValidator(),
            new FechaNacimientoValidator()
        ].filter(validator => validator.elementInput);
        
        // Conectar cada validador con este FormValidator
        this.validators.forEach(validator => {
            const originalValidate = validator.validate.bind(validator);
            validator.validate = () => {
                const result = originalValidate();
                // Usar setTimeout para evitar recursión
                setTimeout(() => this.updateSubmitButton(), 0);
                return result;
            };
        });
    }

    validateAll() {
        let allValid = true;
        
        for (const validator of this.validators) {
            if (validator.elementInput && !validator.isValid()) {
                allValid = false;
                // No es necesario seguir validando si ya encontramos un error
                break;
            }
        }
        
        return allValid;
    }

    updateSubmitButton() {
        const formIsValid = this.validateAll();
        
        this.submitButton.disabled = !formIsValid;
        
        // Añadir estilos visuales
        if (formIsValid) {
            this.submitButton.classList.remove('btn-disabled');
            this.submitButton.classList.add('btn-enabled');
        } else {
            this.submitButton.classList.add('btn-disabled');
            this.submitButton.classList.remove('btn-enabled');
        }
    }

    handleSubmit(event) {
        const isValid = this.validateAll();

        if (!isValid) {
            event.preventDefault();
            event.stopPropagation();
            this.focusFirstError();
        }
    }

    focusFirstError() {
        const firstError = this.findFirstError();
        if (firstError) {
            firstError.focus({ preventScroll: true });
            setTimeout(() => {
                firstError.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'center' 
                });
            }, 100);
        }
    }

    findFirstError() {
        for (const validator of this.validators) {
            if (validator.elementInput && 
                validator.elementInput.classList.contains('is-invalid')) {
                return validator.elementInput;
            }
        }
        return null;
    }
}

// Inicialización cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    const formValidator = new FormValidator();
    
    // Conectar el evento submit del formulario
    const form = document.getElementById('register-form');
    if (form) {
        form.addEventListener('submit', (e) => formValidator.handleSubmit(e));
    }
    
});
