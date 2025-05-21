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

// Handle filter and search
$search = isset($_GET['search']) ? $connection->real_escape_string($_GET['search']) : '';
$filter_major = isset($_GET['major']) ? $connection->real_escape_string($_GET['major']) : '';
$filter_year = isset($_GET['year_group']) ? $connection->real_escape_string($_GET['year_group']) : '';
$filter_engagement = isset($_GET['engagement_type']) ? $connection->real_escape_string($_GET['engagement_type']) : '';

// Build query conditions based on filters
$conditions = [];
if (!empty($search)) {
    $conditions[] = "(s.name LIKE '%$search%' OR s.email_address LIKE '%$search%' OR s.nationality LIKE '%$search%')";
}
if (!empty($filter_major)) {
    $conditions[] = "s.major = '$filter_major'";
}
if (!empty($filter_year)) {
    $conditions[] = "s.year_group = '$filter_year'";
}
if (!empty($filter_engagement)) {
    $conditions[] = "e.engagement_type = '$filter_engagement'";
}

// Combine conditions for the WHERE clause
$whereClause = !empty($conditions) ? "WHERE " . implode(' AND ', $conditions) : "";

// Pagination settings
$records_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

// Count total records for pagination
$countQuery = "SELECT COUNT(DISTINCT s.student_id) as total FROM students s 
               LEFT JOIN engagements e ON s.student_id = e.student_id 
               $whereClause";
$countResult = $connection->query($countQuery);
$totalRecords = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalRecords / $records_per_page);

// Get students data with pagination
$query = "SELECT s.student_id, s.name, s.gender, s.nationality, s.major, s.year_group, 
          s.email_address, s.linkedin_url, s.has_picture, e.engagement_type, e.destination_country,
          e.institution_name
          FROM students s
          LEFT JOIN engagements e ON s.student_id = e.student_id
          $whereClause
          GROUP BY s.student_id
          ORDER BY s.name ASC
          LIMIT $offset, $records_per_page";

$result = $connection->query($query);
$students = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
}

// Get unique major options for filter
$majorQuery = "SELECT DISTINCT major FROM students ORDER BY major";
$majorResult = $connection->query($majorQuery);
$majorOptions = [];

if ($majorResult) {
    while ($row = $majorResult->fetch_assoc()) {
        $majorOptions[] = $row['major'];
    }
}

// Get unique year groups for filter
$yearQuery = "SELECT DISTINCT year_group FROM students ORDER BY year_group DESC";
$yearResult = $connection->query($yearQuery);
$yearOptions = [];

if ($yearResult) {
    while ($row = $yearResult->fetch_assoc()) {
        $yearOptions[] = $row['year_group'];
    }
}

// Get unique engagement types for filter
$engagementQuery = "SELECT DISTINCT engagement_type FROM engagements ORDER BY engagement_type";
$engagementResult = $connection->query($engagementQuery);
$engagementOptions = [];

