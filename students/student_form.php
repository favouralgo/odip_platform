<?php

// Include database connection
include "../config/connection.php";

// Process form submission
// $success_message = '';
// $error_message = '';

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     // Get form data
//     $name = mysqli_real_escape_string($connection, $_POST['name']);
//     $gender = mysqli_real_escape_string($connection, $_POST['gender']);
//     $nationality = mysqli_real_escape_string($connection, $_POST['nationality']);
//     $major = mysqli_real_escape_string($connection, $_POST['major']);
//     $year_group = mysqli_real_escape_string($connection, $_POST['year_group']);
//     $email = mysqli_real_escape_string($connection, $_POST['email']);
//     $linkedin = isset($_POST['linkedin']) ? mysqli_real_escape_string($connection, $_POST['linkedin']) : '';
//     $has_picture = isset($_FILES['profile_picture']) && $_FILES['profile_picture']['size'] > 0 ? 1 : 0;
    
//     // Begin transaction
//     mysqli_begin_transaction($connection);
    
//     try {
//         // Insert into students table
//         $student_query = "INSERT INTO students (name, gender, nationality, major, year_group, email_address, linkedin_url, has_picture) 
//                          VALUES ('$name', '$gender', '$nationality', '$major', '$year_group', '$email', '$linkedin', $has_picture)";
        
//         if (!mysqli_query($connection, $student_query)) {
//             throw new Exception("Error creating student record: " . mysqli_error($connection));
//         }
        
//         $student_id = mysqli_insert_id($connection);
        
//         // Get engagement data
//         $engagement_type = mysqli_real_escape_string($connection, $_POST['engagement_type']);
//         $destination = mysqli_real_escape_string($connection, $_POST['destination_country']);
//         $institution = mysqli_real_escape_string($connection, $_POST['institution_name']);
        
//         // Insert into engagements table with default status of 'pending'
//         $engagement_query = "INSERT INTO engagements (student_id, engagement_type, destination_country, institution_name, status) 
//                             VALUES ($student_id, '$engagement_type', '$destination', '$institution', 'pending')";
        
//         if (!mysqli_query($connection, $engagement_query)) {
//             throw new Exception("Error creating engagement record: " . mysqli_error($connection));
//         }
        
//         $engagement_id = mysqli_insert_id($connection);
        
//         // Get experience data
//         $inspiration = mysqli_real_escape_string($connection, $_POST['inspiration']);
//         $wished_to_know = mysqli_real_escape_string($connection, $_POST['wished_to_know']);
//         $funny_story = mysqli_real_escape_string($connection, $_POST['funny_story']);
//         $things_done = mysqli_real_escape_string($connection, $_POST['things_done']);
//         $fears = mysqli_real_escape_string($connection, $_POST['fears']);
//         $culture_shock = mysqli_real_escape_string($connection, $_POST['culture_shock']);
//         $advice = mysqli_real_escape_string($connection, $_POST['advice']);
//         $career_change = mysqli_real_escape_string($connection, $_POST['career_change']);
//         $interesting_class = mysqli_real_escape_string($connection, $_POST['interesting_class']);
//         $teaching_style = mysqli_real_escape_string($connection, $_POST['teaching_style']);
//         $personal_change = mysqli_real_escape_string($connection, $_POST['personal_change']);
//         $do_differently = mysqli_real_escape_string($connection, $_POST['do_differently']);
        
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
        
//         if (!mysqli_query($connection, $experience_query)) {
//             throw new Exception("Error creating experience record: " . mysqli_error($connection));
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
                
//                 if (!mysqli_query($connection, $picture_query)) {
//                     throw new Exception("Error saving picture: " . mysqli_error($connection));
//                 }
//             } else {
//                 throw new Exception("Error uploading picture");
//             }
//         }
        
//         // Commit the transaction
//         mysqli_commit($connection);
//         $success_message = "Your application has been submitted successfully! It will be reviewed by an administrator.";
        
//     } catch (Exception $e) {
//         // Rollback the transaction in case of error
//         mysqli_rollback($connection);
//         $error_message = $e->getMessage();
//     }
// }

