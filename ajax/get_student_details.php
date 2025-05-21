<?php
// Include database connection
include "../config/connection.php";

// Get student ID from request
$studentId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($studentId === 0) {
    // Return error if no ID provided
    header('Content-Type: application/json');
    echo json_encode(['error' => 'No student ID provided']);
    exit;
}

// Get student details with engagement and experience information
$query = "SELECT s.*, e.engagement_type, e.destination_country, e.institution_name,
          er.inspiration, er.wished_to_know, er.advice, er.personal_change
          FROM students s
          LEFT JOIN engagements e ON s.student_id = e.student_id
          LEFT JOIN experience_responses er ON s.student_id = er.student_id
          WHERE s.student_id = ?";

$stmt = $connection->prepare($query);
$stmt->bind_param("i", $studentId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Return error if student not found
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Student not found']);
    exit;
}

$student = $result->fetch_assoc();

// Return student data as JSON
header('Content-Type: application/json');
echo json_encode($student);
?>