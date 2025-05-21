<?php
// Include database connection
require_once '../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and retrieve form data
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    
    // Validation
    $errors = [];
    
    if (empty($email)) {
        $errors[] = "Email is required.";
    }
    
    if (empty($password)) {
        $errors[] = "Password is required.";
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    
    // If no errors, proceed with login
    if (empty($errors)) {
        // Check if the user exists
        $stmt = $connection->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            // User doesn't exist - but for security, show generic message
            $_SESSION['login_error'] = "Invalid email or password.";
            header("Location: ../auth/login.php");
            exit();
        }
        
        // Fetch user data
        $user = $result->fetch_assoc();
        
        // Verify the password
        if (!password_verify($password, $user['password'])) {
            $_SESSION['login_error'] = "Invalid email or password.";
            header("Location: ../auth/login.php");
            exit();
        }
        
        // Start a session and store user information
        session_start();
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        
        // Redirect to the dashboard
        header('Location: ../admin/admindashboard.php');
        exit();
    } else {
        // Store errors in session and redirect back to login
        session_start();
        $_SESSION['login_errors'] = $errors;
        header("Location: ../auth/login.php");
        exit();
    }
}

$connection->close();
?>