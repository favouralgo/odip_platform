<?php

// Function to check if user is logged in
function checkLogin() {
    // Start session
    session_start();

    // Check if userId session exists
    if (!isset($_SESSION['username'])) {
        // Redirect to login page if session doesn't exist
        header("Location: login.php");
        // Terminate script execution after redirection
        die();
    }
}

?>