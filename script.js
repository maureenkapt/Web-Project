document.addEventListener('DOMContentLoaded', () => {
    const registrationForm = document.getElementById('registrationForm');
    if (registrationForm) {
        registrationForm.addEventListener('submit', (event) => {
            let isValid = true;

            const usernameInput = document.getElementById('username');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('confirm_password');

            const usernameError = document.getElementById('usernameError');
            const emailError = document.getElementById('emailError');
            const passwordError = document.getElementById('passwordError');
            const confirmPasswordError = document.getElementById('confirmPasswordError');

            usernameError.textContent = '';
            emailError.textContent = '';
            passwordError.textContent = '';
            confirmPasswordError.textContent = '';

            if (!usernameInput.value.trim()) {
                usernameError.textContent = 'Username is required.';
                isValid = false;
            }

            if (!emailInput.value.trim()) {
                emailError.textContent = 'Email is required.';
                isValid = false;
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value)) {
                emailError.textContent = 'Invalid email format.';
                isValid = false;
            }

            if (!passwordInput.value) {
                passwordError.textContent = 'Password is required.';
                isValid = false;
            } else if (passwordInput.value.length < 6) {
                passwordError.textContent = 'Password must be at least 6 characters long.';
                isValid = false;
            }

            if (confirmPasswordInput.value !== passwordInput.value) {
                confirmPasswordError.textContent = 'Passwords do not match.';
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault(); // Prevent form submission if validation fails
            }
        });
    }

    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', (event) => {
            let isValid = true;
            const usernameInput = document.getElementById('username');
            const passwordInput = document.getElementById('password');
            const loginUsernameError = document.getElementById('loginUsernameError');
            const loginPasswordError = document.getElementById('loginPasswordError');

            loginUsernameError.textContent = '';
            loginPasswordError.textContent = '';

            if (!usernameInput.value.trim()) {
                loginUsernameError.textContent = 'Username is required.';
                isValid = false;
            }

            if (!passwordInput.value) {
                loginPasswordError.textContent = 'Password is required.';
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault();
            }
        });
    }

    const submissionForm = document.getElementById('submissionForm');
    if (submissionForm) {
        submissionForm.addEventListener('submit', (event) => {
            // Add client-side validation for your form fields here if needed
        });
    }
});