// List of nationalities for dropdown
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>International Engagement Experience Application | ODIP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/student_form.css">
</head>
<body>
    <div class="form-container">
        <header class="form-header">
            <div class="logo-container">
                <div class="logo">
                    <i class="fas fa-globe-americas"></i>
                </div>
                <h1>ODIP International Engagement</h1>
            </div>
            <div class="header-actions">
                <a href="../index.php" class="btn-outlined">
                    <i class="fas fa-home"></i> Home
                </a>
            </div>
        </header>

        <div class="main-content">

            <?php if (!empty($success_message)): ?>
            <div class="alert alert-success">
                <div class="alert-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="alert-content">
                    <p><?php echo $success_message; ?></p>
                </div>
                <button class="close-alert">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <?php endif; ?>

            <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger">
                <div class="alert-icon">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <div class="alert-content">
                    <p><?php echo $error_message; ?></p>
                </div>
                <button class="close-alert">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <?php endif; ?>

            <div class="form-card">
                <div class="card-header">
                    <h3><i class="fas fa-file-alt"></i> New International Engagement Experience Application</h3>
                </div>
                <div class="card-body">
                    <form action="student_form.php" method="POST" enctype="multipart/form-data" class="multi-step-form">
                        <!-- Progress Tracker -->
                        <div class="progress-tracker">
                            <div class="progress-step active" data-step="1">
                                <div class="step-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="step-label">Personal Info</div>
                                <div class="step-line"></div>
                            </div>
                            <div class="progress-step" data-step="2">
                                <div class="step-icon">
                                    <i class="fas fa-plane-departure"></i>
                                </div>
                                <div class="step-label">Engagement</div>
                                <div class="step-line"></div>
                            </div>
                            <div class="progress-step" data-step="3">
                                <div class="step-icon">
                                    <i class="fas fa-comment-dots"></i>
                                </div>
                                <div class="step-label">Experience</div>
                                <div class="step-line"></div>
                            </div>
                            <div class="progress-step" data-step="4">
                                <div class="step-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="step-label">Review</div>
                            </div>
                        </div>

                        <!-- Step 1: Personal Information -->
                        <div class="form-step active" data-step="1">
                            <div class="form-section">
                                <h3 class="section-title">Personal Information</h3>
                                
                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label for="name">
                                            <i class="fas fa-user"></i> Full Name <span class="required">*</span>
                                        </label>
                                        <input type="text" id="name" name="name" placeholder="Enter your full name" required>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="email">
                                            <i class="fas fa-envelope"></i> Email Address <span class="required">*</span>
                                        </label>
                                        <input type="email" id="email" name="email" placeholder="Enter your email address" required>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label for="gender">
                                            <i class="fas fa-venus-mars"></i> Gender <span class="required">*</span>
                                        </label>
                                        <div class="select-container">
                                            <select id="gender" name="gender" required>
                                                <option value="">Select Gender</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                            <div class="select-arrow">
                                                <i class="fas fa-chevron-down"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="nationality">
                                            <i class="fas fa-flag"></i> Nationality <span class="required">*</span>
                                        </label>
                                        <div class="select-container">
                                            <select id="nationality" name="nationality" required>
                                                <option value="">Select Nationality</option>
                                                <?php foreach ($nationalities as $nationality): ?>
                                                    <option value="<?php echo $nationality; ?>"><?php echo $nationality; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div class="select-arrow">
                                                <i class="fas fa-chevron-down"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label for="major">
                                            <i class="fas fa-graduation-cap"></i> Major <span class="required">*</span>
                                        </label>
                                        <div class="select-container">
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
                                            <div class="select-arrow">
                                                <i class="fas fa-chevron-down"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="year_group">
                                            <i class="fas fa-calendar-alt"></i> Year Group <span class="required">*</span>
                                        </label>
                                        <div class="select-container">
                                            <select id="year_group" name="year_group" required>
                                                <option value="">Select Year Group</option>
                                                <?php for ($year = 2027; $year >= 2009; $year--): ?>
                                                    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                                <?php endfor; ?>
                                            </select>
                                            <div class="select-arrow">
                                                <i class="fas fa-chevron-down"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label for="linkedin">
                                            <i class="fab fa-linkedin"></i> LinkedIn URL
                                        </label>
                                        <input type="url" id="linkedin" name="linkedin" placeholder="https://www.linkedin.com/in/username">
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="profile_picture">
                                            <i class="fas fa-image"></i> Profile Picture
                                        </label>
                                        <div class="file-upload">
                                            <input type="file" id="profile_picture" name="profile_picture" accept="image/*" class="file-input">
                                            <label for="profile_picture" class="file-label">
                                                <i class="fas fa-cloud-upload-alt"></i> Choose a file
                                            </label>
                                            <span class="file-name">No file chosen</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-navigation">
                                <button type="button" class="btn-next">
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
                                        <label for="engagement_type">
                                            <i class="fas fa-exchange-alt"></i> Type of International Engagement <span class="required">*</span>
                                        </label>
                                        <div class="select-container">
                                            <select id="engagement_type" name="engagement_type" required>
                                                <option value="">Select Engagement Type</option>
                                                <option value="Study abroad">Study Abroad</option>
                                                <option value="Research presentation">Research Presentation</option>
                                                <option value="Conference">Conference</option>
                                                <option value="Internship">Internship</option>
                                                <option value="Other">Other</option>
                                            </select>
                                            <div class="select-arrow">
                                                <i class="fas fa-chevron-down"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label for="destination_country">
                                            <i class="fas fa-map-marker-alt"></i> Destination Country <span class="required">*</span>
                                        </label>
                                        <input type="text" id="destination_country" name="destination_country" placeholder="Country you visited" required>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="institution_name">
                                            <i class="fas fa-university"></i> Institution/Organization Name <span class="required">*</span>
                                        </label>
                                        <input type="text" id="institution_name" name="institution_name" placeholder="Name of institution/organization" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-navigation">
                                <button type="button" class="btn-prev">
                                    <i class="fas fa-arrow-left"></i> Back
                                </button>
                                <button type="button" class="btn-next">
                                    Continue <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: Experience Questions -->
                        <div class="form-step" data-step="3">
                            <div class="form-section">
                                <h3 class="section-title">Experience Questions</h3>
                                
                                <div class="form-group">
                                    <label for="inspiration">
                                        <i class="fas fa-lightbulb"></i> What inspired you to participate in this international engagement? <span class="required">*</span>
                                    </label>
                                    <textarea id="inspiration" name="inspiration" rows="3" placeholder="Share what motivated you to participate" required></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="wished_to_know">
                                        <i class="fas fa-question-circle"></i> What did you wish you knew before your experience? <span class="required">*</span>
                                    </label>
                                    <textarea id="wished_to_know" name="wished_to_know" rows="3" placeholder="Share information you wish you had known beforehand" required></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="funny_story">
                                        <i class="fas fa-smile-wink"></i> Share a funny or embarrassing story from your experience.
                                    </label>
                                    <textarea id="funny_story" name="funny_story" rows="3" placeholder="Optional: Share a memorable story"></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="things_done">
                                        <i class="fas fa-clipboard-list"></i> What interesting things did you do during your time abroad?
                                    </label>
                                    <textarea id="things_done" name="things_done" rows="3" placeholder="Activities, sites visited, experiences, etc."></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="fears">
                                        <i class="fas fa-exclamation-triangle"></i> What fears did you have before going?
                                    </label>
                                    <textarea id="fears" name="fears" rows="3" placeholder="Share any concerns or worries you had"></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="culture_shock">
                                        <i class="fas fa-dizzy"></i> Describe any culture shock you experienced.
                                    </label>
                                    <textarea id="culture_shock" name="culture_shock" rows="3" placeholder="Cultural differences that surprised you"></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="advice">
                                        <i class="fas fa-hands-helping"></i> What advice would you give others considering a similar experience? <span class="required">*</span>
                                    </label>
                                    <textarea id="advice" name="advice" rows="3" placeholder="Share your recommendations for future students" required></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="career_change">
                                        <i class="fas fa-briefcase"></i> Did this experience change your career choices? If so, how?
                                    </label>
                                    <textarea id="career_change" name="career_change" rows="3" placeholder="Impact on your career goals"></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="interesting_class">
                                        <i class="fas fa-chalkboard-teacher"></i> What was the most interesting class or session you attended?
                                    </label>
                                    <textarea id="interesting_class" name="interesting_class" rows="3" placeholder="Describe a memorable class or session"></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="teaching_style">
                                        <i class="fas fa-book-reader"></i> How was the teaching, learning, or presentation style different?
                                    </label>
                                    <textarea id="teaching_style" name="teaching_style" rows="3" placeholder="Differences in educational approaches"></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="personal_change">
                                        <i class="fas fa-user-graduate"></i> How did this international engagement change you? <span class="required">*</span>
                                    </label>
                                    <textarea id="personal_change" name="personal_change" rows="3" placeholder="Personal growth and development from this experience" required></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="do_differently">
                                        <i class="fas fa-redo-alt"></i> What would you do differently if you could do it again?
                                    </label>
                                    <textarea id="do_differently" name="do_differently" rows="3" placeholder="Changes you would make to your experience"></textarea>
                                </div>
                            </div>
                            
                            <div class="form-navigation">
                                <button type="button" class="btn-prev">
                                    <i class="fas fa-arrow-left"></i> Back
                                </button>
                                <button type="button" class="btn-next">
                                    Review <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 4: Review Information -->
                        <div class="form-step" data-step="4">
                            <div class="form-section">
                                <h3 class="section-title">Review Your Information</h3>
                                <p class="section-description">Please review all the information you've provided before submitting your application.</p>
                                
                                <div class="review-box">
                                    <div class="review-header">
                                        <h4><i class="fas fa-user"></i> Personal Information</h4>
                                        <button type="button" class="btn-edit" data-target="1">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                    </div>
                                    <div class="review-content">
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
                                </div>
                                
                                <div class="review-box">
                                    <div class="review-header">
                                        <h4><i class="fas fa-plane-departure"></i> Engagement Information</h4>
                                        <button type="button" class="btn-edit" data-target="2">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                    </div>
                                    <div class="review-content">
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
                                </div>
                                
                                <div class="review-box">
                                    <div class="review-header">
                                        <h4><i class="fas fa-comment-dots"></i> Experience Highlights</h4>
                                        <button type="button" class="btn-edit" data-target="3">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                    </div>
                                    <div class="review-content">
                                        <div class="review-grid">
                                            <div class="review-item col-12">
                                                <span class="review-label">Inspiration:</span>
                                                <span class="review-value" id="review-inspiration"></span>
                                            </div>
                                            <div class="review-item col-12">
                                                <span class="review-label">Advice:</span>
                                                <span class="review-value" id="review-advice"></span>
                                            </div>
                                            <div class="review-item col-12">
                                                <span class="review-label">Personal Change:</span>
                                                <span class="review-value" id="review-personal-change"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="application-notice">
                                    <i class="fas fa-info-circle"></i>
                                    <p>Your application will be submitted with a status of <span class="status-badge status-pending">Pending</span> and will need to be approved by an administrator.</p>
                                </div>
                                
                                <div class="form-group confirmation-checkbox">
                                    <input type="checkbox" id="confirm-data" required>
                                    <label for="confirm-data">
                                        I confirm that all the information provided is accurate and complete.
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-navigation">
                                <button type="button" class="btn-prev">
                                    <i class="fas fa-arrow-left"></i> Back
                                </button>
                                <button type="submit" class="btn-submit" id="submit-form">
                                    <i class="fas fa-paper-plane"></i> Submit Application
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <footer class="form-footer">
            <p>&copy; <?php echo date('Y'); ?> ODIP International Engagement. All rights reserved.</p>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Multi-step form navigation
            const formSteps = document.querySelectorAll('.form-step');
            const progressSteps = document.querySelectorAll('.progress-step');
            const nextButtons = document.querySelectorAll('.btn-next');
            const prevButtons = document.querySelectorAll('.btn-prev');
            const editButtons = document.querySelectorAll('.btn-edit');
            const submitButton = document.getElementById('submit-form');
            
            // Next button click handler
            nextButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const currentStep = this.closest('.form-step');
                    const currentStepNum = parseInt(currentStep.dataset.step);
                    
                    // Validate current step fields before proceeding
                    if (validateStep(currentStepNum)) {
                        // If validation passes, proceed to next step
                        goToStep(currentStepNum + 1);
                        
                        // Update review information if moving to review step
                        if (currentStepNum + 1 === 4) {
                            updateReviewInfo();
                        }
                    }
                });
            });
            
            // Previous button click handler
            prevButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const currentStep = this.closest('.form-step');
                    const currentStepNum = parseInt(currentStep.dataset.step);
                    goToStep(currentStepNum - 1);
                });
            });
            
            // Edit button click handler
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetStep = parseInt(this.dataset.target);
                    goToStep(targetStep);
                });
            });
            
            // Form submission handler
            submitButton.addEventListener('click', function(e) {
                if (!document.getElementById('confirm-data').checked) {
                    e.preventDefault();
                    showError('Please confirm that your information is accurate before submitting.');
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
                    this.closest('.alert').style.display = 'none';
                });
            });
            
            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    alert.style.display = 'none';
                });
            }, 5000);
            
            // Function to navigate to a specific step
            function goToStep(stepNumber) {
                // Update form steps
                formSteps.forEach(step => {
                    step.classList.remove('active');
                });
                document.querySelector(`.form-step[data-step="${stepNumber}"]`).classList.add('active');
                
                // Update progress tracker
                progressSteps.forEach((step, index) => {
                    const stepNum = index + 1;
                    
                    if (stepNum < stepNumber) {
                        step.classList.add('completed');
                        step.classList.remove('active');
                    } else if (stepNum === stepNumber) {
                        step.classList.add('active');
                        step.classList.remove('completed');
                    } else {
                        step.classList.remove('active', 'completed');
                    }
                });
                
                // Scroll to top of form
                window.scrollTo({
                    top: document.querySelector('.progress-tracker').offsetTop - 20,
                    behavior: 'smooth'
                });
            }
            
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
            
            // Function to show error message
            function showError(message) {
                // Create error alert if not exist
                let errorAlert = document.querySelector('.alert.alert-danger');
                
                if (!errorAlert) {
                    errorAlert = document.createElement('div');
                    errorAlert.className = 'alert alert-danger';
                    
                    const alertIcon = document.createElement('div');
                    alertIcon.className = 'alert-icon';
                    alertIcon.innerHTML = '<i class="fas fa-exclamation-circle"></i>';
                    
                    const alertContent = document.createElement('div');
                    alertContent.className = 'alert-content';
                    
                    const closeBtn = document.createElement('button');
                    closeBtn.className = 'close-alert';
                    closeBtn.innerHTML = '<i class="fas fa-times"></i>';
                    closeBtn.addEventListener('click', function() {
                        errorAlert.style.display = 'none';
                    });
                    
                    errorAlert.appendChild(alertIcon);
                    errorAlert.appendChild(alertContent);
                    errorAlert.appendChild(closeBtn);
                    
                    const formCard = document.querySelector('.form-card');
                    formCard.parentNode.insertBefore(errorAlert, formCard);
                }
                
                // Update error message
                const alertContent = errorAlert.querySelector('.alert-content');
                alertContent.innerHTML = `<p>${message}</p>`;
                
                // Show alert
                errorAlert.style.display = 'flex';
                
                // Scroll to error message
                window.scrollTo({
                    top: errorAlert.offsetTop - 20,
                    behavior: 'smooth'
                });
                
                // Auto-hide after 5 seconds
                setTimeout(function() {
                    errorAlert.style.display = 'none';
                }, 5000);
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
                
                // Experience highlights
                document.getElementById('review-inspiration').textContent = truncateText(document.getElementById('inspiration').value, 150);
                document.getElementById('review-advice').textContent = truncateText(document.getElementById('advice').value, 150);
                document.getElementById('review-personal-change').textContent = truncateText(document.getElementById('personal_change').value, 150);
            }
            
            // Function to truncate text
            function truncateText(text, maxLength) {
                if (text.length <= maxLength) return text;
                return text.substr(0, maxLength) + '...';
            }
        });
    </script>
</body>
</html>