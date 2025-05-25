<?php
// Include database connection
include "config/connection.php";

// Get all students with their engagement details
$query = "SELECT s.student_id, s.name, s.year_group, s.major, s.nationality, s.has_picture, s.email_address,
          e.engagement_type, e.destination_country, e.institution_name
          FROM students s
          LEFT JOIN engagements e ON s.student_id = e.student_id
          WHERE e.status = 'approved' OR e.status IS NULL
          ORDER BY s.name ASC
          LIMIT 8"; // Limit to 8 students for the gallery

$result = $connection->query($query);
$students = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
}

// Get region options for dropdown
$regionOptions = ['Africa', 'Europe', 'Asia', 'Americas'];

// Get year options for dropdown
$yearQuery = "SELECT DISTINCT year_group FROM students ORDER BY year_group DESC";
$yearResult = $connection->query($yearQuery);
$yearOptions = [];

if ($yearResult) {
    while ($row = $yearResult->fetch_assoc()) {
        $yearOptions[] = $row['year_group'];
    }
}

// Get university options for dropdown
$universityQuery = "SELECT DISTINCT institution_name FROM engagements WHERE institution_name IS NOT NULL ORDER BY institution_name ASC";
$universityResult = $connection->query($universityQuery);
$universityOptions = [];

if ($universityResult) {
    while ($row = $universityResult->fetch_assoc()) {
        if (!empty($row['institution_name'])) {
            $universityOptions[] = $row['institution_name'];
        }
    }
}

