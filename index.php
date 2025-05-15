<!DOCTYPE html>
<html lang="en">
<head>    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ODIP Experience Platform</title>
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/modal.css">
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
                    The Fellowship, presented by the United Nations Academic Impact and ADLI, is a semester-long leadership development program that takes place on campuses worldwide. Aimed at advancing your leadership skills, the Fellowship offers a unique opportunity to engage with a global network of peers dedicated to making a significant social impact.
                </p>
                
                <p>
                    Fellows have the chance to engage in a series of sessions focused on developing actionable plans for their social impact projects, sharing best practices, and contributing to the Sustainable Development Goals (SDGs) in meaningful ways. Through collaborative learning and practical action, Fellows are prepared to lead initiatives that drive positive change within their communities and beyond.
                </p>
                
                <p>
                    The program has grown to become a powerful global movement, with over 15,000 Fellows having graduated since its inception. These alumni represent more than 300 campuses across 48 nations, demonstrating the extensive reach and collective strength of the Fellowship. This community of fellows is a testament to the program's success in nurturing leaders who are committed to advancing global goals and creating a more sustainable and equitable world.
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
            <select name="region">
                <option value="">Region</option>
                <!-- Add options here -->
            </select>
        </div>
        
        <div class="dropdown-container">
            <select name="all">
                <option value="">All</option>
                <!-- Add options here -->
            </select>
        </div>
        
        <div class="dropdown-container">
            <select name="university">
                <option value="">University</option>
                <!-- Add options here -->
            </select>
        </div>
        
        <div class="search-box">
            <input type="text" placeholder="Search by Keyword">
            <button class="search-button">
                <span class="search-icon">⌕</span>
            </button>
        </div>
    </div>
    
    <!-- Second Row of Search Options -->
    <div class="filters-container">
        <div class="dropdown-container">
            <select name="year">
                <option value="">Year</option>
                <!-- Add options here -->
            </select>
        </div>
        
        <div class="dropdown-container">
            <select name="sdg">
                <option value="">Sustainable Development Goal</option>
                <!-- Add options here -->
            </select>
        </div>
        
        <div class="dropdown-container">
            <select name="role">
                <option value="">Millennium Fellowship Role</option>
                <!-- Add options here -->
            </select>
        </div>
        
        <button class="clear-button">Clear filters</button>
    </div>
    <div class="gallery-container">
        <!-- Top row -->
        <div class="gallery-row">
            <div class="fellow-card">
                <div class="fellow-image-container" style="border-color: #8F3B3B;">
                    <img src="/api/placeholder/200/200" alt="Kehinde Adebiyi" class="fellow-image">
                </div>
                <p class="fellow-name">Kehinde Adebiyi</p>
            </div>

            <div class="fellow-card">
                <div class="fellow-image-container" style="border-color: #8F3B3B;">
                    <img src="/api/placeholder/200/200" alt="Idongesit Ubon" class="fellow-image">
                </div>
                <p class="fellow-name">Idongesit Ubon</p>
            </div>

            <div class="fellow-card">
                <div class="fellow-image-container" style="border-color: #8F3B3B;">
                    <img src="/api/placeholder/200/200" alt="Sarosh Nagar" class="fellow-image">
                </div>
                <p class="fellow-name">Sarosh Nagar</p>
            </div>

            <div class="fellow-card">
                <div class="fellow-image-container" style="border-color: #8F3B3B;">
                    <img src="/api/placeholder/200/200" alt="Millennium Fellowship Logo" class="fellow-image">
                </div>
                <p class="fellow-name">Khulood Ali Hassan</p>
            </div>
        </div>

        <!-- Bottom row -->
        <div class="gallery-row">
            <div class="fellow-card">
                <div class="fellow-image-container" style="border-color: #8F3B3B;">
                    <img src="/api/placeholder/200/200" alt="Hannah Lily Baron" class="fellow-image">
                </div>
                <p class="fellow-name">Hannah Lily Baron</p>
            </div>

            <div class="fellow-card">
                <div class="fellow-image-container" style="border-color: #8F3B3B;">
                    <img src="/api/placeholder/200/200" alt="Santiago Carrillo Sánchez" class="fellow-image">
                </div>
                <p class="fellow-name">Santiago Carrillo Sánchez</p>
            </div>

            <div class="fellow-card">
                <div class="fellow-image-container" style="border-color: #8F3B3B;">
                    <img src="/api/placeholder/200/200" alt="Maria Teresa Carrozza" class="fellow-image">
                </div>
                <p class="fellow-name">Maria Teresa Carrozza</p>
            </div>

            <div class="fellow-card">
                <div class="fellow-image-container" style="border-color: #8F3B3B;">
                    <img src="/api/placeholder/200/200" alt="Maxwell Mwalukanga" class="fellow-image">
                </div>
                <p class="fellow-name">Maxwell Mwalukanga</p>
            </div>        </div>
    </div>

    <!-- Modal for Fellow Information -->
    <div id="fellowModal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <div class="modal-header">
                <div class="modal-image-container">
                    <img id="modalFellowImage" src="" alt="Fellow Image">
                </div>
                <h2 id="modalFellowName"></h2>
            </div>
            <div class="modal-body">
                <div class="fellow-details">
                    <p><strong>University:</strong> <span id="modalUniversity">Ashesi University</span></p>
                    <p><strong>Year:</strong> <span id="modalYear">2023</span></p>
                    <p><strong>SDG Focus:</strong> <span id="modalSDG">Quality Education</span></p>
                    <p><strong>Region:</strong> <span id="modalRegion">West Africa</span></p>
                    <p><strong>Role:</strong> <span id="modalRole">Fellow</span></p>
                </div>
                <div>
                    <div class="fellow-bio">
                        <h3>About</h3>
                        <p id="modalBio">This student is passionate about making a positive impact through their leadership and dedication to sustainable development goals.</p>
                    </div>
                    <div class="fellow-project">
                        <h3>Project</h3>
                        <p id="modalProject">Working on innovative solutions to address challenges related to their focused sustainable development goal.</p>
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
        </div>        <div class="copyright">
            <p>Copyright © Ashesi University</p>
        </div>
    </footer>

    <script>
        // Sample fellows data - in a real application, you would fetch this from a database
        const fellowsData = {
            "Kehinde Adebiyi": {
                image: "/api/placeholder/200/200",
                university: "Ashesi University",
                year: "2023",
                sdg: "Quality Education",
                region: "West Africa",
                role: "Campus Director",
                bio: "Kehinde is passionate about educational equity and access to quality education in underserved communities.",
                project: "Developing a mentorship program for high school students in rural Ghana."
            },
            "Idongesit Ubon": {
                image: "/api/placeholder/200/200",
                university: "Ashesi University",
                year: "2023",
                sdg: "Gender Equality",
                region: "West Africa",
                role: "Fellow",
                bio: "Idongesit is working on initiatives to promote gender equality in STEM fields.",
                project: "Creating workshops to encourage young girls to pursue careers in technology."
            },
            "Sarosh Nagar": {
                image: "/api/placeholder/200/200",
                university: "Ashesi University",
                year: "2023",
                sdg: "Climate Action",
                region: "South Asia",
                role: "Fellow",
                bio: "Sarosh is dedicated to addressing climate change through community engagement.",
                project: "Organizing tree-planting campaigns and educational workshops on sustainability."
            },
            "Khulood Ali Hassan": {
                image: "/api/placeholder/200/200",
                university: "Ashesi University",
                year: "2023",
                sdg: "Clean Water and Sanitation",
                region: "Middle East",
                role: "Fellow",
                bio: "Khulood focuses on water conservation and access to clean water in resource-limited areas.",
                project: "Designing affordable water filtration systems for rural communities."
            },
            "Hannah Lily Baron": {
                image: "/api/placeholder/200/200",
                university: "Ashesi University",
                year: "2023",
                sdg: "Zero Hunger",
                region: "North America",
                role: "Fellow",
                bio: "Hannah is committed to addressing food insecurity in urban areas.",
                project: "Creating community gardens and food distribution networks in underserved neighborhoods."
            },
            "Santiago Carrillo Sánchez": {
                image: "/api/placeholder/200/200",
                university: "Ashesi University",
                year: "2023",
                sdg: "Sustainable Cities",
                region: "South America",
                role: "Campus Director",
                bio: "Santiago is passionate about urban planning and sustainable development.",
                project: "Developing models for eco-friendly transportation systems in growing cities."
            },
            "Maria Teresa Carrozza": {
                image: "/api/placeholder/200/200",
                university: "Ashesi University",
                year: "2023",
                sdg: "Good Health and Well-being",
                region: "Europe",
                role: "Fellow",
                bio: "Maria is dedicated to improving mental health awareness and support systems.",
                project: "Creating peer counseling programs for college students."
            },
            "Maxwell Mwalukanga": {
                image: "/api/placeholder/200/200",
                university: "Ashesi University",
                year: "2023",
                sdg: "Affordable and Clean Energy",
                region: "East Africa",
                role: "Fellow",
                bio: "Maxwell is working on renewable energy solutions for off-grid communities.",
                project: "Designing and implementing solar power systems for rural schools and clinics."
            }
        };

        // Get modal elements
        const modal = document.getElementById("fellowModal");
        const modalClose = document.querySelector(".close-modal");
        const fellowCards = document.querySelectorAll(".fellow-card");
        
        // Modal data elements
        const modalFellowName = document.getElementById("modalFellowName");
        const modalFellowImage = document.getElementById("modalFellowImage");
        const modalUniversity = document.getElementById("modalUniversity");
        const modalYear = document.getElementById("modalYear");
        const modalSDG = document.getElementById("modalSDG");
        const modalRegion = document.getElementById("modalRegion");
        const modalRole = document.getElementById("modalRole");
        const modalBio = document.getElementById("modalBio");
        const modalProject = document.getElementById("modalProject");
        
        // Add click event to each fellow card
        fellowCards.forEach(card => {
            card.addEventListener("click", function() {
                const name = this.querySelector(".fellow-name").textContent;
                const fellow = fellowsData[name];
                  if (fellow) {
                    // Populate modal with fellow data
                    modalFellowName.textContent = name;
                    
                    // Use a default placeholder if image is not available or invalid
                    if (fellow.image && fellow.image !== "/api/placeholder/200/200") {
                        modalFellowImage.src = fellow.image;
                    } else {
                        // Using a default placeholder image
                        modalFellowImage.src = "images/default_profile.png";
                    }
                    
                    modalFellowImage.alt = name;
                    modalUniversity.textContent = fellow.university;
                    modalYear.textContent = fellow.year;
                    modalSDG.textContent = fellow.sdg;
                    modalRegion.textContent = fellow.region;
                    modalRole.textContent = fellow.role;
                    modalBio.textContent = fellow.bio;
                    modalProject.textContent = fellow.project;
                    
                    // Display modal
                    modal.style.display = "block";
                }
            });
        });
        
        // Close modal when clicking the X button
        modalClose.addEventListener("click", function() {
            modal.style.display = "none";
        });
        
        // Close modal when clicking outside the modal content
        window.addEventListener("click", function(event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        });
    </script>
</body>
</html>