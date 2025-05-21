<?php
// Include database connection
require_once '../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $firstName = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastName = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    
    // Initialize error array
    $errors = [];
    
    // Validate form data
    if (empty($firstName) || empty($lastName) || empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        $errors[] = 'All fields are required.';
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format.';
    }
    
    if ($password !== $confirmPassword) {
        $errors[] = 'Passwords do not match.';
    }
    
    // Password strength validation
    $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
    if (!preg_match($passwordRegex, $password)) {
        $errors[] = 'Password must be at least 8 characters and include uppercase, lowercase, number, and special character.';
    }
    
    // If there are no errors, proceed with registration
    if (empty($errors)) {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
        // Start a transaction for database operations
        $connection->begin_transaction();
        
        try {
            // Check if the email or username already exists
            $stmt = $connection->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
            $stmt->bind_param("ss", $email, $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                throw new Exception('Email or username already exists.');
            }
            
            // Insert the new user into the database
            $stmt = $connection->prepare("INSERT INTO users (username, email, password, first_name, last_name, role) VALUES (?, ?, ?, ?, ?, 'admin')");
            $stmt->bind_param("sssss", $username, $email, $hashedPassword, $firstName, $lastName);
            
            if (!$stmt->execute()) {
                throw new Exception('Error creating account: ' . $stmt->error);
            }
            
            // Commit the transaction
            $connection->commit();
            
            // Set success message in session
            session_start();
            $_SESSION['signup_success'] = 'Signup successful. You can now log in.';
            
            // Redirect to login page
            header('Location: ../auth/login.php');
            exit();
            
        } catch (Exception $e) {
            // Rollback transaction on error
            $connection->rollback();
            
            // Store error in session
            session_start();
            $_SESSION['signup_error'] = $e->getMessage();
            
            // Redirect back to signup form
            header('Location: ../auth/signup.php');
            exit();
        }
    } else {
        // Store errors in session
        session_start();
        $_SESSION['signup_errors'] = $errors;
        
        // Redirect back to signup form
        header('Location: ../auth/signup.php');
        exit();
    }
}

// Close database connection
$connection->close();
?>