// Convert students array to JSON for JavaScript use
$studentsJson = json_encode($students);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ODIP Experience Platform</title>
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/modal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header class="header">
        <img src="images/Ashesi image2.webp" alt="ashesi university" class="logo" />
        <nav class="nav">
            <a href="index.php">Home</a>
            <a href="#">About</a>
            <a href="students/student.php">Meet the students</a>
            <a href="#">Impact</a>
            <a href="auth/login.php">Login</a>
        </nav>
      
    </header>
    
    <section class="hero">
        <img src="images/Ashesi image3.jpg" alt="international engagement fellows" class="hero-img"   />
        <div class="overlay">
            <h1 class="hero-title">Meet the students</h1>
        </div>
    </section>
    <section class="content">
        <div class="container">
            <div class="description">
                <p>
                    The ODIP Student Profile Platform, developed by Ashesi students for Ashesi students, is a transformative digital space designed to bridge the gap between ambition and opportunity. Born from a need to address <strong>information asymmetry</strong> in study abroad programs, this platform connects you with firsthand experiences from peers and alumni who have walked the path you’re considering.
                </p>
                
                <p>
                    Through authentic stories, practical advice, and mentorship, the platform demystifies the study abroad journey—helping you make informed decisions about programs, credit transfers, and cultural adaptation. Whether you’re a first-year student curious about exchanges or a senior weighing postgraduate options, the ODIP Student Profile Platform is your gateway to <strong> global readiness. </strong>
                </p>
               
            </div>
        </div>
    </section>
    <div class="stats-container">
        <div class="stat-item">
            <div class="stat-number">100+</div>
            <div class="stat-label">Ashesi<br>Students</div>
        </div>
        
        <div class="stat-item">
            <div class="stat-number">330+</div>
            <div class="stat-label">Campuses</div>
        </div>
        
        <div class="stat-item">
            <div class="stat-number">48</div>
            <div class="stat-label">Countries</div>
        </div>
    </div>
    
    <!-- Search Instructions -->
    <p class="search-text">Please search by any of these criteria to learn about the study abroad program.</p>
    
    <!-- First Row of Search Options -->
    <div class="search-container">
        <div class="dropdown-container">
            <select name="region" id="regionSelect">
                <option value="">Region</option>
                <?php foreach ($regionOptions as $region): ?>
                    <option value="<?php echo $region; ?>"><?php echo $region; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="dropdown-container">
            <select name="year" id="yearSelect">
                <option value="">Year</option>
                <?php foreach ($yearOptions as $year): ?>
                    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="dropdown-container">
            <select name="university" id="universitySelect">
                <option value="">University/Institution</option>
                <?php foreach ($universityOptions as $university): ?>
                    <option value="<?php echo htmlspecialchars($university); ?>"><?php echo htmlspecialchars($university); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="search-box">
            <input type="text" id="keywordInput" placeholder="Search by Keyword">
            <button class="search-button" id="searchButton">
                <span class="search-icon">⌕</span>
            </button>
        </div>
    </div>
    
    <!-- Second Row of Search Options -->
    <div class="filters-container">
        <button class="clear-button" id="clearButton">Clear filters</button>
    </div>
    
    <!-- Student Gallery Container -->
    <div class="gallery-container" id="galleryContainer">
        <!-- Top row -->
        <div class="gallery-row">
            <?php 
            $count = 0;
            foreach ($students as $student): 
                if ($count == 4) echo '</div><div class="gallery-row">';
            ?>
                <div class="fellow-card" data-id="<?php echo $student['student_id']; ?>">
                    <div class="fellow-image-container" style="border-color: #8F3B3B;">
                        <?php if ($student['has_picture']): ?>
                            <img src="uploads/student_<?php echo $student['student_id']; ?>.jpg" alt="<?php echo htmlspecialchars($student['name']); ?>" class="fellow-image">
                        <?php else: ?>
                            <img src="images/default_profile.png" alt="<?php echo htmlspecialchars($student['name']); ?>" class="fellow-image">
                        <?php endif; ?>
                    </div>
                    <p class="fellow-name"><?php echo htmlspecialchars($student['name']); ?></p>
                </div>
            <?php 
                $count++;
                endforeach; 
            ?>
        </div>
    </div>

    <!-- Modal for Student Information -->
    <div id="fellowModal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <div class="modal-header">
                <div class="modal-image-container">
                    <img id="modalFellowImage" src="" alt="Student Image">
                </div>
                <h2 id="modalFellowName"></h2>
            </div>
            <div class="modal-body">
                <div class="fellow-details">
                    <p><strong>Year Group:</strong> <span id="modalYear"></span></p>
                    <p><strong>Major:</strong> <span id="modalMajor"></span></p>
                    <p><strong>Nationality:</strong> <span id="modalNationality"></span></p>
                    <p><strong>Engagement:</strong> <span id="modalEngagement"></span></p>
                    <p><strong>Destination:</strong> <span id="modalDestination"></span></p>
                    <p><strong>Institution:</strong> <span id="modalInstitution"></span></p>
                </div>
                <div>
                    <div class="fellow-bio">
                        <h3>About Their Experience</h3>
                        <p id="modalInspiration"></p>
                    </div>
                    <div class="fellow-project">
                        <h3>Personal Growth</h3>
                        <p id="modalPersonalChange"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-left">
                <div class="subscribe-form">
                    <input type="email" placeholder="Subscribe..." class="subscribe-input">
                    <button type="submit" class="subscribe-button">
                        <i class="fa fa-envelope"></i>
                    </button>
                </div>
                <div class="social-media">
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-medium"></i></a>
                </div>
            </div>

            <div class="footer-center">
                <div class="university-logo">
                    <img src="images/Ashesi image2.webp" alt="Ashesi University Logo">
                </div>
                <div class="university-address">
                    <p>1 University Avenue,</p>
                    <p>Berekuso, Ghana.</p>
                </div>
                <div class="university-contact">
                    <p><strong>Phone:</strong> +233 302 610 330</p>
                    <p><strong>Email:</strong> info@ashesi.edu.gh</p>
                </div>
            </div>

            <div class="footer-right">
                <a href="#" class="action-button">
                    Apply to Ashesi
                    <span class="arrow-icon">→</span>
                </a>
                <a href="#" class="action-button">
                    Join Our Faculty
                    <span class="arrow-icon">→</span>
                </a>
                <a href="#" class="action-button">
                    Recruit Students
                    <span class="arrow-icon">→</span>
                </a>
            </div>
        </div>
        <div class="copyright">
            <p>Copyright © Ashesi University</p>
        </div>
    </footer>

    <script>
        // Initial student data
        const initialStudents = <?php echo $studentsJson; ?>;
        
        // DOM elements
        const galleryContainer = document.getElementById('galleryContainer');
        const modal = document.getElementById('fellowModal');
        const modalClose = document.querySelector('.close-modal');
        
        // Modal elements
        const modalFellowName = document.getElementById('modalFellowName');
        const modalFellowImage = document.getElementById('modalFellowImage');
        const modalYear = document.getElementById('modalYear');
        const modalMajor = document.getElementById('modalMajor');
        const modalNationality = document.getElementById('modalNationality');
        const modalEngagement = document.getElementById('modalEngagement');
        const modalDestination = document.getElementById('modalDestination');
        const modalInstitution = document.getElementById('modalInstitution');
        const modalInspiration = document.getElementById('modalInspiration');
        const modalPersonalChange = document.getElementById('modalPersonalChange');
        
        // Search elements
        const keywordInput = document.getElementById('keywordInput');
        const regionSelect = document.getElementById('regionSelect');
        const yearSelect = document.getElementById('yearSelect');
        const universitySelect = document.getElementById('universitySelect');
        const searchButton = document.getElementById('searchButton');
        const clearButton = document.getElementById('clearButton');
        
        // Function to show student details in modal
        function showStudentModal(studentId) {
            // Fetch full student details
            fetch(`ajax/get_student_details.php?id=${studentId}`)
                .then(response => response.json())
                .then(student => {
                    if (student.error) {
                        console.error('Error:', student.error);
                        return;
                    }
                    
                    // Populate modal with student data
                    modalFellowName.textContent = student.name;
                    
                    // Set student image
                    if (student.has_picture == 1) {
                        modalFellowImage.src = `uploads/student_${student.student_id}.jpg`;
                    } else {
                        modalFellowImage.src = "images/default_profile.png";
                    }
                    
                    modalFellowImage.alt = student.name;
                    modalYear.textContent = student.year_group || "Not specified";
                    modalMajor.textContent = student.major || "Not specified";
                    modalNationality.textContent = student.nationality || "Not specified";
                    modalEngagement.textContent = student.engagement_type || "Not specified";
                    modalDestination.textContent = student.destination_country || "Not specified";
                    modalInstitution.textContent = student.institution_name || "Not specified";
                    
                    // Set experience details
                    modalInspiration.textContent = student.inspiration || "No information provided.";
                    modalPersonalChange.textContent = student.personal_change || "No information provided.";
                    
                    // Display modal
                    modal.style.display = "block";
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                });
        }
        
        // Function to update the gallery with search results
        function updateGallery(students) {
            if (students.length === 0) {
                galleryContainer.innerHTML = '<div class="empty-results">No students found matching your criteria.</div>';
                return;
            }
            
            let html = '<div class="gallery-row">';
            students.forEach((student, index) => {
                if (index > 0 && index % 4 === 0) {
                    html += '</div><div class="gallery-row">';
                }
                
                const imgSrc = student.has_picture == 1 
                    ? `uploads/student_${student.student_id}.jpg` 
                    : 'images/default_profile.png';
                
                html += `
                    <div class="fellow-card" data-id="${student.student_id}">
                        <div class="fellow-image-container" style="border-color: #8F3B3B;">
                            <img src="${imgSrc}" alt="${student.name}" class="fellow-image">
                        </div>
                        <p class="fellow-name">${student.name}</p>
                    </div>
                `;
            });
            html += '</div>';
            
            galleryContainer.innerHTML = html;
            
            // Attach click events to all cards
            attachCardClickEvents();
        }
        
        // Function to attach click events to all cards
        function attachCardClickEvents() {
            const fellowCards = document.querySelectorAll('.fellow-card');
            fellowCards.forEach(card => {
                card.addEventListener('click', function() {
                    const studentId = this.getAttribute('data-id');
                    showStudentModal(studentId);
                });
            });
        }
        
        // Function to perform search
        function performSearch() {
            const keyword = keywordInput.value;
            const region = regionSelect.value;
            const year = yearSelect.value;
            const university = universitySelect.value;
            
            // Build the search URL
            const searchUrl = `ajax/search_students.php?keyword=${encodeURIComponent(keyword)}&region=${encodeURIComponent(region)}&year=${encodeURIComponent(year)}&university=${encodeURIComponent(university)}`;
            
            fetch(searchUrl)
                .then(response => response.json())
                .then(students => updateGallery(students))
                .catch(error => console.error('Error searching students:', error));
        }
        
        // Attach event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize with click events
            attachCardClickEvents();
            
            // Close modal when clicking X
            modalClose.addEventListener('click', function() {
                modal.style.display = "none";
            });
            
            // Close modal when clicking outside
            window.addEventListener('click', function(event) {
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            });
            
            // Search button click
            searchButton.addEventListener('click', performSearch);
            
            // Enter key in search input
            keywordInput.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    performSearch();
                }
            });
            
            // Select dropdown changes
            regionSelect.addEventListener('change', performSearch);
            yearSelect.addEventListener('change', performSearch);
            universitySelect.addEventListener('change', performSearch);
            
            // Clear filters button
            clearButton.addEventListener('click', function() {
                keywordInput.value = '';
                regionSelect.selectedIndex = 0;
                yearSelect.selectedIndex = 0;
                universitySelect.selectedIndex = 0;
                updateGallery(initialStudents);
            });
        });
    </script>
</body>
</html>