<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Signup Form</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <!-- Tab Switcher -->
            <div class="tabs">
                <button class="tab-btn active" data-target="login-form">Login</button>
                <button class="tab-btn" data-target="signup-form">Sign Up</button>
            </div>
            
            <!-- Login Form -->
            <div id="login-form" class="form active">
                <h2>Login to Your Account</h2>
                <form id="login-form" name="lf" role="login" action="../actions/login_action.php" method="POST">
                    <div class="form-group">
                        <label for="login-email">Email Address</label>
                        <input type="email" id="login-email" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label for="login-password">Password</label>
                        <input type="password" id="login-password" placeholder="Enter your password" required>
                    </div>
                    <div class="form-options">
                        <div class="remember-me">
                            <input type="checkbox" id="remember">
                            <label for="remember">Remember me</label>
                        </div>
                        <a href="#" class="forgot-password">Forgot Password?</a>
                    </div>
                    <button type="submit" class="submit-btn">Login</button>
                </form>
            </div>
            
            <!-- Signup Form -->
            <div id="signup-form" class="form">
                <h2>Create an Account</h2>
                <form id="signup-form" name="sf" role="sign-up" action="../actions/signup_action.php'" method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="first-name">First Name</label>
                            <input type="text" id="first_name" placeholder="First name" required>
                        </div>
                        <div class="form-group">
                            <label for="last-name">Last Name</label>
                            <input type="text" id="last_name" placeholder="Last name" required>
                        </div>
                        <div class="form-group">
                            <label for="user-name">Last Name</label>
                            <input type="text" name="username" id="username" class="username" placeholder="Last name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="signup-email">Email Address</label>
                        <input type="email" name="email" id="email" class="email" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label for="signup-password">Password</label>
                        <input type="password" name="password" id="password" class="password" placeholder="Create a password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="password" placeholder="Confirm your password" required>
                    </div>
                
                    <button type="submit" name="submit" class="submit-btn">Sign Up</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Simple JavaScript to switch between forms
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-btn');
            
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons and forms
                    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
                    document.querySelectorAll('.form').forEach(form => form.classList.remove('active'));
                    
                    // Add active class to clicked button
                    this.classList.add('active');
                    
                    // Show corresponding form
                    const targetForm = this.getAttribute('data-target');
                    document.getElementById(targetForm).classList.add('active');
                });
            });
        });
    </script>
</body>
</html>