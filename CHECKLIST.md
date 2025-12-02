# Post-Restructuring Checklist

## ✅ Immediate Actions Required

### 1. Environment Setup

- [ ] Copy `.env.example` to `.env`

  ```bash
  cp .env.example .env
  ```

- [ ] Edit `.env` with your database credentials
- [ ] Set `APP_ENV` to `development` for testing

### 2. Dependencies

- [ ] Run `composer install`
- [ ] Run `composer dump-autoload`

### 3. Database

- [ ] Verify database exists: `ecotech`
- [ ] Ensure schema is imported
- [ ] Test database connection

### 4. Assets Migration

- [ ] Move CSS files from `css/` to `public/assets/css/`

  ```bash
  # If not already done:
  # cp -r css/* public/assets/css/
  ```

- [ ] Move images from `images/` to `public/assets/images/`

  ```bash
  # If not already done:
  # cp -r images/* public/assets/images/
  ```

- [ ] Move any JavaScript files to `public/assets/js/`

### 5. Update Asset References

- [ ] Search for `href="css/` and replace with `href="/assets/css/`
- [ ] Search for `src="images/` and replace with `src="/assets/images/`
- [ ] Search for `src="js/` and replace with `src="/assets/js/`

### 6. Test Application

- [ ] Start server: `composer serve`
- [ ] Visit `http://localhost:8000`
- [ ] Test all routes:
  - [ ] Home page (`/` or `/home`)
  - [ ] About page (`/about`)
  - [ ] Services page (`/services`)
  - [ ] Projects page (`/projects`)
  - [ ] Contact page (`/contact`)
  - [ ] Blog page (`/blog`)
  - [ ] Login page (`/login`)
  - [ ] Register page (`/register`)
  - [ ] Search functionality (`/search`)
- [ ] Check browser console for errors
- [ ] Verify all assets (CSS, JS, images) load correctly

---

## 📋 Content Migration Tasks

### Pages to Migrate (If Customized)

Check if these old files have custom content that needs to be migrated:

- [ ] `home.php` → Already templated in `templates/pages/home.php`
- [ ] `about.php` → Create `templates/pages/about.php` if needed
- [ ] `services.php` → Create `templates/pages/services.php` if needed
- [ ] `projects.php` → Create `templates/pages/projects.php` if needed
- [ ] `contact.php` → Create `templates/pages/contact.php` if needed
- [ ] `blog.php` → Create `templates/pages/blog.php` if needed
- [ ] `blog-post.php` → Create `templates/pages/blog-post.php` if needed
- [ ] `dashboard.php` → Create `templates/pages/dashboard.php` if needed
- [ ] `login.php` → Create `templates/pages/login.php` if needed
- [ ] `register.php` → Create `templates/pages/register.php` if needed
- [ ] `search.php` → Create `templates/pages/search.php` if needed
- [ ] `privacy-policy.php` → Create `templates/pages/privacy-policy.php` if needed
- [ ] `terms.php` → Create `templates/pages/terms.php` if needed

### Includes to Review

- [ ] `includes/header.php` → Content merged into `templates/layouts/main.php`
- [ ] `includes/footer.php` → Content merged into `templates/layouts/main.php`
- [ ] `includes/chat-widget.php` → Content merged into `templates/layouts/main.php`
- [ ] `includes/auth.php` → Review for migration to `src/Middleware/`
- [ ] `includes/config.php` → Replaced by `config/` files
- [ ] `includes/db_connect.php` → Replaced by `src/Database.php`

---

## 🧹 Cleanup (After Migration is Complete)

### Optional: Remove Old Files

Once you've confirmed everything works with the new structure:

- [ ] Delete old page files from root (keep them backed up first!)
  - `home.php`, `about.php`, `services.php`, etc.
- [ ] Delete old `includes/` folder
- [ ] Delete old `css/` folder (after moving to `public/assets/css/`)
- [ ] Delete old `images/` folder (after moving to `public/assets/images/`)
- [ ] Delete old `api/` folder (replaced by controllers)
- [ ] Delete `process_form.py` if not needed

### Keep These Files

- [ ] `database/schema.sql` - Still needed
- [ ] `vendor/` - Composer dependencies
- [ ] `.env` - Your environment config
- [ ] `.gitignore` - Updated version control rules
- [ ] All new structure files

---

## 🔒 Security Checklist

- [ ] `.env` file is in `.gitignore`
- [ ] `.env` is not committed to git
- [ ] Only `public/` directory is accessible via web server
- [ ] Database credentials are in `.env`, not hardcoded
- [ ] `APP_DEBUG=false` in production
- [ ] All user inputs are validated and sanitized
- [ ] SQL queries use prepared statements
- [ ] Passwords are hashed with `password_hash()`

---

## 🚀 Production Deployment Checklist

When ready to deploy:

- [ ] Set `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false` in `.env`
- [ ] Run `composer install --no-dev --optimize-autoloader`
- [ ] Configure web server to point to `public/` directory
- [ ] Set proper file permissions (644 for files, 755 for directories)
- [ ] Enable HTTPS
- [ ] Set up database backups
- [ ] Configure error logging
- [ ] Test all functionality in production environment

---

## 📝 Documentation Review

- [ ] Read `README.md` - Complete project documentation
- [ ] Read `MIGRATION.md` - Detailed migration guide
- [ ] Read `QUICKSTART.md` - Quick reference
- [ ] Read `RESTRUCTURING_SUMMARY.md` - Overview of changes

---

## 🆘 Troubleshooting

If you encounter issues:

1. [ ] Check error logs
2. [ ] Enable debug mode: `APP_DEBUG=true` in `.env`
3. [ ] Run `composer dump-autoload`
4. [ ] Clear browser cache
5. [ ] Check file permissions
6. [ ] Verify database connection in `.env`
7. [ ] Ensure web server is pointing to `public/` directory

---

## ✨ Optional Enhancements

Consider adding:

- [ ] Unit tests with PHPUnit
- [ ] Integration tests
- [ ] Code style checker (PHP_CodeSniffer)
- [ ] Static analysis (PHPStan)
- [ ] Frontend build tools (webpack/Vite)
- [ ] CSS preprocessor (Sass/Less)
- [ ] JavaScript framework (Vue/React) for interactivity
- [ ] Email functionality for contact forms
- [ ] Admin panel for content management
- [ ] API documentation
- [ ] Rate limiting for API endpoints
- [ ] Caching layer (Redis/Memcached)
- [ ] Logging system (Monolog)

---

**Keep this checklist handy as you complete the migration!** ✅
