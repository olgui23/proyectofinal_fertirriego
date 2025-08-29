class LoginValidator {
    constructor() {
        this.elementInput = document.getElementById('login');
        this.errorElement = document.getElementById('login-error');
        this.initEvents();
    }

    initEvents() {
        this.elementInput.addEventListener('input', () => this.validateWithDebounce());
        this.elementInput.addEventListener('blur', () => this.validate());
    }

    validateWithDebounce() {
        clearTimeout(this.timeout);
        this.timeout = setTimeout(() => this.validate(), 300);
    }

    validate() {
        const value = this.elementInput.value.trim();
        
        // Resetear estado primero
        this.resetValidation();
        
        // Validaciones básicas
        if (!value) {
            return this.setError('Usuario o email es obligatorio');
        }
        
        // Determinar si es email o username y validar accordingly
        if (this.looksLikeEmail(value)) {
            return this.validateEmail(value);
        } else {
            return this.validateUsername(value);
        }
    }

    looksLikeEmail(value) {
        // Verificar si tiene formato de email
        return value.includes('@') && value.includes('.');
    }

    validateEmail(email) {
        // Validación de email
        const emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
        
        if (!emailRegex.test(email)) {
            return this.setError('Formato de email inválido');
        }
        
        if (email.length > 254) {
            return this.setError('Email demasiado largo (máx. 254 caracteres)');
        }
        
        // Si pasa validación de email
        this.setSuccess('✓ Email válido');
        return true;
    }

    validateUsername(username) {
        // Validación de username (ajusta según tus requisitos)
        if (username.length < 3) {
            return this.setError('Mínimo 3 caracteres para usuario');
        }
        
        if (username.length > 30) {
            return this.setError('Máximo 30 caracteres para usuario');
        }
        
        if (!/^(?!admin$)[a-zA-Z0-9_-]{3,20}$/.test(username)) {
            return this.setError('Solo letras, números, guiones, puntos y guiones bajos, sin admin');
        }
        
        // Validar que no sea solo números
        if (/^\d+$/.test(username)) {
            return this.setError('El usuario no puede ser solo números');
        }
        
        // Si pasa validación de username
        this.setSuccess('✓ Usuario válido');
        return true;
    }

    resetValidation() {
        this.elementInput.classList.remove('is-invalid', 'is-valid');
        if (this.errorElement) {
            this.errorElement.textContent = '';
            this.errorElement.style.display = 'none';
        }
    }

    setError(message) {
        this.elementInput.classList.add('is-invalid');
        if (this.errorElement) {
            this.errorElement.textContent = message;
            this.errorElement.style.display = 'block';
        }
        return false;
    }

    setSuccess(message = '') {
        this.elementInput.classList.add('is-valid');
        if (this.errorElement && message) {
            this.errorElement.textContent = message;
            this.errorElement.classList.remove('invalid-feedback');
            this.errorElement.classList.add('valid-feedback');
            this.errorElement.style.display = 'block';
        } else if (this.errorElement) {
            this.errorElement.style.display = 'none';
        }
    }

    // Método para obtener el tipo de dato detectado
    getInputType() {
        const value = this.elementInput.value.trim();
        return this.looksLikeEmail(value) ? 'email' : 'username';
    }

    // Método para validación en submit
    isValid() {
        return this.validate();
    }

    // Método para limpiar feedback positivo después de un tiempo
    clearSuccessFeedback() {
        setTimeout(() => {
            if (this.errorElement) {
                this.errorElement.style.display = 'none';
            }
        }, 2000);
    }
}


class PasswordValidator {
    constructor() {
        console.log("Estamos en PasswordValidator");
        this.passwordInput = document.getElementById('password');
        this.errorElement = document.getElementById('password-error');
        this.strengthMeter = document.getElementById('password-strength');
        this.initEvents();
    }

    initEvents() {
        this.passwordInput.addEventListener('input', () => this.validate());
        this.passwordInput.addEventListener('blur', () => this.validate());
    }

    validate() {
        const value = this.passwordInput.value;
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
            return this.setError('Falta un carácter especial ($!%*?&.)');
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

        //const strengthText = ['Muy débil', 'Débil', 'Regular', 'Fuerte', 'Muy fuerte'];
        const strengthColors = ['#dc3545', '#fd7e14', '#ffc107', '#20c997', '#198754'];
        
        //this.strengthMeter.textContent = `Fortaleza: ${strengthText[strength]}`;
        this.strengthMeter.style.color = strengthColors[strength];
    }

    resetValidation() {
        this.passwordInput.classList.remove('is-invalid', 'is-valid');
        this.errorElement.textContent = '';
        this.errorElement.style.display = 'none';
    }

    setError(message) {
        this.passwordInput.classList.add('is-invalid');
        this.errorElement.textContent = message;
        this.errorElement.style.display = 'block';
        return false;
    }

    setSuccess() {
        this.passwordInput.classList.add('is-valid');
    }
}

// Inicializar
document.addEventListener('DOMContentLoaded', () => {
    new LoginValidator();
    new PasswordValidator();
});

