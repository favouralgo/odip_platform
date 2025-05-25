# ODIP International Engagement Student Experience Platform

## Overview

The ODIP (Office of Diversity, Inclusion and Partnership) International Engagement Student Experience Platform is a comprehensive web application designed to showcase and manage student international engagement experiences at Ashesi University. The platform serves as a centralized hub for documenting, approving, and displaying student experiences from study abroad programs, research presentations, conferences, internships, and other international engagements.

## Features

### 🌟 Core Features

- **Student Experience Management**: Complete CRUD operations for student records and experiences
- **Admin Dashboard**: Comprehensive admin panel for managing applications and content
- **Student Gallery**: Interactive frontend display with search and filter capabilities
- **Modal System**: Detailed student information displayed in responsive modals
- **Application Workflow**: Multi-step form for student submissions with approval system
- **Content Management**: Announcements system for platform communication

### 🔧 Technical Features

- **Responsive Design**: Mobile-first responsive layout
- **AJAX Search**: Real-time search and filtering without page reloads
- **File Upload**: Profile picture management with image processing
- **Security**: Input validation, prepared statements, and secure authentication
- **Database Optimization**: Indexed tables for improved performance

## Technology Stack

### Backend
- **PHP 7.4+**: Server-side scripting
- **MySQL 5.7+**: Database management
- **Apache/Nginx**: Web server

### Frontend
- **HTML5**: Semantic markup
- **CSS3**: Modern styling with Flexbox and Grid
- **JavaScript (ES6+)**: Interactive functionality
- **Font Awesome**: Icons and visual elements

### Libraries & Frameworks
- **Chart.js**: Data visualization for admin dashboard
- **No external PHP frameworks**: Pure PHP implementation for maximum control

## Installation

### Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache or Nginx web server
- Web browser with JavaScript enabled

### Step 1: Clone the Repository

```bash
git clone https://github.com/your-username/odip_platform.git
cd odip_platform
```

### Step 2: Database Setup

1. Create a new MySQL database:
```sql
CREATE DATABASE odip_international_engagement;
```

2. Import the database schema:
```bash
mysql -u your_username -p odip_international_engagement < db/odip_database.sql
```

3. Update database configuration in `config/connection.php`:
```php
define("DB_SERVER", "localhost");
define("DB_USERNAME", "your_username");
define("DB_PASSWORD", "your_password");
define("DB_NAME", "odip_international_engagement");
```

### Step 3: Directory Permissions

Create and set permissions for upload directories:
```bash
mkdir uploads
chmod 755 uploads
mkdir images
chmod 755 images
```

### Step 4: Web Server Configuration

#### Apache
Ensure `.htaccess` files are enabled and mod_rewrite is active.

#### Nginx (for deployment)
Configure your server block to handle PHP files:
```nginx
location ~ \.php$ {
    fastcgi_pass 127.0.0.1:9000;
    fastcgi_index index.php;
    include fastcgi_params;
}
```

### Step 5: Initial Admin Setup

1. Navigate to `auth/signup.php`
2. Create your first admin account
3. Login at `auth/login.php`

## Project Structure

```
odip_platform/
├── actions/                    # Form processing scripts
│   ├── login_action.php
│   └── signup_action.php
├── admin/                      # Admin panel files
│   ├── admindashboard.php
│   ├── applications.php
│   ├── announcements.php
│   ├── students.php
│   ├── settings.php
│   ├── view_student.php
│   ├── edit_announcement.php
│   └── delete_student.php
├── ajax/                       # AJAX endpoints
│   ├── search_students.php
│   ├── get_student_details.php
│   └── get_year_options.php
├── assets/                     # Static assets
│   ├── css/
│   │   ├── index.css
│   │   ├── dashboard.css
│   │   ├── login.css
│   │   ├── modal.css
│   │   ├── settings.css
│   │   ├── students.css
│   │   └── student_form.css
│   └── js/
│       └── script.js
├── auth/                       # Authentication pages
│   ├── login.php
│   ├── signup.php
│   └── logout.php
├── config/                     # Configuration files
│   ├── connection.php
│   └── config.php
├── db/                         # Database files
│   └── odip_international_engagement.sql
├── images/                     # Static images
│   ├── Ashesi image2.webp
│   ├── Ashesi image3.jpg
│   └── default_profile.png
├── students/                   # Student-related pages
│   ├── student.php
│   └── student_form.php
├── uploads/                    # User uploaded files
├── index.php                   # Main landing page
└── README.md
```

## Database Schema

### Tables Overview

#### `students`
Stores student personal information and academic details.

#### `engagements`
Records international engagement activities linked to students.

#### `experience_responses`
Contains detailed experience responses and feedback from students.

#### `users`
Admin user accounts with authentication credentials.

#### `student_pictures`
Manages profile picture file information.

#### `announcements`
Platform announcements and news management.

### Key Relationships
- Students → Engagements (One-to-Many)
- Students → Experience Responses (One-to-Many)
- Engagements → Experience Responses (One-to-One)
- Students → Student Pictures (One-to-One)

## Usage Guide

### For Students

1. **Submitting an Application**:
   - Navigate to `students/student_form.php`
   - Complete the multi-step form with personal information, engagement details, and experience responses
   - Upload a profile picture (optional)
   - Submit for admin review