if ($engagementResult) {
    while ($row = $engagementResult->fetch_assoc()) {
        $engagementOptions[] = $row['engagement_type'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students - ODIP International Engagement</title>
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
                <li class="active"><a href="students.php"><i class="fas fa-user-graduate"></i> Manage Students</a></li>
                <li><a href="applications.php"><i class="fas fa-file-alt"></i> Applications</a></li>
                <li><a href="announcements.php"><i class="fas fa-bullhorn"></i> Announcements</a></li>
                <li><a href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
                <li><a href="../auth/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <header>
            <div class="header-content">
                <div class="header-search">
                    <form action="students.php" method="get">
                        <!-- <input type="text" name="search" placeholder="Search students..." value="<?php echo htmlspecialchars($search); ?>">  -->
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
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
                <h1><i class="fas fa-user-graduate"></i> Manage Students</h1>
                <div class="action-buttons">
                    <a href="applications.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Student
                    </a>
                    <a href="export_students.php" class="btn btn-secondary">
                        <i class="fas fa-file-export"></i> Export Data
                    </a>
                </div>
            </div>

            <div class="content-card">
                <div class="card-header">
                    <div class="card-title">
                        <h2><i class="fas fa-filter"></i> Filter Students</h2>
                    </div>
                    <div class="card-actions">
                        <a href="students.php" class="btn-small">Clear Filters</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="students.php" method="get" class="filter-form">
                        <div class="filter-group">
                            <label for="major">Major</label>
                            <select name="major" id="major" class="filter-select">
                                <option value="">All Majors</option>
                                <!-- <?php foreach ($majorOptions as $major): ?>
                                    <option value="<?php echo htmlspecialchars($major); ?>" <?php echo $filter_major === $major ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($major); ?>
                                    </option>
                                <?php endforeach; ?> -->
                            </select>
                        </div>
                        <div class="filter-group">
                            <label for="year_group">Year Group</label>
                            <select name="year_group" id="year_group" class="filter-select">
                                <option value="">All Years</option>
                                <!-- <?php foreach ($yearOptions as $year): ?>
                                    <option value="<?php echo htmlspecialchars($year); ?>" <?php echo $filter_year === $year ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($year); ?>
                                    </option>
                                <?php endforeach; ?> -->
                            </select>
                        </div>
                        <div class="filter-group">
                            <label for="engagement_type">Engagement Type</label>
                            <select name="engagement_type" id="engagement_type" class="filter-select">
                                <option value="">All Types</option>
                                <!-- <?php foreach ($engagementOptions as $engagement): ?>
                                    <option value="<?php echo htmlspecialchars($engagement); ?>" <?php echo $filter_engagement === $engagement ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($engagement); ?>
                                    </option>
                                <?php endforeach; ?> -->
                            </select>
                        </div>
                        <div class="filter-actions">
                            <button type="submit" class="btn-filter">
                                <i class="fas fa-filter"></i> Apply Filters
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="content-card">
                <div class="card-header">
                    <div class="card-title">
                        <h2><i class="fas fa-users"></i> Student Listing</h2>
                        <!-- <span class="record-count"><?php echo $totalRecords; ?> student<?php echo $totalRecords !== 1 ? 's' : ''; ?> found</span> -->
                    </div>
                    <div class="card-actions">
                        <div class="view-toggle">
                            <button class="view-btn active" data-view="table">
                                <i class="fas fa-table"></i>
                            </button>
                            <button class="view-btn" data-view="grid">
                                <i class="fas fa-th-large"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($students)): ?>
                        <!-- Table View -->
                        <div class="view-container table-view active">
                            <div class="table-responsive">
                                <table class="data-table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Year Group</th>
                                            <th>Major</th>
                                            <th>Nationality</th>
                                            <th>Type of Engagement</th>
                                            <th>Destination</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($students as $student): ?>
                                            <tr>
                                                <td>
                                                    <div class="student-name">
                                                        <?php if ($student['has_picture']): ?>
                                                            <div class="student-avatar">
                                                                <img src="../uploads/student_<?php echo $student['student_id']; ?>.jpg" alt="<?php echo htmlspecialchars($student['name']); ?>">
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="student-avatar default">
                                                                <i class="fas fa-user"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php echo htmlspecialchars($student['name']); ?>
                                                    </div>
                                                </td>
                                                <td><?php echo htmlspecialchars($student['year_group']); ?></td>
                                                <td><?php echo htmlspecialchars($student['major']); ?></td>
                                                <td><?php echo htmlspecialchars($student['nationality']); ?></td>
                                                <td>
                                                    <?php if ($student['engagement_type']): ?>
                                                        <span class="engagement-badge <?php echo strtolower(str_replace(' ', '-', $student['engagement_type'])); ?>">
                                                            <?php echo htmlspecialchars($student['engagement_type']); ?>
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="engagement-badge none">Not specified</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($student['destination_country'] ?? 'N/A'); ?></td>
                                                <td class="action-buttons">
                                                    <a href="view_student.php?id=<?php echo $student['student_id']; ?>" class="btn-icon" title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="edit_student.php?id=<?php echo $student['student_id']; ?>" class="btn-icon" title="Edit Student">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="#" onclick="confirmDelete(<?php echo $student['student_id']; ?>)" class="btn-icon" title="Delete Student">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Grid View -->
                        <div class="view-container grid-view">
                            <div class="student-grid">
                                <?php foreach ($students as $student): ?>
                                    <div class="student-card">
                                        <div class="student-card-header">
                                            <?php if ($student['has_picture']): ?>
                                                <div class="student-avatar large">
                                                    <img src="../uploads/student_<?php echo $student['student_id']; ?>.jpg" alt="<?php echo htmlspecialchars($student['name']); ?>">
                                                </div>
                                            <?php else: ?>
                                                <div class="student-avatar large default">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            <?php endif; ?>
                                            <h3><?php echo htmlspecialchars($student['name']); ?></h3>
                                            <p class="student-year"><?php echo htmlspecialchars($student['year_group']); ?></p>
                                        </div>
                                        <div class="student-card-body">
                                            <div class="student-info">
                                                <p><i class="fas fa-graduation-cap"></i> <?php echo htmlspecialchars($student['major']); ?></p>
                                                <p><i class="fas fa-flag"></i> <?php echo htmlspecialchars($student['nationality']); ?></p>
                                                <?php if ($student['engagement_type']): ?>
                                                    <p>
                                                        <i class="fas fa-plane-departure"></i> 
                                                        <span class="engagement-badge <?php echo strtolower(str_replace(' ', '-', $student['engagement_type'])); ?>">
                                                            <?php echo htmlspecialchars($student['engagement_type']); ?>
                                                        </span>
                                                    </p>
                                                <?php endif; ?>
                                                <?php if ($student['destination_country']): ?>
                                                    <p><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($student['destination_country']); ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="student-card-footer">
                                            <a href="view_student.php?id=<?php echo $student['student_id']; ?>" class="btn-small">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            <a href="edit_student.php?id=<?php echo $student['student_id']; ?>" class="btn-small">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                        <!-- Pagination -->
                        <?php if ($totalPages > 1): ?>
                            <div class="pagination">
                                <?php if ($page > 1): ?>
                                    <a href="students.php?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>&major=<?php echo urlencode($filter_major); ?>&year_group=<?php echo urlencode($filter_year); ?>&engagement_type=<?php echo urlencode($filter_engagement); ?>" class="pagination-btn">
                                        <i class="fas fa-chevron-left"></i> Previous
                                    </a>
                                <?php endif; ?>
                                
                                <div class="pagination-info">
                                    Page <?php echo $page; ?> of <?php echo $totalPages; ?>
                                </div>
                                
                                <?php if ($page < $totalPages): ?>
                                    <a href="students.php?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>&major=<?php echo urlencode($filter_major); ?>&year_group=<?php echo urlencode($filter_year); ?>&engagement_type=<?php echo urlencode($filter_engagement); ?>" class="pagination-btn">
                                        Next <i class="fas fa-chevron-right"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <h3>No Students Found</h3>
                            <p>No student records match your search criteria. Try changing your filters.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to confirm deletion
        function confirmDelete(studentId) {
            if (confirm('Are you sure you want to delete this student? This action cannot be undone.')) {
                window.location.href = 'delete_student.php?id=' + studentId;
            }
        }
        
        // View toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const viewButtons = document.querySelectorAll('.view-btn');
            const viewContainers = document.querySelectorAll('.view-container');
            
            viewButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const viewType = this.getAttribute('data-view');
                    
                    // Update buttons
                    viewButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Update views
                    viewContainers.forEach(container => {
                        container.classList.remove('active');
                        if (container.classList.contains(viewType + '-view')) {
                            container.classList.add('active');
                        }
                    });
                    
                    // Store preference in localStorage
                    localStorage.setItem('preferred_view', viewType);
                });
            });
            
            // Load preferred view from localStorage
            const preferredView = localStorage.getItem('preferred_view');
            if (preferredView) {
                const preferredButton = document.querySelector(`.view-btn[data-view="${preferredView}"]`);
                if (preferredButton) {
                    preferredButton.click();
                }
            }
            
            // Auto-submit filter form when select changes
            const filterSelects = document.querySelectorAll('.filter-select');
            filterSelects.forEach(select => {
                select.addEventListener('change', function() {
                    this.closest('form').submit();
                });
            });
        });
    </script>
</body>
</html>