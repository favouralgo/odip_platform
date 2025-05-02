<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study Abroad Admin Dashboard</title>
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
            <h1>Welcome, Admin!</h1>
        </header>

        <!-- New button for ODIP form -->
        <div class="button-container">
            <a href="https://forms.office.com/r/Z5qwX9L27u" target="_blank" class="form-button">Fill Out ODIP Form</a>
        </div>

        <div class="stats">
            <div class="stat-box" id="total-students">
                <h3>Total Students</h3>
                <p class="number">0</p>
            </div>
            <div class="stat-box approved" id="approved">
                <h3>Approved</h3>
                <p class="number">0</p>
            </div>
            <div class="stat-box pending" id="pending">
                <h3>Pending</h3>
                <p class="number">0</p>
            </div>
            <div class="stat-box rejected" id="rejected">
                <h3>Rejected</h3>
                <p class="number">0</p>
            </div>
        </div>

        <div class="table-container">
            <h2>Students Abroad / Conference</h2>
            <table>
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
                <tbody id="student-table">
                    <!-- Data from backend will be loaded here -->
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
