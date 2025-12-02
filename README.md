# ECHO-TECH

*Empowering a sustainable future through innovative technology.*

![Last commit](https://img.shields.io/badge/last_commit-yesterday-blue) ![PHP](https://img.shields.io/badge/PHP-91.9%25-brightgreen) ![Languages](https://img.shields.io/badge/languages-4-orange)

## Built with the tools and technologies

![JSON](https://img.shields.io/badge/JSON-orange) ![Composer](https://img.shields.io/badge/Composer-brown) ![Python](https://img.shields.io/badge/Python-blue) ![PHP](https://img.shields.io/badge/PHP-purple) ![CSS](https://img.shields.io/badge/CSS-purple)

---

## Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Getting Started](#getting-started)
  - [Prerequisites](#prerequisites)
  - [Installation](#installation)
  - [Database Setup](#database-setup)
  - [Usage](#usage)
  - [Testing](#testing)

---

## Overview

Echo-Tech is a comprehensive developer tool designed to streamline user engagement and enhance the presentation of sustainable technology solutions.

### Why Echo-Tech?

This project empowers developers to create engaging, user-friendly platforms that effectively showcase sustainable technology offerings. The core features include:

- **🟢 User Engagement:** Facilitates inquiries through a user-friendly contact page, enhancing customer interaction.
- **🔒 Data Validation:** Ensures correctness and sanitization of user input, reducing errors and improving data handling.
- **🛡️ Privacy Compliance:** Fosters transparency with a clear privacy policy, building user trust and ensuring legal compliance.
- **📢 Service Showcase:** Presents a structured overview of services, encouraging potential clients to engage further.
- **📂 Dynamic Project Portfolio:** Highlights impactful sustainable technology projects, showcasing achievements and fostering exploration.
- **📱 Responsive Design:** Ensures a cohesive user experience across devices, enhancing accessibility and engagement.

---

## Features

### 🏗️ Modern MVC Architecture

- **Clean separation of concerns** with Controllers, Models, and Views
- **PSR-4 autoloading** for efficient class loading
- **Centralized routing** system with clean URLs
- **Template engine** for reusable layouts and components

### 🔐 User Authentication System

- **User Registration:** Secure account creation with password hashing
- **Login/Logout:** Session-based authentication with CSRF protection
- **Personal Dashboard:** Track inquiries and manage account settings
- **Protected Routes:** Middleware-based authentication for secure pages

### 📧 Newsletter Subscription

- **Email Signup:** Subscribe to receive updates and sustainability tips
- **AJAX Form Submission:** Seamless subscription without page reload
- **Footer Integration:** Newsletter form available on every page

### 📝 Blog & News Section

- **Article Listing:** Browse sustainability tips, company news, and industry insights
- **Category Filtering:** Filter posts by category (Sustainability, Technology, News, etc.)
- **Individual Posts:** Full article view with social sharing buttons
- **Pagination:** Navigate through multiple pages of content

### 💬 Live Chat Widget

- **Floating Chat Button:** Always accessible from any page
- **Quick Responses:** Pre-defined options for common inquiries
- **Automated Replies:** Intelligent responses based on user queries
- **Mobile Responsive:** Works seamlessly on all devices

### 🔍 Site-Wide Search

- **Universal Search:** Find services, projects, blog posts, and pages
- **Real-time Results:** AJAX-powered search with instant feedback
- **Popular Suggestions:** Quick links to common search terms

### 🛡️ Security & Best Practices

- **Environment-based configuration** with `.env` file
- **PDO with prepared statements** to prevent SQL injection
- **Password hashing** using PHP's native password functions
- **Input validation and sanitization**
- **Public directory** as web root for enhanced security

### 🎨 Responsive Design

- **Mobile-first approach** for optimal user experience
- **Cross-browser compatibility**
- **Accessible navigation** and forms

---

## Project Structure

```plaintext
echo-tech/
├── public/              # Web root (document root for web server)
│   ├── index.php       # Front controller (entry point)
│   ├── .htaccess       # Apache rewrite rules
│   └── assets/         # Public assets
│       ├── css/        # Stylesheets
│       ├── js/         # JavaScript files
│       └── images/     # Images and media
├── src/                # Application source code
│   ├── Controllers/    # Request handlers
│   ├── Models/         # Database models
│   ├── Services/       # Business logic
│   ├── Middleware/     # Authentication, validation, etc.
│   ├── Database.php    # Database connection manager
│   ├── Router.php      # Routing system
│   └── View.php        # Template rendering
├── templates/          # View templates
│   ├── layouts/        # Layout templates (main.php)
│   └── pages/          # Page templates
├── config/             # Configuration files
│   ├── app.php        # Application settings
│   ├── database.php   # Database configuration
│   └── routes.php     # Route definitions
├── database/           # Database files
│   └── schema.sql     # Database schema
├── vendor/             # Composer dependencies
├── .env               # Environment variables (not in git)
├── .env.example       # Example environment file
├── composer.json      # PHP dependencies
└── README.md          # This file
```

## Getting Started

### Prerequisites

- **PHP:** 7.4 or higher
- **Composer:** Dependency manager for PHP
- **Database:** MySQL 5.7+ or MariaDB 10.2+
- **Web Server:** Apache/Nginx (or use PHP built-in server for development)

### Installation

1. **Clone the repository:**

   ```bash
   git clone https://github.com/oyugijr/echo-tech
   cd echo-tech
   ```

2. **Install dependencies:**

   ```bash
   composer install
   ```

3. **Configure environment:**

   ```bash
   cp .env.example .env
   ```

   Edit `.env` and update your settings (database credentials, app URL, etc.):

   ```env
   APP_NAME="EcoTech Solutions"
   APP_ENV=development
   APP_DEBUG=true
   APP_URL=http://localhost:8000

   DB_HOST=localhost
   DB_NAME=ecotech
   DB_USER=root
   DB_PASS=your_password
   ```

4. **Set up the database:**

   ```bash
   # Create database
   mysql -u root -p -e "CREATE DATABASE ecotech;"
   
   # Import schema
   mysql -u root -p ecotech < database/schema.sql
   ```

5. **Update autoloader:**

   ```bash
   composer dump-autoload
   ```

### Running the Application

#### Development Server (Recommended for Development)

Use the built-in PHP server:

```bash
composer serve
```

Or manually:

```bash
php -S localhost:8000 -t public
```

Then visit: `http://localhost:8000`

#### Production Server

**Apache:** Point document root to `public/` directory and ensure `.htaccess` is enabled.

**Nginx:** Configure your server block:

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/echo-tech/public;
    
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### Testing

Run the test suite:

```bash
composer test
```

Or using PHPUnit directly:

```bash
vendor/bin/phpunit
```

---

<<<<<<< HEAD
## Architecture Overview

### MVC Pattern

This project follows the **Model-View-Controller (MVC)** architectural pattern:

- **Models** (`src/Models/`): Handle data and business logic
- **Views** (`templates/`): Render HTML output
- **Controllers** (`src/Controllers/`): Process requests and coordinate between models and views

### Request Flow

1. All requests hit `public/index.php` (front controller)
2. Router parses the URL and matches it to a route in `config/routes.php`
3. Middleware runs (e.g., authentication check)
4. Appropriate controller method is called
5. Controller fetches data from models (if needed)
6. Controller passes data to view for rendering
7. Response is sent back to the client

### Key Components

- **Router** (`src/Router.php`): Handles URL routing and dispatching
- **Database** (`src/Database.php`): Manages database connections
- **View** (`src/View.php`): Renders templates with data
- **Controllers** (`src/Controllers/`): Handle HTTP requests
- **Middleware** (`src/Middleware/`): Process requests before controllers

---

## Configuration

### Environment Variables

All sensitive configuration is stored in `.env` file:

```env
APP_NAME="EcoTech Solutions"
APP_ENV=development
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_HOST=localhost
DB_NAME=ecotech
DB_USER=root
DB_PASS=your_password
```

### Configuration Files

- **`config/app.php`**: Application settings (name, environment, paths)
- **`config/database.php`**: Database connection settings
- **`config/routes.php`**: URL routing configuration

### Adding New Routes

Edit `config/routes.php`:

```php
'/your-page' => [
    'controller' => 'YourController',
    'method' => 'yourMethod',
    'middleware' => 'auth' // optional
],
```

---

## Development

### Creating a New Page

1. **Add route** in `config/routes.php`
2. **Create controller** in `src/Controllers/`
3. **Create template** in `templates/pages/`

Example:

```php
// config/routes.php
'/team' => ['controller' => 'PageController', 'method' => 'team'],

// src/Controllers/PageController.php
public function team(): void
{
    View::renderWithLayout('pages/team', [
        'title' => 'Our Team - EcoTech Solutions'
    ]);
}

// templates/pages/team.php
<section class="team">
    <h1>Our Team</h1>
    <p>Meet our talented team members...</p>
</section>
```

### Working with Database

```php
use App\Database;

$pdo = Database::getConnection();

// Fetch data
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

// Insert data
$stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
$stmt->execute([$name, $email]);
```

### Adding Middleware

Create new middleware in `src/Middleware/`:

```php
namespace App\Middleware;

class AdminMiddleware
{
    public static function handle(): bool
    {
        session_start();
        return isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
    }
}
```

---

## Deployment

### Production Checklist

- [ ] Set `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false` in `.env`
- [ ] Configure web server to point to `public/` directory
- [ ] Set proper file permissions
- [ ] Enable HTTPS
- [ ] Configure database backups
- [ ] Set up error logging
- [ ] Run `composer install --no-dev --optimize-autoloader`

### Security Considerations

1. **Never commit `.env` file** to version control
2. **Keep `vendor/` and `src/` outside web root** (only `public/` is accessible)
3. **Use prepared statements** for all database queries
4. **Validate and sanitize** all user input
5. **Use HTTPS** in production
6. **Keep dependencies updated**: `composer update`

---

## Troubleshooting

### Common Issues

**404 on all pages except homepage**

- Check that `.htaccess` is in `public/` directory (Apache)
- Verify `mod_rewrite` is enabled
- For Nginx, ensure `try_files` directive is configured

**Class not found errors**

- Run `composer dump-autoload`
- Check namespace matches directory structure

**Database connection failed**

- Verify `.env` has correct credentials
- Ensure database exists: `CREATE DATABASE ecotech;`
- Check PDO extension is enabled: `php -m | grep pdo`

**Assets (CSS/JS) not loading**

- Ensure paths start with `/assets/` not `assets/`
- Verify files are in `public/assets/` directory
- Check browser console for 404 errors

---

## Contributing

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/amazing-feature`
3. Commit your changes: `git commit -m 'Add amazing feature'`
4. Push to the branch: `git push origin feature/amazing-feature`
5. Open a Pull Request

---

## License

This project is licensed under the MIT License.

---

## Contact

**EcoTech Solutions**

- Website: [ecotechsolutions.com](http://localhost:8000)
- Email: <info@ecotechsolutions.com>
- GitHub: [@oyugijr](https://github.com/oyugijr)

---

## Acknowledgments

- Built with PHP and modern web development practices
- Follows PSR-4 autoloading standard
- Uses Composer for dependency management
- Inspired by Laravel and other modern PHP frameworks
=======
## Architecture

The project follows a **modular architecture** pattern with clear separation of concerns:

### Directory Structure

```
echo-tech/
├── src/                          # Source code (modular architecture)
│   ├── Core/                     # Core framework components
│   │   ├── Application.php       # Central application bootstrap
│   │   ├── Config/               # Configuration management
│   │   │   └── Config.php
│   │   ├── Database/             # Database connection handling
│   │   │   └── Connection.php
│   │   ├── Http/                 # HTTP layer (Request/Response/Controller)
│   │   │   ├── Controller.php
│   │   │   ├── Request.php
│   │   │   └── Response.php
│   │   └── View/                 # View helpers
│   │       └── ViewHelper.php
│   └── Modules/                  # Feature modules
│       ├── Auth/                 # Authentication module
│       │   ├── AuthService.php
│       │   └── Controllers/
│       │       └── AuthController.php
│       ├── Blog/                 # Blog module
│       │   ├── BlogService.php
│       │   └── Controllers/
│       │       └── BlogController.php
│       ├── Newsletter/           # Newsletter subscription module
│       │   ├── NewsletterService.php
│       │   └── Controllers/
│       │       └── NewsletterController.php
│       ├── Pages/                # Static pages module
│       │   ├── PagesService.php
│       │   └── Controllers/
│       │       └── PagesController.php
│       └── Search/               # Search module
│           ├── SearchService.php
│           └── Controllers/
│               └── SearchController.php
├── api/                          # API endpoints
├── css/                          # Stylesheets
├── database/                     # Database schema
├── images/                       # Static images
├── includes/                     # Legacy includes (backward compatible)
├── bootstrap.php                 # Application bootstrap file
├── composer.json                 # Composer dependencies
└── *.php                         # Public entry points
```

### Key Concepts

- **Application**: Central singleton that initializes configuration and database
- **Modules**: Self-contained feature units with their own services and controllers
- **Services**: Business logic layer, independent of HTTP concerns
- **Controllers**: Handle HTTP requests and delegate to services
- **Backward Compatibility**: Legacy includes still work through the bootstrap file
>>>>>>> e1852c72b5d2c03d0e5055bb2e6dcb2c5b35629c
