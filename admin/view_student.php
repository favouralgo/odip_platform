<?php
// Start session
session_start();

// Check if user is logged in as admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Include database connection
include "../config/connection.php";

// Check if student ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error_message'] = "No student ID provided.";
    header("Location: students.php");
    exit;
}

$student_id = (int)$_GET['id'];

// Get student data
$query = "SELECT s.*, e.engagement_type, e.destination_country, e.institution_name, e.status
          FROM students s
          LEFT JOIN engagements e ON s.student_id = e.student_id
          WHERE s.student_id = ?";

$stmt = $connection->prepare($query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error_message'] = "Student not found.";
    header("Location: students.php");
    exit;
}

$student = $result->fetch_assoc();

// Get experience responses
$expQuery = "SELECT * FROM experience_responses WHERE student_id = ?";
$stmt = $connection->prepare($expQuery);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$expResult = $stmt->get_result();
$experiences = $expResult->fetch_assoc();

// Check if student has a profile picture
$picturePath = "../uploads/student_" . $student_id . ".jpg";
$hasPicture = file_exists($picturePath);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student - ODIP International Engagement</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/view_student.css">
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
                <div class="header-title">
                    <a href="students.php" class="back-link"><i class="fas fa-arrow-left"></i></a>
                    <h1>Student Profile</h1>
                </div>
                <div class="header-actions">
                    <a href="edit_student.php?id=<?php echo $student_id; ?>" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit Profile
                    </a>
                    <button class="btn btn-danger" onclick="confirmDelete(<?php echo $student_id; ?>)">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </div>
            </div>
        </header>

        <div class="dashboard-wrapper">
            <div class="student-profile">
                <div class="profile-header">
                    <div class="profile-image">
                        <?php if ($hasPicture): ?>
                            <img src="<?php echo $picturePath; ?>" alt="<?php echo htmlspecialchars($student['name']); ?>">
                        <?php else: ?>
                            <div class="profile-placeholder">
                                <i class="fas fa-user"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="profile-details">
                        <h2><?php echo htmlspecialchars($student['name']); ?></h2>
                        <p class="student-id">Student ID: <?php echo $student_id; ?></p>
                        <p><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($student['email_address']); ?></p>
                        <p><i class="fas fa-graduation-cap"></i> <?php echo htmlspecialchars($student['major']); ?>, Class of <?php echo htmlspecialchars($student['year_group']); ?></p>
                        <p><i class="fas fa-flag"></i> <?php echo htmlspecialchars($student['nationality']); ?></p>
                        
                        <?php if (!empty($student['linkedin_url'])): ?>
                        <p><i class="fab fa-linkedin"></i> <a href="<?php echo htmlspecialchars($student['linkedin_url']); ?>" target="_blank">LinkedIn Profile</a></p>
                        <?php endif; ?>
                        
                        <?php if (!empty($student['engagement_type'])): ?>
                        <div class="engagement-status">
                            <span class="engagement-type">
                                <i class="fas fa-plane-departure"></i> 
                                <?php echo htmlspecialchars($student['engagement_type']); ?>
                            </span>
                            
                            <?php 
                            $statusClass = '';
                            $status = $student['status'] ?? 'pending';
                            
                            switch ($status) {
                                case 'approved':
                                    $statusClass = 'status-approved';
                                    break;
                                case 'rejected':
                                    $statusClass = 'status-rejected';
                                    break;
                                default:
                                    $statusClass = 'status-pending';
                            }
                            ?>
                            
                            <span class="status-badge <?php echo $statusClass; ?>">
                                <?php echo ucfirst($status); ?>
                            </span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="profile-content">
                    <div class="content-tabs">
                        <button class="tab-btn active" data-tab="engagement">Engagement Details</button>
                        <button class="tab-btn" data-tab="experiences">Experiences</button>
                    </div>
                    
                    <div class="tab-content active" id="engagement-tab">
                        <div class="content-card">
                            <div class="card-header">
                                <h3><i class="fas fa-globe"></i> International Engagement Details</h3>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($student['engagement_type'])): ?>
                                <div class="detail-row">
                                    <div class="detail-label">Type of Engagement:</div>
                                    <div class="detail-value"><?php echo htmlspecialchars($student['engagement_type']); ?></div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Destination Country:</div>
                                    <div class="detail-value"><?php echo htmlspecialchars($student['destination_country']); ?></div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Institution/Organization:</div>
                                    <div class="detail-value"><?php echo htmlspecialchars($student['institution_name']); ?></div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Current Status:</div>
                                    <div class="detail-value">
                                        <span class="status-badge <?php echo $statusClass; ?>"><?php echo ucfirst($status); ?></span>
                                    </div>
                                </div>
                                <?php else: ?>
                                <div class="empty-state">
                                    <p>No engagement details recorded for this student.</p>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-content" id="experiences-tab">
                        <div class="content-card">
                            <div class="card-header">
                                <h3><i class="fas fa-comment-dots"></i> Student Experience Responses</h3>
                            </div>
                            <div class="card-body">
                                <?php if ($experiences): ?>
                                <div class="accordion">
                                    <?php if (!empty($experiences['inspiration'])): ?>
                                    <div class="accordion-item">
                                        <div class="accordion-header">
                                            <h4>What inspired you to participate in this international engagement?</h4>
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                        <div class="accordion-content">
                                            <p><?php echo nl2br(htmlspecialchars($experiences['inspiration'])); ?></p>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($experiences['wished_to_know'])): ?>
                                    <div class="accordion-item">
                                        <div class="accordion-header">
                                            <h4>What did you wish you knew before your experience?</h4>
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                        <div class="accordion-content">
                                            <p><?php echo nl2br(htmlspecialchars($experiences['wished_to_know'])); ?></p>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($experiences['funny_story'])): ?>
                                    <div class="accordion-item">
                                        <div class="accordion-header">
                                            <h4>Share a funny or embarrassing story from your experience</h4>
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                        <div class="accordion-content">
                                            <p><?php echo nl2br(htmlspecialchars($experiences['funny_story'])); ?></p>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($experiences['things_done'])): ?>
                                    <div class="accordion-item">
                                        <div class="accordion-header">
                                            <h4>What interesting things did you do during your time abroad?</h4>
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                        <div class="accordion-content">
                                            <p><?php echo nl2br(htmlspecialchars($experiences['things_done'])); ?></p>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($experiences['fears'])): ?>
                                    <div class="accordion-item">
                                        <div class="accordion-header">
                                            <h4>What fears did you have before going?</h4>
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                        <div class="accordion-content">
                                            <p><?php echo nl2br(htmlspecialchars($experiences['fears'])); ?></p>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($experiences['culture_shock'])): ?>
                                    <div class="accordion-item">
                                        <div class="accordion-header">
                                            <h4>Describe any culture shock you experienced</h4>
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                        <div class="accordion-content">
                                            <p><?php echo nl2br(htmlspecialchars($experiences['culture_shock'])); ?></p>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($experiences['advice'])): ?>
                                    <div class="accordion-item">
                                        <div class="accordion-header">
                                            <h4>What advice would you give others considering a similar experience?</h4>
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                        <div class="accordion-content">
                                            <p><?php echo nl2br(htmlspecialchars($experiences['advice'])); ?></p>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($experiences['career_choice_change'])): ?>
                                    <div class="accordion-item">
                                        <div class="accordion-header">
                                            <h4>Did this experience change your career choices? If so, how?</h4>
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                        <div class="accordion-content">
                                            <p><?php echo nl2br(htmlspecialchars($experiences['career_choice_change'])); ?></p>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($experiences['interesting_class'])): ?>
                                    <div class="accordion-item">
                                        <div class="accordion-header">
                                            <h4>What was the most interesting class or session you attended?</h4>
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                        <div class="accordion-content">
                                            <p><?php echo nl2br(htmlspecialchars($experiences['interesting_class'])); ?></p>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($experiences['teaching_learning_style'])): ?>
                                    <div class="accordion-item">
                                        <div class="accordion-header">
                                            <h4>How was the teaching, learning, or presentation style different?</h4>
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                        <div class="accordion-content">
                                            <p><?php echo nl2br(htmlspecialchars($experiences['teaching_learning_style'])); ?></p>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($experiences['personal_change'])): ?>
                                    <div class="accordion-item">
                                        <div class="accordion-header">
                                            <h4>How did this international engagement change you?</h4>
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                        <div class="accordion-content">
                                            <p><?php echo nl2br(htmlspecialchars($experiences['personal_change'])); ?></p>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($experiences['would_do_differently'])): ?>
                                    <div class="accordion-item">
                                        <div class="accordion-header">
                                            <h4>What would you do differently if you could do it again?</h4>
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                        <div class="accordion-content">
                                            <p><?php echo nl2br(htmlspecialchars($experiences['would_do_differently'])); ?></p>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <?php else: ?>
                                <div class="empty-state">
                                    <p>No experience responses recorded for this student.</p>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
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
        
        // Tab switching functionality
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');
            
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const tabName = this.getAttribute('data-tab');
                    
                    // Update active tab button
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Show selected tab content
                    tabContents.forEach(content => {
                        content.classList.remove('active');
                        if (content.id === tabName + '-tab') {
                            content.classList.add('active');
                        }
                    });
                });
            });
            
            // Accordion functionality
            const accordionHeaders = document.querySelectorAll('.accordion-header');
            
            accordionHeaders.forEach(header => {
                header.addEventListener('click', function() {
                    this.parentElement.classList.toggle('active');
                    const icon = this.querySelector('i');
                    icon.classList.toggle('fa-chevron-down');
                    icon.classList.toggle('fa-chevron-up');
                });
            });
        });
    </script>
</body>
</html>