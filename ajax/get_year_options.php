<?php
// Include database connection
include "../config/connection.php";

// Get unique year groups for filter
$yearQuery = "SELECT DISTINCT year_group FROM students ORDER BY year_group DESC";
$yearResult = $connection->query($yearQuery);
$yearOptions = [];

if ($yearResult) {
    while ($row = $yearResult->fetch_assoc()) {
        $yearOptions[] = $row['year_group'];
    }
}

// Return results as JSON
header('Content-Type: application/json');
echo json_encode($yearOptions);
?>