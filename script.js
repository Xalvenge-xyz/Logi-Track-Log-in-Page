class AIAssistantLoginForm {
    constructor() {
        this.form = document.getElementById('loginForm');
        this.emailInput = document.getElementById('email');
        this.passwordInput = document.getElementById('password');
        this.passwordToggle = document.getElementById('passwordToggle');
        this.submitButton = this.form.querySelector('.neural-button');
        this.successMessage = document.getElementById('successMessage');
        this.socialButtons = document.querySelectorAll('.social-neural');

        // Create error popup
        this.errorPopup = document.createElement('div');
        this.errorPopup.className = 'popup-error';
        document.body.appendChild(this.errorPopup);

        this.init();
    }

    init() {
        this.bindEvents();
        this.setupPasswordToggle();
        this.setupSocialButtons();
        this.setupAIEffects();
    }

    bindEvents() {
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));
        this.emailInput.addEventListener('blur', () => this.validateEmail());
        this.passwordInput.addEventListener('blur', () => this.validatePassword());
        this.emailInput.addEventListener('input', () => this.clearError('email'));
        this.passwordInput.addEventListener('input', () => this.clearError('password'));
        this.emailInput.setAttribute('placeholder', ' ');
        this.passwordInput.setAttribute('placeholder', ' ');
    }

    setupPasswordToggle() {
        this.passwordToggle.addEventListener('click', () => {
            const type = this.passwordInput.type === 'password' ? 'text' : 'password';
            this.passwordInput.type = type;
            this.passwordToggle.classList.toggle('toggle-active', type === 'text');
        });
    }

    setupSocialButtons() {
        this.socialButtons.forEach(button => {
            button.addEventListener('click', () => {
                const provider = button.querySelector('span').textContent.trim();
                this.handleSocialLogin(provider, button);
            });
        });
    }

    setupAIEffects() {
        [this.emailInput, this.passwordInput].forEach(input => {
            input.addEventListener('focus', (e) => {
                this.triggerNeuralEffect(e.target.closest('.smart-field'));
            });
        });
    }

    triggerNeuralEffect(field) {
        const indicator = field.querySelector('.ai-indicator');
        if (!indicator) return;
        indicator.style.opacity = '1';
        setTimeout(() => indicator.style.opacity = '', 2000);
    }

    validateEmail() {
        const email = this.emailInput.value.trim();
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email) return this.showError('email', 'Email required'), false;
        if (!regex.test(email)) return this.showError('email', 'Invalid email format'), false;
        this.clearError('email');
        return true;
    }

    validatePassword() {
        const pass = this.passwordInput.value;
        if (!pass) return this.showError('password', 'Password required'), false;
        if (pass.length < 6) return this.showError('password', 'Password must be 6+ chars'), false;
        this.clearError('password');
        return true;
    }

    showError(field, msg) {
        const fieldEl = document.getElementById(field).closest('.smart-field');
        const errorEl = document.getElementById(`${field}Error`);
        if (fieldEl) fieldEl.classList.add('error');
        if (errorEl) errorEl.textContent = msg;
        this.showPopup(msg);
    }

    clearError(field) {
        const fieldEl = document.getElementById(field).closest('.smart-field');
        const errorEl = document.getElementById(`${field}Error`);
        if (fieldEl) fieldEl.classList.remove('error');
        if (errorEl) errorEl.textContent = '';
    }

    showPopup(msg) {
        this.errorPopup.textContent = msg;
        this.errorPopup.classList.add('show');
        setTimeout(() => this.errorPopup.classList.remove('show'), 3000);
    }

    setLoading(loading) {
        this.submitButton.classList.toggle('loading', loading);
        this.submitButton.disabled = loading;
        this.socialButtons.forEach(btn => {
            btn.style.pointerEvents = loading ? 'none' : 'auto';
            btn.style.opacity = loading ? '0.5' : '1';
        });
    }

    async handleSubmit(e) {
        e.preventDefault();
        if (!this.validateEmail() || !this.validatePassword()) return;

        this.setLoading(true);

        const formData = new FormData(this.form);

        try {
            const res = await fetch('login.php', {
                method: 'POST',
                body: formData
            });
            const data = await res.json();

            if (data.success) {
                // Neural success animation
                this.showNeuralSuccess();
            } else {
                this.showPopup(data.message || 'Login failed');
                this.setLoading(false);
            }
        } catch (err) {
            this.showPopup('Server error. Try again.');
            this.setLoading(false);
        }
    }

    async handleSocialLogin(provider, button) {
        const originalHTML = button.innerHTML;
        button.style.pointerEvents = 'none';
        button.style.opacity = '0.7';
        button.innerHTML = `<span>Connecting...</span>`;
        try { await new Promise(r => setTimeout(r, 2000)); } 
        catch {}
        finally {
            button.style.pointerEvents = 'auto';
            button.style.opacity = '1';
            button.innerHTML = originalHTML;
        }
    }

    showNeuralSuccess() {
        this.form.style.transform = 'scale(0.95)';
        this.form.style.opacity = '0';
        setTimeout(() => {
            this.form.style.display = 'none';
            document.querySelector('.neural-social').style.display = 'none';
            document.querySelector('.signup-section').style.display = 'none';
            document.querySelector('.auth-separator').style.display = 'none';
            this.successMessage.classList.add('show');
        }, 300);
        setTimeout(() => window.location.href = 'dashboard.php', 3200);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new AIAssistantLoginForm();
});

