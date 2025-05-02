-- ODIP International Engagement Student Experience Platform
-- Complete SQL file for database creation

-- Drop tables if they exist
DROP TABLE IF EXISTS student_pictures;
DROP TABLE IF EXISTS experience_responses;
DROP TABLE IF EXISTS engagements;
DROP TABLE IF EXISTS students;
DROP TABLE IF EXISTS users;

-- Create the Students table
CREATE TABLE students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    gender ENUM('Male', 'Female') NOT NULL,
    nationality VARCHAR(100) NOT NULL,
    major ENUM('Computer Science', 'Management Information System', 'Computer Engineering', 
                'Business Administration', 'Electrical Engineering', 'Mechanical Engineering', 
                'Mechatronics Engineering', 'Economics', 'Law and Public Policy') NOT NULL,
    year_group YEAR NOT NULL,
    email_address VARCHAR(100) UNIQUE NOT NULL,
    linkedin_url VARCHAR(255),
    has_picture BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create the Engagements table
CREATE TABLE engagements (
    engagement_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    engagement_type ENUM('Study abroad', 'Research presentation', 'Conference', 'Internship', 'Other') NOT NULL,
    destination_country VARCHAR(100) NOT NULL,
    institution_name VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create the Experience Responses table
CREATE TABLE experience_responses (
    response_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    engagement_id INT NOT NULL,
    inspiration TEXT,
    wished_to_know TEXT,
    funny_story TEXT,
    things_done TEXT,
    fears TEXT,
    culture_shock TEXT,
    advice TEXT,
    career_choice_change TEXT,
    interesting_class TEXT,
    teaching_learning_style TEXT,
    personal_change TEXT,
    would_do_differently TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE,
    FOREIGN KEY (engagement_id) REFERENCES engagements(engagement_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create the Users table (for admin access only)
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin') NOT NULL DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create the Student Pictures table
CREATE TABLE student_pictures (
    picture_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL UNIQUE,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create indexes for performance optimization
-- Students table indexes
CREATE INDEX idx_students_name ON students(name);
CREATE INDEX idx_students_major ON students(major);
CREATE INDEX idx_students_year_group ON students(year_group);
CREATE INDEX idx_students_nationality ON students(nationality);

-- Engagements table indexes
CREATE INDEX idx_engagements_student_id ON engagements(student_id);
CREATE INDEX idx_engagements_type ON engagements(engagement_type);
CREATE INDEX idx_engagements_destination ON engagements(destination_country);

-- Experience responses table indexes
CREATE INDEX idx_responses_student_id ON experience_responses(student_id);
CREATE INDEX idx_responses_engagement_id ON experience_responses(engagement_id);

-- Insert an initial admin user (password is 'admin123' - change this immediately in production!)
INSERT INTO users (username, email, password, role) VALUES 
('admin', 'admin@example.com', '$2y$10$8WvtZJdBRCuO9h4j.CA.JelGgpUzJA9u.K0R8BCbiuX.DBxv/SWri', 'admin');

-- This schema is designed for the ODIP International Engagement Student Experience Platform.
-- It contains tables for storing student information, their international engagement experiences,
-- and their responses to questions about their experiences.
