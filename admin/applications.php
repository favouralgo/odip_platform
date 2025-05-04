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

// Process form submission
// $success_message = '';
// $error_message = '';

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     // Get form data
//     $name = mysqli_real_escape_string($conn, $_POST['name']);
//     $gender = mysqli_real_escape_string($conn, $_POST['gender']);
//     $nationality = mysqli_real_escape_string($conn, $_POST['nationality']);
//     $major = mysqli_real_escape_string($conn, $_POST['major']);
//     $year_group = mysqli_real_escape_string($conn, $_POST['year_group']);
//     $email = mysqli_real_escape_string($conn, $_POST['email']);
//     $linkedin = isset($_POST['linkedin']) ? mysqli_real_escape_string($conn, $_POST['linkedin']) : '';
//     $has_picture = isset($_FILES['profile_picture']) && $_FILES['profile_picture']['size'] > 0 ? 1 : 0;
    
//     // Begin transaction
//     mysqli_begin_transaction($conn);
    
//     try {
//         // Insert into students table
//         $student_query = "INSERT INTO students (name, gender, nationality, major, year_group, email_address, linkedin_url, has_picture) 
//                          VALUES ('$name', '$gender', '$nationality', '$major', '$year_group', '$email', '$linkedin', $has_picture)";
        
//         if (!mysqli_query($conn, $student_query)) {
//             throw new Exception("Error creating student record: " . mysqli_error($conn));
//         }
        
//         $student_id = mysqli_insert_id($conn);
        
//         // Get engagement data
//         $engagement_type = mysqli_real_escape_string($conn, $_POST['engagement_type']);
//         $destination = mysqli_real_escape_string($conn, $_POST['destination_country']);
//         $institution = mysqli_real_escape_string($conn, $_POST['institution_name']);
        
//         // Insert into engagements table
//         $engagement_query = "INSERT INTO engagements (student_id, engagement_type, destination_country, institution_name) 
//                             VALUES ($student_id, '$engagement_type', '$destination', '$institution')";
        
//         if (!mysqli_query($conn, $engagement_query)) {
//             throw new Exception("Error creating engagement record: " . mysqli_error($conn));
//         }
        
//         $engagement_id = mysqli_insert_id($conn);
        
//         // Get experience data
//         $inspiration = mysqli_real_escape_string($conn, $_POST['inspiration']);
//         $wished_to_know = mysqli_real_escape_string($conn, $_POST['wished_to_know']);
//         $funny_story = mysqli_real_escape_string($conn, $_POST['funny_story']);
//         $things_done = mysqli_real_escape_string($conn, $_POST['things_done']);
//         $fears = mysqli_real_escape_string($conn, $_POST['fears']);
//         $culture_shock = mysqli_real_escape_string($conn, $_POST['culture_shock']);
//         $advice = mysqli_real_escape_string($conn, $_POST['advice']);
//         $career_change = mysqli_real_escape_string($conn, $_POST['career_change']);
//         $interesting_class = mysqli_real_escape_string($conn, $_POST['interesting_class']);
//         $teaching_style = mysqli_real_escape_string($conn, $_POST['teaching_style']);
//         $personal_change = mysqli_real_escape_string($conn, $_POST['personal_change']);
//         $do_differently = mysqli_real_escape_string($conn, $_POST['do_differently']);
        
//         // Insert into experience_responses table
//         $experience_query = "INSERT INTO experience_responses (
//                             student_id, engagement_id, inspiration, wished_to_know, 
//                             funny_story, things_done, fears, culture_shock, 
//                             advice, career_choice_change, interesting_class, 
//                             teaching_learning_style, personal_change, would_do_differently
//                             ) VALUES (
//                             $student_id, $engagement_id, '$inspiration', '$wished_to_know', 
//                             '$funny_story', '$things_done', '$fears', '$culture_shock', 
//                             '$advice', '$career_change', '$interesting_class', 
//                             '$teaching_style', '$personal_change', '$do_differently'
//                             )";
        
