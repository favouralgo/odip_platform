document.addEventListener('DOMContentLoaded', function() {
    // Password visibility toggle
    const passwordFields = document.querySelectorAll('input[type="password"]');
    
    passwordFields.forEach(passwordField => {
        // Create eye icon
        const eyeIcon = document.createElement('span');
        eyeIcon.classList.add('eye-icon');
        eyeIcon.innerHTML = '👁️';
        
        // Wrap password input
        const wrapper = document.createElement('div');
        wrapper.classList.add('password-wrapper');
        passwordField.parentNode.insertBefore(wrapper, passwordField);
        wrapper.appendChild(passwordField);
        wrapper.appendChild(eyeIcon);
        
        // Toggle password visibility
        eyeIcon.addEventListener('click', function() {
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.textContent = '🙈';
            } else {
                passwordField.type = 'password';
                eyeIcon.textContent = '👁️';
            }
        });
    });

    // Form validation for signup page
    const signupForm = document.getElementById('signup-form');
    if (signupForm) {
        signupForm.addEventListener('submit', function(event) {
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm_password');
            
            // Password match validation
            if (password.value !== confirmPassword.value) {
                alert('Passwords do not match. Please try again.');
                event.preventDefault();
                return;
            }

            // Password strength validation
            const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            if (!passwordRegex.test(password.value)) {
                alert('Password must be at least 8 characters long and include uppercase, lowercase, number, and special character.');
                event.preventDefault();
            }
        });
    }
});