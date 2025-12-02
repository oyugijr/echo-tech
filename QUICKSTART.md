# Quick Start Guide

## 🚀 Get Started in 5 Minutes

### Step 1: Set Up Environment

```bash
# Copy environment file
cp .env.example .env

# Edit .env with your settings
# At minimum, update these:
DB_NAME=ecotech
DB_USER=root
DB_PASS=your_password
```

### Step 2: Install Dependencies

```bash
composer install
composer dump-autoload
```

### Step 3: Set Up Database

```bash
# Create database
mysql -u root -p -e "CREATE DATABASE ecotech;"

# Import schema
mysql -u root -p ecotech < database/schema.sql
```

### Step 4: Start Server

```bash
composer serve
```

### Step 5: Open Browser

Visit: **<http://localhost:8000>**

---

## 📍 Available Routes

| URL | Description |
|-----|-------------|
| `/` or `/home` | Homepage |
| `/about` | About page |
| `/services` | Services listing |
| `/projects` | Projects portfolio |
| `/contact` | Contact form |
| `/blog` | Blog posts |
| `/login` | User login |
| `/register` | User registration |
| `/dashboard` | User dashboard (requires auth) |
| `/privacy-policy` | Privacy policy |
| `/terms` | Terms & conditions |

---

## 🎨 Asset Paths

Always use **absolute paths** from web root:

```html
<!-- CSS -->
<link rel="stylesheet" href="/assets/css/styles.css">

<!-- JavaScript -->
<script src="/assets/js/main.js"></script>

<!-- Images -->
<img src="/assets/images/logo.png" alt="Logo">
```

---

## 🔧 Common Tasks

### Add a New Page

1. Edit `config/routes.php`:

```php
'/my-page' => ['controller' => 'PageController', 'method' => 'myPage'],
```

2. Add method to `src/Controllers/PageController.php`:

```php
public function myPage(): void
{
    View::renderWithLayout('pages/my-page', [
        'title' => 'My Page - EcoTech Solutions'
    ]);
}
```

3. Create `templates/pages/my-page.php`:

```php
<h1>My Page</h1>
<p>Content goes here...</p>
```

### Query Database

```php
use App\Database;

$pdo = Database::getConnection();
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();
```

### Protect a Route with Authentication

In `config/routes.php`:

```php
'/admin' => [
    'controller' => 'AdminController',
    'method' => 'index',
    'middleware' => 'auth'  // Add this line
],
```

---

## 🐛 Troubleshooting

### 404 on all pages

```bash
# Make sure you're serving from public/ directory
php -S localhost:8000 -t public
```

### Class not found

```bash
composer dump-autoload
```

### Database connection failed

Check your `.env` file has correct credentials

### Assets not loading

Ensure paths start with `/assets/` (with leading slash)

---

## 📖 More Information

- **Full Documentation:** See `README.md`
- **Migration Guide:** See `MIGRATION.md`
- **Complete Summary:** See `RESTRUCTURING_SUMMARY.md`

---

**Happy Coding! 🎉**
