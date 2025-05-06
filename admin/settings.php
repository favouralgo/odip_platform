<?php
// Start the session
// session_start();

// Check if user is logged in
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
//     header("Location: auth/login.php");
//     exit;
// }

// Include database connection
// include "../config/connection.php";

// Get admin info
// $user_id = $_SESSION['user_id'];
// $query = "SELECT * FROM users WHERE user_id = $user_id";
// $result = mysqli_query($conn, $query);
// $admin = mysqli_fetch_assoc($result);

// Handle form submissions
// $success_message = '';
// $error_message = '';

// Profile Update Form
// if (isset($_POST['update_profile'])) {
//     $username = mysqli_real_escape_string($conn, $_POST['username']);
//     $email = mysqli_real_escape_string($conn, $_POST['email']);
    
//     // Check if email already exists
//     $check_query = "SELECT * FROM users WHERE email = '$email' AND user_id != $user_id";
//     $check_result = mysqli_query($conn, $check_query);
    
//     if (mysqli_num_rows($check_result) > 0) {
//         $error_message = "Email address already in use by another account.";
//     } else {
//         $update_query = "UPDATE users SET username = '$username', email = '$email' WHERE user_id = $user_id";
        
//         if (mysqli_query($conn, $update_query)) {
//             $success_message = "Profile updated successfully!";
//             // Update session data
//             $_SESSION['username'] = $username;
            
//             // Refresh admin data
//             $result = mysqli_query($conn, $query);
//             $admin = mysqli_fetch_assoc($result);
//         } else {
//             $error_message = "Error updating profile: " . mysqli_error($conn);
//         }
//     }
// }

// Password Change Form
// if (isset($_POST['change_password'])) {
//     $current_password = $_POST['current_password'];
//     $new_password = $_POST['new_password'];
//     $confirm_password = $_POST['confirm_password'];
    
//     // Verify current password
//     if (password_verify($current_password, $admin['password'])) {
//         // Check if new passwords match
//         if ($new_password === $confirm_password) {
//             // Hash the new password
//             $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            
//             // Update password in database
//             $update_query = "UPDATE users SET password = '$hashed_password' WHERE user_id = $user_id";
            
//             if (mysqli_query($conn, $update_query)) {
//                 $success_message = "Password changed successfully!";
//             } else {
//                 $error_message = "Error changing password: " . mysqli_error($conn);
//             }
//         } else {
//             $error_message = "New passwords do not match.";
//         }
//     } else {
//         $error_message = "Current password is incorrect.";
//     }
// }

// System Settings
// if (isset($_POST['update_settings'])) {
//     $system_name = mysqli_real_escape_string($conn, $_POST['system_name']);
//     $contact_email = mysqli_real_escape_string($conn, $_POST['contact_email']);
//     $items_per_page = (int)$_POST['items_per_page'];
    
//     // Check if settings table exists
//     $table_check = mysqli_query($conn, "SHOW TABLES LIKE 'settings'");
    
//     if (mysqli_num_rows($table_check) == 0) {
//         // Create settings table if it doesn't exist
//         $create_table = "CREATE TABLE settings (
//             id INT AUTO_INCREMENT PRIMARY KEY,
//             setting_name VARCHAR(50) NOT NULL UNIQUE,
//             setting_value TEXT NOT NULL,
//             updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
//         )";
        
//         mysqli_query($conn, $create_table);
//     }
    
//     // Update or insert settings
//     $settings = [
//         'system_name' => $system_name,
//         'contact_email' => $contact_email,
//         'items_per_page' => $items_per_page
//     ];
    
//     foreach ($settings as $name => $value) {
//         $check_setting = mysqli_query($conn, "SELECT * FROM settings WHERE setting_name = '$name'");
        
//         if (mysqli_num_rows($check_setting) > 0) {
//             // Update existing setting
//             mysqli_query($conn, "UPDATE settings SET setting_value = '$value' WHERE setting_name = '$name'");
//         } else {
//             // Insert new setting
//             mysqli_query($conn, "INSERT INTO settings (setting_name, setting_value) VALUES ('$name', '$value')");
//         }
//     }
    
//     $success_message = "System settings updated successfully!";
// }