//         if (!mysqli_query($conn, $experience_query)) {
//             throw new Exception("Error creating experience record: " . mysqli_error($conn));
//         }
        
//         // Handle file upload if picture exists
//         if ($has_picture) {
//             $target_dir = "../uploads/";
            
//             // Create directory if it doesn't exist
//             if (!file_exists($target_dir)) {
//                 mkdir($target_dir, 0755, true);
//             }
            
//             $file_extension = pathinfo($_FILES["profile_picture"]["name"], PATHINFO_EXTENSION);
//             $new_filename = "student_" . $student_id . "." . $file_extension;
//             $target_file = $target_dir . $new_filename;
            
//             if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
//                 $picture_query = "INSERT INTO student_pictures (student_id, file_name, file_path) 
//                                  VALUES ($student_id, '$new_filename', '$target_file')";
                
//                 if (!mysqli_query($conn, $picture_query)) {
//                     throw new Exception("Error saving picture: " . mysqli_error($conn));
//                 }
//             } else {
//                 throw new Exception("Error uploading picture");
//             }
//         }
        
//         // Commit the transaction
//         mysqli_commit($conn);
//         $success_message = "Student application submitted successfully!";
        
//     } catch (Exception $e) {
//         // Rollback the transaction in case of error
//         mysqli_rollback($conn);
//         $error_message = $e->getMessage();
//     }
// }

