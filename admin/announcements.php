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

// Fetch existing announcements
// $query = "SELECT * FROM announcements ORDER BY created_at DESC";
// $result = mysqli_query($conn, $query);
// $announcements = [];

// if ($result) {
//     while ($row = mysqli_fetch_assoc($result)) {
//         $announcements[] = $row;
//     }
// }

// Handle form submission
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $title = mysqli_real_escape_string($conn, $_POST['title']);
//     $content = mysqli_real_escape_string($conn, $_POST['content']);
    
//     $insertQuery = "INSERT INTO announcements (title, content, created_by) 
//                    VALUES ('$title', '$content', {$_SESSION['user_id']})";
    
//     if (mysqli_query($conn, $insertQuery)) {
//         // Redirect to avoid form resubmission
//         header("Location: announcements.php?success=1");
//         exit;
//     } else {
//         $error = "Error: " . mysqli_error($conn);
//     }
// }
?> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements - ODIP International Engagement</title>
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
                <div class="header-search">
                    <input type="text" placeholder="Search announcements...">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </div>
                <div class="header-profile">
                    <div class="profile-img">
                        <img src="../assets/images/admin-avatar.png" alt="Admin">
                    </div>
                    <!-- <div class="profile-info">
                        <p>Welcome, <strong><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Admin'; ?></strong></p>
                        <small><?php echo date('l, F j, Y'); ?></small>
                    </div> -->
                </div>
            </div>
        </header>

        <div class="dashboard-wrapper">
            <div class="dashboard-header">
                <h1><i class="fas fa-bullhorn"></i> Announcements</h1>
                <div class="action-buttons">
                    <a href="#create-announcement" class="btn btn-primary">
                        <i class="fas fa-plus"></i> New Announcement
                    </a>
                </div>
            </div>

            <!-- <?php if (isset($_GET['success'])): ?> -->
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> Announcement has been published successfully!
                <button class="close-alert"><i class="fas fa-times"></i></button>
            </div>
            <!-- <?php endif; ?> -->

            <!-- <?php if (isset($error)): ?> -->
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                <button class="close-alert"><i class="fas fa-times"></i></button>
            </div>
            <!-- <?php endif; ?> -->

            <div class="dashboard-content">
                <div class="content-card" id="create-announcement">
                    <div class="card-header">
                        <div class="card-title">
                            <h2><i class="fas fa-edit"></i> Create New Announcement</h2>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="announcements.php" method="post" class="form-container">
                            <div class="form-group">
                                <label for="title">Announcement Title</label>
                                <input type="text" id="title" name="title" placeholder="Enter announcement title" required>
                            </div>
                            <div class="form-group">
                                <label for="content">Announcement Content</label>
                                <textarea id="content" name="content" rows="5" placeholder="Write your announcement here..." required></textarea>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i> Post Announcement
                                </button>
                                <button type="reset" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Clear
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="content-card">
                    <div class="card-header">
                        <div class="card-title">
                            <h2><i class="fas fa-list"></i> Recent Announcements</h2>
                        </div>
                        <div class="card-actions">
                            <select class="form-control" id="sortAnnouncements">
                                <option value="newest">Newest First</option>
                                <option value="oldest">Oldest First</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- <?php if (!empty($announcements)): ?> -->
                            <!-- <div class="announcement-list">
                                <?php foreach ($announcements as $announcement): ?>
                                    <div class="announcement-item">
                                        <div class="announcement-header">
                                            <h3><?php echo htmlspecialchars($announcement['title']); ?></h3>
                                            <div class="announcement-meta">
                                                <span class="date"><i class="fas fa-calendar-alt"></i> <?php echo date('F j, Y', strtotime($announcement['created_at'])); ?></span>
                                                <span class="time"><i class="fas fa-clock"></i> <?php echo date('g:i A', strtotime($announcement['created_at'])); ?></span>
                                            </div>
                                        </div>
                                        <div class="announcement-content">
                                            <p><?php echo nl2br(htmlspecialchars($announcement['content'])); ?></p>
                                        </div>
                                        <div class="announcement-footer">
                                            <div class="announcement-actions">
                                                <a href="edit_announcement.php?id=<?php echo $announcement['id']; ?>" class="btn-icon" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="#" onclick="confirmDelete(<?php echo $announcement['id']; ?>)" class="btn-icon" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div> -->
                        <!-- <?php else: ?> -->
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-bullhorn"></i>
                                </div>
                                <h3>No Announcements Yet</h3>
                                <p>Create your first announcement to keep everyone informed.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to confirm deletion
        function confirmDelete(announcementId) {
            if (confirm('Are you sure you want to delete this announcement?')) {
                window.location.href = 'delete_announcement.php?id=' + announcementId;
            }
        }

        // Function to close alerts
        document.addEventListener('DOMContentLoaded', function() {
            const closeButtons = document.querySelectorAll('.close-alert');
            closeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    this.parentElement.style.display = 'none';
                });
            });

            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    alert.style.display = 'none';
                });
            }, 5000);
        });
    </script>
</body>
</html>