<!-- <?php
// Start the session
// session_start();

// Check if user is logged in
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
//     header("Location: auth/login.php");
//     exit;
// }

// Include database connection
// include "../config/connection.php";

// Fetch dashboard stats
// $stats = [
//     'total' => 0,
//     'approved' => 0,
//     'pending' => 0,
//     'rejected' => 0
// ];

// Get total students count
// $query = "SELECT COUNT(*) as total FROM students";
// $result = mysqli_query($conn, $query);
// if ($result) {
//     $stats['total'] = mysqli_fetch_assoc($result)['total'];
// }

// Get counts by status
// $statusQuery = "SELECT 
//                 COUNT(CASE WHEN status = 'approved' THEN 1 END) as approved,
//                 COUNT(CASE WHEN status = 'pending' THEN 1 END) as pending,
//                 COUNT(CASE WHEN status = 'rejected' THEN 1 END) as rejected
//                 FROM engagements";
// $statusResult = mysqli_query($conn, $statusQuery);
// if ($statusResult) {
//     $statusCounts = mysqli_fetch_assoc($statusResult);
//     $stats['approved'] = $statusCounts['approved'];
//     $stats['pending'] = $statusCounts['pending'];
//     $stats['rejected'] = $statusCounts['rejected'];
// }

// Get recent students with their engagement details
// $studentsQuery = "SELECT s.student_id, s.name, s.year_group, s.major as course, s.nationality, 
//                 e.engagement_type, e.status, e.engagement_id
//                 FROM students s
//                 LEFT JOIN engagements e ON s.student_id = e.student_id
//                 ORDER BY s.created_at DESC
//                 LIMIT 10";
// $studentsResult = mysqli_query($conn, $studentsQuery);
// ?> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ODIP International Engagement - Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2><i class="fas fa-globe-americas"></i> Dashboard</h2>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li class="active"><a href="admindashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="students.php"><i class="fas fa-user-graduate"></i> Manage Students</a></li>
                <li><a href="applications.php"><i class="fas fa-file-alt"></i> Applications</a></li>
                <li><a href="reports.php"><i class="fas fa-chart-bar"></i> Reports</a></li>
                <li><a href="announcements.php"><i class="fas fa-bullhorn"></i> Announcements</a></li>
                <li><a href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
                <li><a href="auth/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <header>
            <div class="header-content">
                <div class="header-search">
                    <input type="text" placeholder="Search...">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </div>
                <div class="header-profile">
                    <div class="profile-img">
                        <img src="../assets/images/admin-avatar.png" alt="Admin">
                    </div>
                    <div class="profile-info">
                        <p>Welcome, <strong><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Admin'; ?></strong></p>
                        <small><?php echo date('l, F j, Y'); ?></small>
                    </div>
                </div>
            </div>
        </header>

        <div class="dashboard-wrapper">
            <div class="dashboard-header">
                <h1>Dashboard Overview</h1>
                <div class="action-buttons">
                    <a href="https://forms.office.com/r/Z5qwX9L27u" target="_blank" class="btn btn-primary">
                        <i class="fas fa-file-alt"></i> Fill Out ODIP Form
                    </a>
                    <a href="import.php" class="btn btn-secondary">
                        <i class="fas fa-file-import"></i> Import Excel Data
                    </a>
                </div>
            </div>

            <div class="dashboard-stats">
                <div class="stat-card total">
                    <div class="stat-card-content">
                        <div class="stat-card-info">
                            <h3>Total Students</h3>
                            <!-- <p class="stat-number"><?php echo $stats['total']; ?></p> -->
                        </div>
                        <div class="stat-card-icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="stat-card-footer">
                        <a href="students.php">View All <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <div class="stat-card approved">
                    <div class="stat-card-content">
                        <div class="stat-card-info">
                            <h3>Approved</h3>
                            <!-- <p class="stat-number"><?php echo $stats['approved']; ?></p> -->
                        </div>
                        <div class="stat-card-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                    <div class="stat-card-footer">
                        <a href="applications.php?status=approved">View All <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <div class="stat-card pending">
                    <div class="stat-card-content">
                        <div class="stat-card-info">
                            <h3>Pending</h3>
                            <!-- <p class="stat-number"><?php echo $stats['pending']; ?></p> -->
                        </div>
                        <div class="stat-card-icon">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                    </div>
                    <div class="stat-card-footer">
                        <a href="applications.php?status=pending">View All <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <div class="stat-card rejected">
                    <div class="stat-card-content">
                        <div class="stat-card-info">
                            <h3>Rejected</h3>
                            <!-- <p class="stat-number"><?php echo $stats['rejected']; ?></p> -->
                        </div>
                        <div class="stat-card-icon">
                            <i class="fas fa-times-circle"></i>
                        </div>
                    </div>
                    <div class="stat-card-footer">
                        <a href="applications.php?status=rejected">View All <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <div class="dashboard-content">
                <div class="content-card student-table-card">
                    <div class="card-header">
                        <div class="card-title">
                            <h2><i class="fas fa-globe"></i> Students Abroad / Conference</h2>
                        </div>
                        <div class="card-actions">
                            <a href="export.php" class="btn-icon" title="Export Data">
                                <i class="fas fa-file-export"></i>
                            </a>
                            <a href="students.php" class="btn-small">View All</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Year Group</th>
                                        <th>Course</th>
                                        <th>Nationality</th>
                                        <th>Type of Engagement</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // if (mysqli_num_rows($studentsResult) > 0) {
                                    //     while ($row = mysqli_fetch_assoc($studentsResult)) {
                                    //         $status = isset($row['status']) ? $row['status'] : 'pending';
                                    //         $statusClass = '';
                                            
                                    //         switch ($status) {
                                    //             case 'approved':
                                    //                 $statusClass = 'status-approved';
                                    //                 break;
                                    //             case 'rejected':
                                    //                 $statusClass = 'status-rejected';
                                    //                 break;
                                    //             default:
                                    //                 $statusClass = 'status-pending';
                                    //                 break;
                                    //         }
                                            
                                    //         echo "<tr>";
                                    //         echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                    //         echo "<td>" . htmlspecialchars($row['year_group']) . "</td>";
                                    //         echo "<td>" . htmlspecialchars($row['course']) . "</td>";
                                    //         echo "<td>" . htmlspecialchars($row['nationality']) . "</td>";
                                    //         echo "<td>" . htmlspecialchars($row['engagement_type'] ?? 'Not specified') . "</td>";
                                    //         echo "<td><span class='status-badge {$statusClass}'>" . ucfirst($status) . "</span></td>";
                                    //         echo "<td class='action-buttons'>";
                                    //         echo "<a href='view_student.php?id=" . $row['student_id'] . "' class='btn-icon' title='View'><i class='fas fa-eye'></i></a>";
                                    //         echo "<a href='edit_student.php?id=" . $row['student_id'] . "' class='btn-icon' title='Edit'><i class='fas fa-edit'></i></a>";
                                    //         echo "<a href='#' class='btn-icon' onclick='confirmDelete(" . $row['student_id'] . ")' title='Delete'><i class='fas fa-trash'></i></a>";
                                    //         echo "</td>";
                                    //         echo "</tr>";
                                    //     }
                                    // } else {
                                    //     echo "<tr><td colspan='7' class='text-center'>No students found</td></tr>";
                                    // }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="row-cards">
                    <div class="content-card">
                        <div class="card-header">
                            <div class="card-title">
                                <h2><i class="fas fa-chart-pie"></i> Engagement Types</h2>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="engagementChart"></canvas>
                        </div>
                    </div>
                    
                    <div class="content-card">
                        <div class="card-header">
                            <div class="card-title">
                                <h2><i class="fas fa-bell"></i> Recent Activities</h2>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="activity-list">
                                <li>
                                    <span class="activity-icon"><i class="fas fa-user-plus"></i></span>
                                    <div class="activity-content">
                                        <p>New student application submitted</p>
                                        <small>2 hours ago</small>
                                    </div>
                                </li>
                                <li>
                                    <span class="activity-icon"><i class="fas fa-check-circle"></i></span>
                                    <div class="activity-content">
                                        <p>Student application approved</p>
                                        <small>Yesterday</small>
                                    </div>
                                </li>
                                <li>
                                    <span class="activity-icon"><i class="fas fa-file-import"></i></span>
                                    <div class="activity-content">
                                        <p>Excel data imported</p>
                                        <small>3 days ago</small>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    
    <script>
        // Function to confirm deletion
        function confirmDelete(studentId) {
            if (confirm('Are you sure you want to delete this student?')) {
                window.location.href = 'delete_student.php?id=' + studentId;
            }
        }
        
        // Chart for engagement types
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('engagementChart').getContext('2d');
            
            // Sample data - To be replaced with actual data from our database
            const engagementChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Study abroad', 'Research presentation', 'Conference', 'Internship', 'Other'],
                    datasets: [{
                        data: [30, 20, 25, 15, 10],
                        backgroundColor: [
                            '#4e73df',
                            '#1cc88a',
                            '#36b9cc',
                            '#f6c23e',
                            '#e74a3b'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>