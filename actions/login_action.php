<?php
// Include database connection
require_once '../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and retrieve form data
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    // Validate form data
    if (empty($email) || empty($password)) {
        echo('Email and password are required.');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo('Invalid email format.');
    }

    // Check if the user exists
    $stmt = $connection->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo('Invalid email or password.');
    }

    // Fetch user data
    $user = $result->fetch_assoc();

    // Verify the password
    if (!password_verify($password, $user['password'])) {
        echo('Invalid email or password.');
    }

    // Start a session and store user information
    session_start();
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];

    // Redirect to the dashboard or home page
    header('Location: ../admin/admindashboard.php');
    exit();
}

$connection->close();
?>
