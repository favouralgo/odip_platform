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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $connection->real_escape_string($_POST['title']);
    $content = $connection->real_escape_string($_POST['content']);
    
    // Update the announcement
    $updateQuery = "UPDATE announcements 
                    SET title = ?, content = ?, updated_at = NOW() 
                    WHERE id = ?";
    
    $stmt = $connection->prepare($updateQuery);
    $stmt->bind_param("ssi", $title, $content, $announcement_id);
    
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Announcement updated successfully!";
        header("Location: announcements.php");
        exit;
    } else {
        $error_message = "Error updating announcement: " . $connection->error;
    }
}

// Get announcement data
$query = "SELECT * FROM announcements WHERE id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $announcement_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error_message'] = "Announcement not found.";
    header("Location: announcements.php");
    exit;
}

$announcement = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Announcement - ODIP International Engagement</title>
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
                <li><a href="admindashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="students.php"><i class="fas fa-user-graduate"></i> Manage Students</a></li>
                <li><a href="applications.php"><i class="fas fa-file-alt"></i> Applications</a></li>
                <li class="active"><a href="announcements.php"><i class="fas fa-bullhorn"></i> Announcements</a></li>
                <li><a href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
                <li><a href="../auth/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <header>
            <div class="header-content">
                <div class="header-title">
                    <a href="announcements.php" class="back-link"><i class="fas fa-arrow-left"></i></a>
                    <h1>Edit Announcement</h1>
                </div>
            </div>
        </header>

        <div class="dashboard-wrapper">
            <?php if (isset($error_message)): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error_message; ?>
                <button class="close-alert"><i class="fas fa-times"></i></button>
            </div>
            <?php endif; ?>

            <div class="content-card">
                <div class="card-header">
                    <div class="card-title">
                        <h2><i class="fas fa-edit"></i> Edit Announcement</h2>
                    </div>
                </div>
                <div class="card-body">
                    <form action="edit_announcement.php?id=<?php echo $announcement_id; ?>" method="post" class="form-container">
                        <div class="form-group">
                            <label for="title">Announcement Title</label>
                            <input type="text" id="title" name="title" placeholder="Enter announcement title" value="<?php echo htmlspecialchars($announcement['title']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="content">Announcement Content</label>
                            <textarea id="content" name="content" rows="8" placeholder="Write your announcement here..." required><?php echo htmlspecialchars($announcement['content']); ?></textarea>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Announcement
                            </button>
                            <a href="announcements.php" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Close alert functionality
        document.addEventListener('DOMContentLoaded', function() {
            const closeButtons = document.querySelectorAll('.close-alert');
            closeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    this.parentElement.style.display = 'none';
                });
            });
        });
    </script>
</body>
</html>