class AIAssistantSignupForm {
    constructor() {
        this.form = document.getElementById('signupForm');
        if (!this.form) return;

        this.nameInput = document.getElementById('name');
        this.emailInput = document.getElementById('email');
        this.passwordInput = document.getElementById('password');
        this.submitButton = this.form.querySelector('.neural-button');
        this.successMessage = document.getElementById('successMessage');

        // Error popup
        this.errorPopup = document.createElement('div');
        this.errorPopup.className = 'popup-error';
        document.body.appendChild(this.errorPopup);

        this.init();
    }

    init() {
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));

        // Optional: placeholder animations for smart fields
        [this.nameInput, this.emailInput, this.passwordInput].forEach(input => {
            input.setAttribute('placeholder', ' ');
            input.addEventListener('blur', () => this.validateField(input));
            input.addEventListener('input', () => this.clearError(input));
        });
    }

    validateField(input) {
        const value = input.value.trim();
        const id = input.id;
        if (!value) return this.showError(id, `${input.previousElementSibling.textContent} is required`);
        if (id === 'email') {
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!regex.test(value)) return this.showError(id, 'Invalid email format');
        }
        if (id === 'password' && value.length < 6) return this.showError(id, 'Password must be 6+ characters');
        this.clearError(input);
        return true;
    }

    showError(fieldId, msg) {
        const fieldEl = document.getElementById(fieldId).closest('.smart-field');
        const errorEl = document.getElementById(`${fieldId}Error`);
        if (fieldEl) fieldEl.classList.add('error');
        if (errorEl) errorEl.textContent = msg;
        this.showPopup(msg);
    }

    clearError(input) {
        const fieldEl = input.closest('.smart-field');
        const errorEl = document.getElementById(`${input.id}Error`);
        if (fieldEl) fieldEl.classList.remove('error');
        if (errorEl) errorEl.textContent = '';
    }

    showPopup(msg) {
        this.errorPopup.textContent = msg;
        this.errorPopup.classList.add('show');
        setTimeout(() => this.errorPopup.classList.remove('show'), 3000);
    }

    setLoading(loading) {
        this.submitButton.classList.toggle('loading', loading);
        this.submitButton.disabled = loading;
    }

    async handleSubmit(e) {
        e.preventDefault();

        // Validate all fields
        if (!this.validateField(this.nameInput) || 
            !this.validateField(this.emailInput) || 
            !this.validateField(this.passwordInput)) return;

        this.setLoading(true);

        const formData = new FormData(this.form);

        try {
            const res = await fetch('signup.php', {
                method: 'POST',
                body: formData
            });
            const data = await res.json();

            if (data.success) {
                // Hide form and show neural success
                this.form.style.transform = 'scale(0.95)';
                this.form.style.opacity = '0';
                setTimeout(() => {
                    this.form.style.display = 'none';
                    this.successMessage.classList.add('show');
                }, 300);

                // Redirect after 3 seconds
                setTimeout(() => window.location.href = 'dashboard.php', 3000);
            } else {
                this.showPopup(data.message || 'Signup failed');
            }
        } catch (err) {
            this.showPopup('Server error. Try again.');
        } finally {
            this.setLoading(false);
        }
    }
}

// Initialize signup form
document.addEventListener('DOMContentLoaded', () => {
    new AIAssistantSignupForm();
});
