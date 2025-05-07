<?php
// Start the session
// session_start();

// Check if user is logged in and is an admin
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
//     header("Location: ../auth/login.php");
//     exit;
// }

// Include database connection
include "../config/connection.php";

// Handle application status update (approve/reject)
// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['engagement_id'])) {
//     $action = $_POST['action'];
//     $engagementId = intval($_POST['engagement_id']);
//     $status = ($action === 'approve') ? 'approved' : 'rejected';

//     $stmt = $connection->prepare("UPDATE engagements SET status = ? WHERE engagement_id = ?");
//     $stmt->bind_param("si", $status, $engagementId);

//     if ($stmt->execute()) {
//         $_SESSION['message'] = "Application has been successfully " . ucfirst($status) . ".";
//     } else {
//         $_SESSION['error'] = "Failed to update application status.";
//     }

//     $stmt->close();
//     header("Location: applications.php");
//     exit;
// }

// Fetch all pending applications
// $query = "SELECT e.engagement_id, e.engagement_type, e.destination_country, e.institution_name, e.status, 
//                  s.name AS student_name, s.year_group, s.major, s.nationality
//           FROM engagements e
//           JOIN students s ON e.student_id = s.student_id
//           WHERE e.status = 'pending'
//           ORDER BY e.created_at DESC";
// $result = $connection->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Applications - ODIP International Engagement</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/students.css">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2><i class="fas fa-globe-americas"></i> Dashboard</h2>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li><a href="admindashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="students.php"><i class="fas fa-user-graduate"></i> Manage Students</a></li>
                <li class="active"><a href="applications.php"><i class="fas fa-file-alt"></i> Applications</a></li>
                <li><a href="announcements.php"><i class="fas fa-bullhorn"></i> Announcements</a></li>
                <li><a href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
                <li><a href="../auth/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <header>
            <div class="header-content">
                <h3><i class="fas fa-file-alt"></i> Manage Applications</h3>
            </div>
        </header>

        <div class="dashboard-wrapper">
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-success">
                    <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <div class="content-card">
                <div class="card-header">
                    <div class="card-title">
                        <h2><i class="fas fa-users"></i> Pending Applications</h2>
                    </div>
                </div>
                <div class="card-body">
                    <!-- <?php if ($result->num_rows > 0): ?>
                        <div class="table-responsive">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Year Group</th>
                                        <th>Major</th>
                                        <th>Nationality</th>
                                        <th>Engagement Type</th>
                                        <th>Destination</th>
                                        <th>Institution</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['year_group']); ?></td>
                                            <td><?php echo htmlspecialchars($row['major']); ?></td>
                                            <td><?php echo htmlspecialchars($row['nationality']); ?></td>
                                            <td><?php echo htmlspecialchars($row['engagement_type']); ?></td>
                                            <td><?php echo htmlspecialchars($row['destination_country']); ?></td>
                                            <td><?php echo htmlspecialchars($row['institution_name']); ?></td>
                                            <td><span class="status-badge status-pending">Pending</span></td>
                                            <td>
                                                <form method="POST" style="display: inline-block;">
                                                    <input type="hidden" name="engagement_id" value="<?php echo $row['engagement_id']; ?>">
                                                    <button type="submit" name="action" value="approve" class="btn btn-success">
                                                        <i class="fas fa-check"></i> Approve
                                                    </button>
                                                </form>
                                                <form method="POST" style="display: inline-block;">
                                                    <input type="hidden" name="engagement_id" value="<?php echo $row['engagement_id']; ?>">
                                                    <button type="submit" name="action" value="reject" class="btn btn-danger">
                                                        <i class="fas fa-times"></i> Reject
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?> -->
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <h3>No Pending Applications</h3>
                            <p>There are no applications awaiting approval or rejection at this time.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>