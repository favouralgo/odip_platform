<?php
// Start session
session_start();

// Check if user is logged in as admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Include database connection
include "../config/connection.php";

// Check if student ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error_message'] = "No student ID provided.";
    header("Location: students.php");
    exit;
}

$student_id = (int)$_GET['id'];

// Start transaction
$connection->begin_transaction();

try {
    // Delete any pictures first
    $pictureQuery = "DELETE FROM student_pictures WHERE student_id = ?";
    $stmt = $connection->prepare($pictureQuery);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    
    // Delete from experience_responses
    $responseQuery = "DELETE FROM experience_responses WHERE student_id = ?";
    $stmt = $connection->prepare($responseQuery);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    
    // Delete from engagements
    $engagementQuery = "DELETE FROM engagements WHERE student_id = ?";
    $stmt = $connection->prepare($engagementQuery);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    
    // Finally delete the student
    $studentQuery = "DELETE FROM students WHERE student_id = ?";
    $stmt = $connection->prepare($studentQuery);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    
    // Commit the transaction
    $connection->commit();
    
    // Also delete the student's profile picture file if it exists
    $picture_path = "../uploads/student_" . $student_id . ".jpg";
    if (file_exists($picture_path)) {
        unlink($picture_path);
    }
    
    $_SESSION['success_message'] = "Student record successfully deleted.";
} catch (Exception $e) {
    // Rollback transaction on error
    $connection->rollback();
    $_SESSION['error_message'] = "Error deleting student: " . $e->getMessage();
}

// Redirect back to students page
header("Location: students.php");
exit;
?>