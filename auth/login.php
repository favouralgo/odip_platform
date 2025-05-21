<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <!-- Login Form -->
            <div id="login-form" class="form active">
                <h2>Login to Your Account</h2>
                
                <?php if (isset($_SESSION['login_error'])): ?>
                <div class="alert alert-danger">
                    <?php echo $_SESSION['login_error']; unset($_SESSION['login_error']); ?>
                </div>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['signup_success'])): ?>
                <div class="alert alert-success">
                    <?php echo $_SESSION['signup_success']; unset($_SESSION['signup_success']); ?>
                </div>
                <?php endif; ?>
                
                <form id="login-form" name="lf" role="login" action="../actions/login_action.php" method="POST">
                    <div class="form-group">
                        <label for="login-email">Email Address</label>
                        <input type="email" name="email" id="login-email" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label for="login-password">Password</label>
                        <input type="password" name="password" id="login-password" placeholder="Enter your password" required>
                    </div>
                    <div class="form-options">
                        <div class="remember-me">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Remember me</label>
                        </div>
                        <a href="#" class="forgot-password">Forgot Password?</a>
                    </div>
                    <button type="submit" class="submit-btn">Login</button>
                    
                    <div class="form-footer">
                        <p>Don't have an account? <a href="signup.php" class="login-link">Sign up</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="../assets/js/script.js"></script>
</body>
</html>