// Get list of nationalities for dropdown
// $nationalities = [
//     "Afghan", "Albanian", "Algerian", "American", "Andorran", "Angolan", "Antiguan", "Argentine", "Armenian", 
//     "Australian", "Austrian", "Azerbaijani", "Bahamian", "Bahraini", "Bangladeshi", "Barbadian", "Belarusian", 
//     "Belgian", "Belizean", "Beninese", "Bhutanese", "Bolivian", "Bosnian", "Botswanan", "Brazilian", "British", 
//     "Bruneian", "Bulgarian", "Burkinabe", "Burmese", "Burundian", "Cambodian", "Cameroonian", "Canadian", 
//     "Cape Verdean", "Central African", "Chadian", "Chilean", "Chinese", "Colombian", "Comoran", "Congolese", 
//     "Costa Rican", "Croatian", "Cuban", "Cypriot", "Czech", "Danish", "Djibouti", "Dominican", "Dutch", 
//     "East Timorese", "Ecuadorean", "Egyptian", "Emirian", "Equatorial Guinean", "Eritrean", "Estonian", 
//     "Ethiopian", "Fijian", "Filipino", "Finnish", "French", "Gabonese", "Gambian", "Georgian", "German", 
//     "Ghanaian", "Greek", "Grenadian", "Guatemalan", "Guinean", "Guinea-Bissauan", "Guyanese", "Haitian", 
//     "Honduran", "Hungarian", "Icelander", "Indian", "Indonesian", "Iranian", "Iraqi", "Irish", "Israeli", 
//     "Italian", "Ivorian", "Jamaican", "Japanese", "Jordanian", "Kazakhstani", "Kenyan", "Kiribati", "Korean", 
//     "Kuwaiti", "Kyrgyz", "Laotian", "Latvian", "Lebanese", "Liberian", "Libyan", "Liechtensteiner", "Lithuanian", 
//     "Luxembourger", "Macedonian", "Malagasy", "Malawian", "Malaysian", "Maldivian", "Malian", "Maltese", 
//     "Marshallese", "Mauritanian", "Mauritian", "Mexican", "Micronesian", "Moldovan", "Monacan", "Mongolian", 
//     "Moroccan", "Mosotho", "Motswana", "Mozambican", "Namibian", "Nauruan", "Nepalese", "New Zealander", 
//     "Nicaraguan", "Nigerian", "Nigerien", "Norwegian", "Omani", "Pakistani", "Palauan", "Panamanian", 
//     "Papua New Guinean", "Paraguayan", "Peruvian", "Polish", "Portuguese", "Qatari", "Romanian", "Russian", 
//     "Rwandan", "Saint Lucian", "Salvadoran", "Samoan", "San Marinese", "Sao Tomean", "Saudi", "Senegalese", 
//     "Serbian", "Seychellois", "Sierra Leonean", "Singaporean", "Slovakian", "Slovenian", "Solomon Islander", 
//     "Somali", "South African", "Spanish", "Sri Lankan", "Sudanese", "Surinamer", "Swazi", "Swedish", "Swiss", 
//     "Syrian", "Taiwanese", "Tajik", "Tanzanian", "Thai", "Togolese", "Tongan", "Trinidadian", "Tunisian", 
//     "Turkish", "Tuvaluan", "Ugandan", "Ukrainian", "Uruguayan", "Uzbekistani", "Vanuatuan", "Venezuelan", 
//     "Vietnamese", "Yemeni", "Zambian", "Zimbabwean"
// ];
?> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Application - ODIP International Engagement</title>
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
                <li class="active"><a href="applications.php"><i class="fas fa-file-alt"></i> Applications</a></li>
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
                <h1><i class="fas fa-file-alt"></i> New International Engagement Application</h1>
                <div class="action-buttons">
                    <a href="view_applications.php" class="btn btn-secondary">
                        <i class="fas fa-list"></i> View All Applications
                    </a>
                </div>
            </div>

            <?php if (!empty($success_message)): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?php echo $success_message; ?>
                <button class="close-alert"><i class="fas fa-times"></i></button>
            </div>
            <?php endif; ?>

            <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error_message; ?>
                <button class="close-alert"><i class="fas fa-times"></i></button>
            </div>
            <?php endif; ?>

            <div class="content-card">
                <div class="card-header">
                    <div class="card-title">
                        <h2><i class="fas fa-user-plus"></i> Student Information Form</h2>
                    </div>
                </div>
                <div class="card-body">
                    <form action="applications.php" method="post" enctype="multipart/form-data" class="multi-step-form">
                        <!-- Progress Bar -->
                        <div class="form-progress">
                            <div class="progress-step active" data-step="1">
                                <div class="step-icon"><i class="fas fa-user"></i></div>
                                <span class="step-label">Personal Info</span>
                            </div>
                            <div class="progress-connector"></div>
                            <div class="progress-step" data-step="2">
                                <div class="step-icon"><i class="fas fa-plane"></i></div>
                                <span class="step-label">Engagement</span>
                            </div>
                            <div class="progress-connector"></div>
                            <div class="progress-step" data-step="3">
                                <div class="step-icon"><i class="fas fa-comment-dots"></i></div>
                                <span class="step-label">Experience</span>
                            </div>
                            <div class="progress-connector"></div>
                            <div class="progress-step" data-step="4">
                                <div class="step-icon"><i class="fas fa-check-circle"></i></div>
                                <span class="step-label">Review</span>
                            </div>
                        </div>

                        <!-- Step 1: Personal Information -->
                        <div class="form-step active" data-step="1">
                            <div class="form-section">
                                <h3 class="section-title">Personal Information</h3>
                                
                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label for="name">Full Name <span class="required">*</span></label>
                                        <input type="text" id="name" name="name" required>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="email">Email Address <span class="required">*</span></label>
                                        <input type="email" id="email" name="email" required>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label for="gender">Gender <span class="required">*</span></label>
                                        <select id="gender" name="gender" required>
                                            <option value="">Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="nationality">Nationality <span class="required">*</span></label>
                                        <select id="nationality" name="nationality" required>
                                            <option value="">Select Nationality</option>
                                            <?php foreach ($nationalities as $nationality): ?>
                                                <option value="<?php echo $nationality; ?>"><?php echo $nationality; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label for="major">Major <span class="required">*</span></label>
                                        <select id="major" name="major" required>
                                            <option value="">Select Major</option>
                                            <option value="Computer Science">Computer Science</option>
                                            <option value="Management Information System">Management Information System</option>
                                            <option value="Computer Engineering">Computer Engineering</option>
                                            <option value="Business Administration">Business Administration</option>
                                            <option value="Electrical Engineering">Electrical Engineering</option>
                                            <option value="Mechanical Engineering">Mechanical Engineering</option>
                                            <option value="Mechatronics Engineering">Mechatronics Engineering</option>
                                            <option value="Economics">Economics</option>
                                            <option value="Law and Public Policy">Law and Public Policy</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="year_group">Year Group <span class="required">*</span></label>
                                        <select id="year_group" name="year_group" required>
                                            <option value="">Select Year Group</option>
                                            <?php for ($year = 2027; $year >= 2009; $year--): ?>
                                                <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label for="linkedin">LinkedIn URL</label>
                                        <input type="url" id="linkedin" name="linkedin" placeholder="https://www.linkedin.com/in/username">
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="profile_picture">Profile Picture</label>
                                        <div class="file-input-wrapper">
                                            <input type="file" id="profile_picture" name="profile_picture" accept="image/*">
                                            <label for="profile_picture" class="file-input-label">
                                                <i class="fas fa-upload"></i> Choose a file
                                            </label>
                                            <span class="file-name">No file chosen</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-navigation">
                                <button type="button" class="btn btn-primary next-step">
                                    Continue <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 2: Engagement Information -->
                        <div class="form-step" data-step="2">
                            <div class="form-section">
                                <h3 class="section-title">Engagement Information</h3>
                                
                                <div class="form-row">
                                    <div class="form-group col-12">
                                        <label for="engagement_type">Type of International Engagement <span class="required">*</span></label>
                                        <select id="engagement_type" name="engagement_type" required>
                                            <option value="">Select Engagement Type</option>
                                            <option value="Study abroad">Study Abroad</option>
                                            <option value="Research presentation">Research Presentation</option>
                                            <option value="Conference">Conference</option>
                                            <option value="Internship">Internship</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label for="destination_country">Destination Country <span class="required">*</span></label>
                                        <input type="text" id="destination_country" name="destination_country" required>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="institution_name">Institution/Organization Name <span class="required">*</span></label>
                                        <input type="text" id="institution_name" name="institution_name" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-navigation">
                                <button type="button" class="btn btn-secondary prev-step">
                                    <i class="fas fa-arrow-left"></i> Back
                                </button>
                                <button type="button" class="btn btn-primary next-step">
                                    Continue <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: Experience Questions -->
                        <div class="form-step" data-step="3">
                            <div class="form-section">
                                <h3 class="section-title">Experience Questions</h3>
                                
                                <div class="form-group">
                                    <label for="inspiration">What inspired you to participate in this international engagement? <span class="required">*</span></label>
                                    <textarea id="inspiration" name="inspiration" rows="3" required></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="wished_to_know">What did you wish you knew before your experience? <span class="required">*</span></label>
                                    <textarea id="wished_to_know" name="wished_to_know" rows="3" required></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="funny_story">Share a funny or embarrassing story from your experience.</label>
                                    <textarea id="funny_story" name="funny_story" rows="3"></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="things_done">What interesting things did you do during your time abroad?</label>
                                    <textarea id="things_done" name="things_done" rows="3"></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="fears">What fears did you have before going?</label>
                                    <textarea id="fears" name="fears" rows="3"></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="culture_shock">Describe any culture shock you experienced.</label>
                                    <textarea id="culture_shock" name="culture_shock" rows="3"></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="advice">What advice would you give others considering a similar experience? <span class="required">*</span></label>
                                    <textarea id="advice" name="advice" rows="3" required></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="career_change">Did this experience change your career choices? If so, how?</label>
                                    <textarea id="career_change" name="career_change" rows="3"></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="interesting_class">What was the most interesting class or session you attended?</label>
                                    <textarea id="interesting_class" name="interesting_class" rows="3"></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="teaching_style">How was the teaching, learning, or presentation style different?</label>
                                    <textarea id="teaching_style" name="teaching_style" rows="3"></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="personal_change">How did this international engagement change you? <span class="required">*</span></label>
                                    <textarea id="personal_change" name="personal_change" rows="3" required></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="do_differently">What would you do differently if you could do it again?</label>
                                    <textarea id="do_differently" name="do_differently" rows="3"></textarea>
                                </div>
                            </div>
                            
                            <div class="form-navigation">
                                <button type="button" class="btn btn-secondary prev-step">
                                    <i class="fas fa-arrow-left"></i> Back
                                </button>
                                <button type="button" class="btn btn-primary next-step">
                                    Review <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 4: Review Information -->
                        <div class="form-step" data-step="4">
                            <div class="form-section">
                                <h3 class="section-title">Review Your Information</h3>
                                <p class="review-instruction">Please review your information before submitting.</p>
                                
                                <div class="review-section">
                                    <h4><i class="fas fa-user"></i> Personal Information</h4>
                                    <div class="review-grid">
                                        <div class="review-item">
                                            <span class="review-label">Name:</span>
                                            <span class="review-value" id="review-name"></span>
                                        </div>
                                        <div class="review-item">
                                            <span class="review-label">Email:</span>
                                            <span class="review-value" id="review-email"></span>
                                        </div>
                                        <div class="review-item">
                                            <span class="review-label">Gender:</span>
                                            <span class="review-value" id="review-gender"></span>
                                        </div>
                                        <div class="review-item">
                                            <span class="review-label">Nationality:</span>
                                            <span class="review-value" id="review-nationality"></span>
                                        </div>
                                        <div class="review-item">
                                            <span class="review-label">Major:</span>
                                            <span class="review-value" id="review-major"></span>
                                        </div>
                                        <div class="review-item">
                                            <span class="review-label">Year Group:</span>
                                            <span class="review-value" id="review-year"></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="review-section">
                                    <h4><i class="fas fa-plane"></i> Engagement Information</h4>
                                    <div class="review-grid">
                                        <div class="review-item">
                                            <span class="review-label">Engagement Type:</span>
                                            <span class="review-value" id="review-engagement"></span>
                                        </div>
                                        <div class="review-item">
                                            <span class="review-label">Destination:</span>
                                            <span class="review-value" id="review-destination"></span>
                                        </div>
                                        <div class="review-item">
                                            <span class="review-label">Institution:</span>
                                            <span class="review-value" id="review-institution"></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group form-check">
                                    <input type="checkbox" id="confirm-data" class="form-check-input" required>
                                    <label for="confirm-data" class="form-check-label">I confirm that all the information provided is accurate and complete.</label>
                                </div>
                            </div>
                            
                            <div class="form-navigation">
                                <button type="button" class="btn btn-secondary prev-step">
                                    <i class="fas fa-arrow-left"></i> Back
                                </button>
                                <button type="submit" class="btn btn-success" id="submit-form">
                                    <i class="fas fa-paper-plane"></i> Submit Application
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Multi-step form navigation
            const formSteps = document.querySelectorAll('.form-step');
            const progressSteps = document.querySelectorAll('.progress-step');
            const nextButtons = document.querySelectorAll('.next-step');
            const prevButtons = document.querySelectorAll('.prev-step');
            const submitButton = document.getElementById('submit-form');
            
            // Next button click handler
            nextButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const currentStep = this.closest('.form-step');
                    const currentStepNum = parseInt(currentStep.dataset.step);
                    
                    // Validate current step fields before proceeding
                    if (validateStep(currentStepNum)) {
                        // If validation passes, proceed to next step
                        currentStep.classList.remove('active');
                        const nextStep = document.querySelector(`.form-step[data-step="${currentStepNum + 1}"]`);
                        nextStep.classList.add('active');
                        
                        // Update progress bar
                        document.querySelector(`.progress-step[data-step="${currentStepNum}"]`).classList.add('completed');
                        document.querySelector(`.progress-step[data-step="${currentStepNum + 1}"]`).classList.add('active');
                        
                        // Update review information if moving to review step
                        if (currentStepNum + 1 === 4) {
                            updateReviewInfo();
                        }
                        
                        // Scroll to top of form
                        window.scrollTo({
                            top: document.querySelector('.form-progress').offsetTop - 100,
                            behavior: 'smooth'
                        });
                    }
                });
            });
            
            // Previous button click handler
            prevButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const currentStep = this.closest('.form-step');
                    const currentStepNum = parseInt(currentStep.dataset.step);
                    
                    currentStep.classList.remove('active');
                    const prevStep = document.querySelector(`.form-step[data-step="${currentStepNum - 1}"]`);
                    prevStep.classList.add('active');
                    
                    // Update progress bar
                    document.querySelector(`.progress-step[data-step="${currentStepNum}"]`).classList.remove('active');
                    document.querySelector(`.progress-step[data-step="${currentStepNum - 1}"]`).classList.add('active');
                    
                    // Scroll to top of form
                    window.scrollTo({
                        top: document.querySelector('.form-progress').offsetTop - 100,
                        behavior: 'smooth'
                    });
                });
            });
            
            // Form submission handler
            submitButton.addEventListener('click', function(e) {
                if (!document.getElementById('confirm-data').checked) {
                    e.preventDefault();
                    alert('Please confirm that your information is accurate before submitting.');
                }
            });
            
            // File input handler
            const fileInput = document.getElementById('profile_picture');
            const fileName = document.querySelector('.file-name');
            
            if (fileInput) {
                fileInput.addEventListener('change', function() {
                    if (this.files && this.files[0]) {
                        fileName.textContent = this.files[0].name;
                    } else {
                        fileName.textContent = 'No file chosen';
                    }
                });
            }
            
            // Close alert buttons
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
            
            // Function to validate each step
            function validateStep(stepNum) {
                let isValid = true;
                
                // Get all required fields in the current step
                const currentStep = document.querySelector(`.form-step[data-step="${stepNum}"]`);
                const requiredFields = currentStep.querySelectorAll('[required]');
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add('invalid');
                        
                        // Add error message if it doesn't exist
                        let errorMsg = field.nextElementSibling;
                        if (!errorMsg || !errorMsg.classList.contains('error-message')) {
                            errorMsg = document.createElement('div');
                            errorMsg.classList.add('error-message');
                            errorMsg.textContent = 'This field is required';
                            field.parentNode.insertBefore(errorMsg, field.nextSibling);
                        }
                    } else {
                        field.classList.remove('invalid');
                        
                        // Remove error message if it exists
                        const errorMsg = field.nextElementSibling;
                        if (errorMsg && errorMsg.classList.contains('error-message')) {
                            errorMsg.remove();
                        }
                    }
                });
                
                return isValid;
            }
            
            // Function to update review information
            function updateReviewInfo() {
                // Personal information
                document.getElementById('review-name').textContent = document.getElementById('name').value;
                document.getElementById('review-email').textContent = document.getElementById('email').value;
                document.getElementById('review-gender').textContent = document.getElementById('gender').value;
                document.getElementById('review-nationality').textContent = document.getElementById('nationality').value;
                document.getElementById('review-major').textContent = document.getElementById('major').value;
                document.getElementById('review-year').textContent = document.getElementById('year_group').value;
                
                // Engagement information
                document.getElementById('review-engagement').textContent = document.getElementById('engagement_type').value;
                document.getElementById('review-destination').textContent = document.getElementById('destination_country').value;
                document.getElementById('review-institution').textContent = document.getElementById('institution_name').value;
            }
        });
    </script>
</body>
</html>