<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements - ODIP Dashboard</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <script defer src="assets/js/script.js"></script>
</head>
<body>
    <div class="sidebar">
        <h2>Dashboard</h2>
        <ul>
            <li><a href="admindashboard.php">Dashboard</a></li>
            <li><a href="students.php">Manage Students</a></li>
            <li><a href="applications.php">Applications</a></li>
            <li><a href="reports.php">Reports</a></li>
            <li><a href="announcements.php">Announcements</a></li>
            <li><a href="settings.php">Settings</a></li>
            <li><a href="auth/logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <header>
            <h1>Announcements</h1>
        </header>

        <div class="announcement-form">
            <h2>Create New Announcement</h2>
            <form id="announcementForm">
                <input type="text" id="announcementTitle" placeholder="Title" required>
                <textarea id="announcementContent" placeholder="Write your announcement here..." rows="4" required></textarea>
                <button type="submit">Post Announcement</button>
            </form>
        </div>

        <div class="announcement-list">
            <h2>Recent Announcements</h2>
            <ul id="announcements">
                <!-- Announcements will appear here -->
            </ul>
        </div>
    </div>
</body>
</html>
