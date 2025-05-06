<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            
            <!-- Signup Form -->
            <div id="signup-form" class="form active">
                <h2>Create an Account</h2>
                <form id="signup-form" name="sf" role="sign-up" action="../actions/signup_action.php" method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="first-name">First Name</label>
                            <input type="text" name="first_name" id="first_name" placeholder="First name" required>
                        </div>
                        <div class="form-group">
                            <label for="last-name">Last Name</label>
                            <input type="text" name="last_name" id="last_name" placeholder="Last name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="user-name">Username</label>
                        <input type="text" name="username" id="username" placeholder="Choose a username" required>
                    </div>
                    <div class="form-group">
                        <label for="signup-email">Email Address</label>
                        <input type="email" name="email" id="email" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label for="signup-password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Create a password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm your password" required>
                    </div>
                
                    <button type="submit" name="submit" class="submit-btn">Sign Up</button>
                    
                    <div class="form-footer">
                        <p>Already have an account? <a href="login.php" class="login-link">Login here</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../assets/js/script.js"></script>
</body>
</html>