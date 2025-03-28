class AuthService {
    constructor() {
        this.baseUrl = 'http://127.0.0.1:8000/api';
        this.token = localStorage.getItem('token');
    }

    // Registration Method
    async register(formData) {
        try {
            const response = await fetch(`${this.baseUrl}/register`, {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(JSON.stringify(errorData));
            }

            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Registration Error:', error);
            throw error;
        }
    }

    // Login Method
    async login(email, password) {
        try {
            const response = await fetch(`${this.baseUrl}/login`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ email, password })
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Login failed');
            }

            const data = await response.json();
            
            // Store the token
            if (data.token) {
                localStorage.setItem('token', data.token);
                this.token = data.token;
            }

            return data;
        } catch (error) {
            console.error('Login Error:', error);
            throw error;
        }
    }

    // Password Reset Method
    async resetPassword(email, password) {
        try {
            const response = await fetch(`${this.baseUrl}/reset-password`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ email, password })
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Password reset failed');
            }

            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Password Reset Error:', error);
            throw error;
        }
    }

    // Token Refresh Method
    async refreshToken() {
        try {
            // Ensure we have a current token
            if (!this.token) {
                throw new Error('No token available');
            }

            const response = await fetch(`${this.baseUrl}/refresh`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${this.token}`,
                    'Content-Type': 'application/json',
                }
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Token refresh failed');
            }

            const data = await response.json();
            
            // Update the stored token
            if (data.token) {
                localStorage.setItem('token', data.token);
                this.token = data.token;
            }

            return data;
        } catch (error) {
            console.error('Token Refresh Error:', error);
            // If refresh fails, potentially log out the user
            this.logout();
            throw error;
        }
    }

    // Logout Method (not in the controller, but typically needed)
    logout() {
        localStorage.removeItem('token');
        this.token = null;
    }

    // Helper method to check if user is authenticated
    isAuthenticated() {
        return !!this.token;
    }
}

// Example usage
document.addEventListener('DOMContentLoaded', () => {
    const authService = new AuthService();

    // Registration Form Handler
    const registrationForm = document.querySelector('form[action*="register"]');
    if (registrationForm) {
        registrationForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(registrationForm);

            try {
                const result = await authService.register(formData);
                Swal.fire({
                    icon: 'success',
                    title: 'Inscription réussie !',
                    text: 'Votre compte a été créé avec succès.',
                });
                // Optionally redirect or reset form
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur d\'inscription',
                    text: error.message,
                });
            }
        });
    }

    // Login Form Handler
    const loginForm = document.querySelector('form[action*="login"]');
    if (loginForm) {
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = loginForm.querySelector('input[name="email"]').value;
            const password = loginForm.querySelector('input[name="password"]').value;

            try {
                const result = await authService.login(email, password);
                Swal.fire({
                    icon: 'success',
                    title: 'Connexion réussie !',
                    text: 'Vous êtes maintenant connecté.',
                });
                // Redirect to dashboard or home page
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur de connexion',
                    text: error.message,
                });
            }
        });
    }

    // Password Reset Form Handler
    const resetPasswordForm = document.querySelector('form[action*="reset-password"]');
    if (resetPasswordForm) {
        resetPasswordForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = resetPasswordForm.querySelector('input[name="email"]').value;
            const password = resetPasswordForm.querySelector('input[name="password"]').value;

            try {
                const result = await authService.resetPassword(email, password);
                Swal.fire({
                    icon: 'success',
                    title: 'Mot de passe réinitialisé',
                    text: 'Votre mot de passe a été mis à jour avec succès.',
                });
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur de réinitialisation',
                    text: error.message,
                });
            }
        });
    }
});

export default AuthService;