2. **Viewing Student Profiles**:
   - Visit the main page to see approved student profiles
   - Use search and filter options to find specific students
   - Click on student cards to view detailed information in modals

### For Administrators

1. **Dashboard Access**:
   - Signup at `auth/signup.php`
   - Login at `auth/login.php`
   - Access the admin dashboard at `admin/admindashboard.php`

2. **Managing Applications**:
   - Review pending applications in `admin/applications.php`
   - Approve or reject student submissions
   - View detailed student information

3. **Student Management**:
   - View all students in `admin/students.php`
   - Edit, view, or delete student records
   - Filter and search through student database

4. **Content Management**:
   - Create and manage announcements in `admin/announcements.php`
   - Configure platform settings in `admin/settings.php`

## API Endpoints

### AJAX Endpoints

#### Search Students
```
GET /ajax/search_students.php
Parameters: keyword, region, year, university
Response: JSON array of student objects
```

#### Get Student Details
```
GET /ajax/get_student_details.php
Parameters: id (student_id)
Response: JSON object with full student information
```

#### Get Year Options
```
GET /ajax/get_year_options.php
Response: JSON array of available year groups
```

## Security Features

### Input Validation
- All user inputs are sanitized using PHP filter functions
- Prepared statements prevent SQL injection attacks
- File upload validation ensures only safe image formats

### Authentication
- Password hashing using PHP's `password_hash()` function
- Session management for admin access control
- Role-based access restrictions

### Data Protection
- CSRF protection for form submissions
- Secure file upload handling
- Database connection security

## Customization

### Adding New Fields

1. **Database**: Add columns to relevant tables
2. **Forms**: Update form HTML and validation
3. **Display**: Modify display templates and modal content

### Styling Customization

Modify CSS variables in the respective stylesheets:
```css
:root {
    --primary-color: #8d4a42;
    --secondary-color: #4a6885;
    --light-bg: #f5f6fa;
    /* Add your custom colors */
}
```

### Adding New Engagement Types

Update the enum values in the database:
```sql
ALTER TABLE engagements MODIFY engagement_type ENUM(
    'Study abroad', 
    'Research presentation', 
    'Conference', 
    'Internship', 
    'Other',
    'Your New Type'
);
```

## Troubleshooting

### Common Issues

1. **Database Connection Errors**
   - Verify database credentials in `config/connection.php`
   - Ensure MySQL service is running
   - Check database user permissions

2. **File Upload Issues**
   - Verify `uploads/` directory exists and has write permissions
   - Check PHP `upload_max_filesize` and `post_max_size` settings
   - Ensure web server has permission to write to upload directory

3. **JavaScript Errors**
   - Check browser console for error messages
   - Verify AJAX endpoints are accessible
   - Ensure jQuery/JavaScript libraries are loaded correctly

4. **Styling Issues**
   - Clear browser cache
   - Check CSS file paths are correct
   - Verify CSS files are being loaded

### Debug Mode

Enable PHP error reporting for development:
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

## Contributing

### Development Setup

1. Fork the repository
2. Create a feature branch: `git checkout -b feature-name`
3. Make your changes
4. Test thoroughly
5. Submit a pull request

### Code Standards

- Use meaningful variable and function names
- Comment complex logic
- Maintain consistent indentation (4 spaces)
- Validate all user inputs

### Testing

- Test all forms with various input combinations
- Verify responsive design on multiple devices
- Check database operations for edge cases
- Test file upload functionality

## Performance Optimization

### Database Optimization
- Indexes are created on frequently queried columns
- Use of prepared statements for repeated queries
- Connection pooling for high-traffic scenarios

### Frontend Optimization
- CSS and JavaScript minification recommended for production
- Image optimization for faster loading
- Browser caching headers configuration

### Caching Strategies
- Database query result caching for frequently accessed data
- Static asset caching through web server configuration

## Deployment (to-do)

### Production Checklist

- [ ] Update database credentials
- [ ] Set appropriate file permissions
- [ ] Configure SSL certificate
- [ ] Enable error logging (disable display_errors)
- [ ] Set up regular database backups
- [ ] Configure web server security headers
- [ ] Test all functionality in production environment

### Environment Configuration

Create environment-specific configuration files:
```php
// config/production.php
define("DB_SERVER", "production-server");
define("DB_USERNAME", "prod_user");
define("DB_PASSWORD", "secure_password");
define("DEBUG_MODE", false);
```

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.

## Support

For technical support or questions:

- **Email**: support@ashesi.edu.gh
- **Documentation**: [Project Wiki](https://github.com/favouralgo/odip_platform/wiki)
- **Issues**: [GitHub Issues](https://github.com/favouralgo/odip_platform/issues)

## Acknowledgments

- **Ashesi University** - For supporting international engagement initiatives
- **ODIP Team** - For requirements and testing
- **Contributors** - Leadership IV service learning team

## Changelog

### Version 1.0.0 (Current)
- Initial release with core functionality
- Student registration and management system
- Admin dashboard with analytics
- Search and filter capabilities
- File upload system
- Responsive design implementation

### Planned Features (v1.1.0)
- Initial deployment of MVP and interface redesign
- Email notifications for application status
- Advanced analytics and reporting
- Bulk import/export functionality
- Multi-language support
- Enhanced security features

---

**Last Updated**: May 2025
**Version**: 1.0.0
**Maintainer**: ODIP Platform Team