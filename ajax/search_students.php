<?php
// Include database connection
include "../config/connection.php";

// Get search parameters
$search = isset($_GET['keyword']) ? $connection->real_escape_string($_GET['keyword']) : '';
$region = isset($_GET['region']) ? $connection->real_escape_string($_GET['region']) : '';
$year = isset($_GET['year']) ? $connection->real_escape_string($_GET['year']) : '';
$university = isset($_GET['university']) ? $connection->real_escape_string($_GET['university']) : '';

// Build query conditions based on filters
$conditions = [];
if (!empty($search)) {
    $conditions[] = "(s.name LIKE '%$search%' OR s.nationality LIKE '%$search%' OR s.major LIKE '%$search%')";
}
if (!empty($region)) {
    // Group countries by regions - this is a simplified example
    $regions = [
        'Africa' => ['Ghanaian', 'Nigerian', 'Kenyan', 'South African'],
        'Europe' => ['British', 'French', 'German', 'Italian'],
        'Asia' => ['Chinese', 'Japanese', 'Indian', 'Korean'],
        'Americas' => ['American', 'Canadian', 'Brazilian', 'Mexican']
    ];
    
    if (isset($regions[$region])) {
        $countries = "'" . implode("','", $regions[$region]) . "'";
        $conditions[] = "s.nationality IN ($countries)";
    }
}
if (!empty($year)) {
    $conditions[] = "s.year_group = '$year'";
}
if (!empty($university)) {
    $conditions[] = "e.institution_name LIKE '%$university%'";
}

// Combine conditions for the WHERE clause
$whereClause = !empty($conditions) ? "WHERE " . implode(' AND ', $conditions) : "";

// Get all students with their engagement details
$query = "SELECT s.student_id, s.name, s.year_group, s.major, s.nationality, s.has_picture,
          e.engagement_type, e.destination_country, e.institution_name
          FROM students s
          LEFT JOIN engagements e ON s.student_id = e.student_id
          $whereClause
          ORDER BY s.name ASC";

$result = $connection->query($query);
$students = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
}

// Return results as JSON
header('Content-Type: application/json');
echo json_encode($students);
?>