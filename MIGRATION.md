# Migration Guide

## Overview
This guide will help you migrate from the old flat structure to the new organized MVC structure.

## What Changed?

### Directory Structure
```
OLD:                          NEW:
├── *.php (in root)          ├── public/
├── css/                     │   ├── index.php (entry point)
├── images/                  │   └── assets/
├── includes/                │       ├── css/
├── api/                     │       ├── js/
└── vendor/                  │       └── images/
                             ├── src/
                             │   ├── Controllers/
                             │   ├── Models/
                             │   ├── Services/
                             │   └── Middleware/
                             ├── templates/
                             │   ├── layouts/
                             │   └── pages/
                             ├── config/
                             ├── database/
                             └── vendor/
```

### URL Structure
All requests now go through `/public/index.php`:

**OLD URLs:**
- `http://localhost:8000/home.php`
- `http://localhost:8000/about.php`
- `http://localhost:8000/services.php`

**NEW URLs:**
- `http://localhost:8000/home`
- `http://localhost:8000/about`
- `http://localhost:8000/services`

### Asset Paths
**OLD:** `<link rel="stylesheet" href="css/styles.css">`
**NEW:** `<link rel="stylesheet" href="/assets/css/styles.css">`

## Migration Steps

### 1. Run Composer Update
```bash
composer dump-autoload
```

### 2. Copy Environment File
```bash
cp .env.example .env
```

Edit `.env` with your database credentials.

### 3. Update Web Server Configuration

#### Using PHP Built-in Server
```bash
composer serve
# or
php -S localhost:8000 -t public
```

#### Using Apache
Point your document root to the `public/` directory:
```apache
DocumentRoot "/path/to/echo-tech/public"
```

#### Using Nginx
```nginx
server {
    listen 80;
    server_name localhost;
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

### 4. Migrate Old Page Files (if needed)

If you have customized the old PHP files, you'll need to:

1. **Extract the HTML content** from old `.php` files
2. **Create template files** in `templates/pages/`
3. **Create/update controllers** in `src/Controllers/`

Example for a custom page:

**OLD: `custom-page.php`**
```php
<?php include 'includes/header.php'; ?>
<h1>Custom Page</h1>
<p>Content here</p>
<?php include 'includes/footer.php'; ?>
```

**NEW:**

1. Add route in `config/routes.php`:
```php
'/custom-page' => ['controller' => 'PageController', 'method' => 'custom'],
```

2. Add method in `src/Controllers/PageController.php`:
```php
public function custom(): void
{
    View::renderWithLayout('pages/custom-page', [
        'title' => 'Custom Page - EcoTech Solutions'
    ]);
}
```

3. Create `templates/pages/custom-page.php`:
```php
<h1>Custom Page</h1>
<p>Content here</p>
```

### 5. Move Assets

The build has already created the structure. Now move your assets:

```bash
# Move CSS files (if using old locations)
# They should now be in public/assets/css/

# Move images (if using old locations)
# They should now be in public/assets/images/

# Move JavaScript files
# They should now be in public/assets/js/
```

### 6. Update Database References

All database connections now use the `Database` class:

**OLD:**
```php
require_once 'includes/db_connect.php';
// Uses global $pdo
```

**NEW:**
```php
use App\Database;

$pdo = Database::getConnection();
```

### 7. Test Your Migration

1. Start the server: `composer serve`
2. Visit: `http://localhost:8000/`
3. Test all major pages and features
4. Check browser console for asset loading errors

## Benefits of New Structure

✅ **Better Organization**: Clear separation of concerns (MVC pattern)
✅ **Security**: Web root is `public/`, source code not accessible
✅ **Routing**: Clean URLs without `.php` extensions
✅ **Autoloading**: PSR-4 autoloading for classes
✅ **Maintainability**: Easier to find and update code
✅ **Scalability**: Ready for growth and new features
✅ **Modern Standards**: Follows PHP best practices

## Troubleshooting

### Assets not loading
- Ensure paths start with `/assets/` not `assets/`
- Check that files are in `public/assets/` directory

### 404 errors
- Verify route exists in `config/routes.php`
- Check controller and method names match exactly
- Ensure `.htaccess` is in `public/` directory (Apache)

### Database connection errors
- Check `.env` file has correct database credentials
- Ensure database exists and schema is imported
- Verify PDO extension is enabled

### Class not found errors
- Run `composer dump-autoload`
- Check namespace matches directory structure
- Verify PSR-4 autoloading in `composer.json`

## Need Help?

If you encounter issues during migration:
1. Check error logs
2. Enable debug mode in `.env`: `APP_DEBUG=true`
3. Refer to the README.md for setup instructions