// Get current system settings
// $settings = [];
// $settings_table_exists = mysqli_query($conn, "SHOW TABLES LIKE 'settings'");

// if (mysqli_num_rows($settings_table_exists) > 0) {
//     $settings_query = "SELECT * FROM settings";
//     $settings_result = mysqli_query($conn, $settings_query);
    
//     while ($row = mysqli_fetch_assoc($settings_result)) {
//         $settings[$row['setting_name']] = $row['setting_value'];
//     }
// }

// Default values if settings are not set
// $system_name = $settings['system_name'] ?? 'ODIP International Engagement Platform';
// $contact_email = $settings['contact_email'] ?? 'admin@example.com';
// $items_per_page = $settings['items_per_page'] ?? 10;

// Get database stats
// $tables = ['students', 'engagements', 'experience_responses', 'announcements'];
// $table_stats = [];

// foreach ($tables as $table) {
//     $count_query = "SELECT COUNT(*) as count FROM $table";
//     $result = mysqli_query($conn, $count_query);
    
//     if ($result) {
//         $table_stats[$table] = mysqli_fetch_assoc($result)['count'];
//     } else {
//         $table_stats[$table] = 0;
//     }
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - ODIP International Engagement</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/settings.css">
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
                <li><a href="announcements.php"><i class="fas fa-bullhorn"></i> Announcements</a></li>
                <li class="active"><a href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
                <li><a href="../auth/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <header>
            <div class="header-content">
                <div class="header-title">
                    <h1><i class="fas fa-cog"></i> Settings</h1>
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
            <!-- <?php if (!empty($success_message)): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?php echo $success_message; ?>
                <button class="close-alert"><i class="fas fa-times"></i></button>
            </div>
            <?php endif; ?> -->

            <!-- <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error_message; ?>
                <button class="close-alert"><i class="fas fa-times"></i></button>
            </div>
            <?php endif; ?> -->

            <div class="settings-layout">
                <!-- Settings Navigation -->
                <div class="settings-nav">
                    <div class="settings-nav-header">
                        <h3>Settings</h3>
                    </div>
                    <ul class="settings-menu">
                        <li class="active" data-target="profile-settings">
                            <i class="fas fa-user-circle"></i> Admin Profile
                        </li>
                        <li data-target="password-settings">
                            <i class="fas fa-lock"></i> Change Password
                        </li>
                        <li data-target="system-settings">
                            <i class="fas fa-sliders-h"></i> System Settings
                        </li>
                        <li data-target="database-settings">
                            <i class="fas fa-database"></i> Database Information
                        </li>
                    </ul>
                </div>

                <!-- Settings Content -->
                <div class="settings-content">
                    <!-- Profile Settings -->
                    <div class="settings-panel active" id="profile-settings">
                        <div class="settings-panel-header">
                            <h2>Admin Profile</h2>
                            <p>Update your administrator account information</p>
                        </div>
                        <div class="settings-panel-body">
                            <form action="settings.php" method="post" class="settings-form">
                                <div class="form-row">
                                    <!-- <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($admin['username']); ?>" required>
                                    </div> -->
                                    <!-- <div class="form-group">
                                        <label for="email">Email Address</label>
                                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" required>
                                    </div> -->
                                </div>
                                <div class="form-group">
                                    <label for="role">Role</label>
                                    <input type="text" id="role" value="Administrator" disabled>
                                    <small>Administrator role cannot be changed</small>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" name="update_profile" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Password Settings -->
                    <div class="settings-panel" id="password-settings">
                        <div class="settings-panel-header">
                            <h2>Change Password</h2>
                            <p>Update your administrator account password</p>
                        </div>
                        <div class="settings-panel-body">
                            <form action="settings.php" method="post" class="settings-form">
                                <div class="form-group">
                                    <label for="current_password">Current Password</label>
                                    <input type="password" id="current_password" name="current_password" required>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="new_password">New Password</label>
                                        <input type="password" id="new_password" name="new_password" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirm_password">Confirm New Password</label>
                                        <input type="password" id="confirm_password" name="confirm_password" required>
                                    </div>
                                </div>
                                <div class="password-strength">
                                    <label>Password Strength</label>
                                    <div class="strength-meter">
                                        <div class="strength-bar" id="strength-bar"></div>
                                    </div>
                                    <small id="password-feedback">Password must be at least 8 characters long</small>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" name="change_password" class="btn btn-primary">
                                        <i class="fas fa-key"></i> Change Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- System Settings -->
                    <div class="settings-panel" id="system-settings">
                        <div class="settings-panel-header">
                            <h2>System Settings</h2>
                            <p>Configure your ODIP International Engagement Platform</p>
                        </div>
                        <div class="settings-panel-body">
                            <form action="settings.php" method="post" class="settings-form">
                                <!-- <div class="form-group">
                                    <label for="system_name">System Name</label>
                                    <input type="text" id="system_name" name="system_name" value="<?php echo htmlspecialchars($system_name); ?>" required>
                                </div> -->
                                <!-- <div class="form-group">
                                    <label for="contact_email">Contact Email</label>
                                    <input type="email" id="contact_email" name="contact_email" value="<?php echo htmlspecialchars($contact_email); ?>" required>
                                </div> -->
                                <div class="form-group">
                                    <label for="items_per_page">Items Per Page</label>
                                    <select id="items_per_page" name="items_per_page">
                                        <option value="5" <?php echo $items_per_page == 5 ? 'selected' : ''; ?>>5</option>
                                        <option value="10" <?php echo $items_per_page == 10 ? 'selected' : ''; ?>>10</option>
                                        <option value="15" <?php echo $items_per_page == 15 ? 'selected' : ''; ?>>15</option>
                                        <option value="20" <?php echo $items_per_page == 20 ? 'selected' : ''; ?>>20</option>
                                        <option value="25" <?php echo $items_per_page == 25 ? 'selected' : ''; ?>>25</option>
                                        <option value="50" <?php echo $items_per_page == 50 ? 'selected' : ''; ?>>50</option>
                                    </select>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" name="update_settings" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Save Settings
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Database Information -->
                    <div class="settings-panel" id="database-settings">
                        <div class="settings-panel-header">
                            <h2>Database Information</h2>
                            <p>View information about your database</p>
                        </div>
                        <div class="settings-panel-body">
                            <div class="db-stats">
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="fas fa-user-graduate"></i>
                                    </div>
                                    <!-- <div class="stat-info">
                                        <h3>Students</h3>
                                        <p><?php echo $table_stats['students']; ?> records</p>
                                    </div> -->
                                </div>
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="fas fa-plane-departure"></i>
                                    </div>
                                    <!-- <div class="stat-info">
                                        <h3>Engagements</h3>
                                        <p><?php echo $table_stats['engagements']; ?> records</p>
                                    </div> -->
                                </div>
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="fas fa-comment-dots"></i>
                                    </div>
                                    <!-- <div class="stat-info">
                                        <h3>Responses</h3>
                                        <p><?php echo $table_stats['experience_responses']; ?> records</p>
                                    </div> -->
                                </div>
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="fas fa-bullhorn"></i>
                                    </div>
                                    <!-- <div class="stat-info">
                                        <h3>Announcements</h3>
                                        <p><?php echo $table_stats['announcements']; ?> records</p>
                                    </div> -->
                                </div>
                            </div>
                            
                            <div class="db-actions">
                                <a href="backup_database.php" class="btn btn-primary">
                                    <i class="fas fa-download"></i> Backup Database
                                </a>
                                <button type="button" class="btn btn-danger" id="purge-data-btn">
                                    <i class="fas fa-trash"></i> Purge Data
                                </button>
                            </div>

                            <!-- Purge Data Modal -->
                            <div class="modal" id="purge-modal">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3><i class="fas fa-exclamation-triangle"></i> Purge Database Data</h3>
                                        <button class="close-modal"><i class="fas fa-times"></i></button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="warning-text">Warning! This action will permanently delete all data from the selected tables. This action cannot be undone.</p>
                                        <form action="purge_data.php" method="post" id="purge-form">
                                            <div class="form-group">
                                                <label>Select tables to purge:</label>
                                                <div class="checkbox-group">
                                                    <label class="checkbox-label">
                                                        <input type="checkbox" name="purge_tables[]" value="students">
                                                        Students
                                                    </label>
                                                    <label class="checkbox-label">
                                                        <input type="checkbox" name="purge_tables[]" value="engagements">
                                                        Engagements
                                                    </label>
                                                    <label class="checkbox-label">
                                                        <input type="checkbox" name="purge_tables[]" value="experience_responses">
                                                        Experience Responses
                                                    </label>
                                                    <label class="checkbox-label">
                                                        <input type="checkbox" name="purge_tables[]" value="announcements">
                                                        Announcements
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="confirm_purge">Type "PURGE" to confirm:</label>
                                                <input type="text" id="confirm_purge" name="confirm_purge" required>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary close-modal">Cancel</button>
                                        <button class="btn btn-danger" id="confirm-purge" disabled>Purge Selected Data</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Settings navigation
            const navItems = document.querySelectorAll('.settings-menu li');
            const panels = document.querySelectorAll('.settings-panel');
            
            navItems.forEach(item => {
                item.addEventListener('click', function() {
                    const target = this.getAttribute('data-target');
                    
                    // Update active nav item
                    navItems.forEach(nav => nav.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Show target panel
                    panels.forEach(panel => {
                        panel.classList.remove('active');
                        if (panel.id === target) {
                            panel.classList.add('active');
                        }
                    });
                });
            });
            
            // Close alerts
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
            
            // Password strength meter
            const passwordInput = document.getElementById('new_password');
            const strengthBar = document.getElementById('strength-bar');
            const passwordFeedback = document.getElementById('password-feedback');
            
            if (passwordInput) {
                passwordInput.addEventListener('input', function() {
                    const password = this.value;
                    let strength = 0;
                    let feedback = '';
                    
                    if (password.length >= 8) {
                        strength += 25;
                        feedback = 'Password is acceptable';
                    } else {
                        feedback = 'Password must be at least 8 characters long';
                    }
                    
                    if (password.match(/[A-Z]/)) {
                        strength += 25;
                    }
                    
                    if (password.match(/[0-9]/)) {
                        strength += 25;
                    }
                    
                    if (password.match(/[^A-Za-z0-9]/)) {
                        strength += 25;
                    }
                    
                    // Update strength bar
                    strengthBar.style.width = strength + '%';
                    
                    // Update strength class
                    strengthBar.className = 'strength-bar';
                    if (strength <= 25) {
                        strengthBar.classList.add('weak');
                        feedback = 'Password is weak';
                    } else if (strength <= 50) {
                        strengthBar.classList.add('medium');
                        feedback = 'Password is medium strength';
                    } else if (strength <= 75) {
                        strengthBar.classList.add('strong');
                        feedback = 'Password is strong';
                    } else {
                        strengthBar.classList.add('very-strong');
                        feedback = 'Password is very strong';
                    }
                    
                    passwordFeedback.textContent = feedback;
                });
            }
            
            // Purge data modal
            const purgeBtn = document.getElementById('purge-data-btn');
            const purgeModal = document.getElementById('purge-modal');
            const closeModalBtns = document.querySelectorAll('.close-modal');
            const confirmPurgeInput = document.getElementById('confirm_purge');
            const confirmPurgeBtn = document.getElementById('confirm-purge');
            const purgeForm = document.getElementById('purge-form');
            
            if (purgeBtn && purgeModal) {
                purgeBtn.addEventListener('click', function() {
                    purgeModal.classList.add('active');
                });
                
                closeModalBtns.forEach(btn => {
                    btn.addEventListener('click', function() {
                        purgeModal.classList.remove('active');
                    });
                });
                
                // Close modal when clicking outside the modal content
                purgeModal.addEventListener('click', function(e) {
                    if (e.target === purgeModal) {
                        purgeModal.classList.remove('active');
                    }
                });
                
                // Enable/disable confirm button based on text input
                if (confirmPurgeInput && confirmPurgeBtn) {
                    confirmPurgeInput.addEventListener('input', function() {
                        confirmPurgeBtn.disabled = this.value !== 'PURGE';
                    });
                    
                    // Submit form when confirm button is clicked
                    confirmPurgeBtn.addEventListener('click', function() {
                        if (!this.disabled) {
                            purgeForm.submit();
                        }
                    });
                }
            }
        });
    </script>
</body>
</html>