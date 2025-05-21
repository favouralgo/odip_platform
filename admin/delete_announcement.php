<?php
// Start the session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Include database connection
include "../config/connection.php";

// Check if announcement ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error_message'] = "No announcement ID provided.";
    header("Location: announcements.php");
    exit;
}

$announcement_id = (int)$_GET['id'];

// Delete the announcement
$query = "DELETE FROM announcements WHERE id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $announcement_id);

if ($stmt->execute()) {
    $_SESSION['success_message'] = "Announcement deleted successfully!";
} else {
    $_SESSION['error_message'] = "Error deleting announcement: " . $connection->error;
}

// Redirect back to announcements page
header("Location: announcements.php");
exit;
?>