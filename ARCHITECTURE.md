# Architecture Decision Record

## Project: EcoTech Solutions Restructuring

### Date: December 2, 2025

---

## 1. Context and Problem Statement

The EcoTech Solutions project had a flat file structure with all PHP files in the root directory. This structure made the codebase difficult to maintain, scale, and secure. We needed a better organizational structure following modern PHP best practices.

**Previous Issues:**

- All files in root directory (poor organization)
- No separation of concerns
- Source code accessible from web root (security risk)
- No routing system (URLs with `.php` extensions)
- No autoloading (manual includes everywhere)
- Difficult to test and maintain

---

## 2. Decision

We restructured the application using the **Model-View-Controller (MVC)** architectural pattern with the following key decisions:

### 2.1 Directory Structure

**Decision:** Separate public assets from application code

**Structure:**

```
public/          # Web root (only publicly accessible)
src/             # Application code (PHP classes)
templates/       # View files
config/          # Configuration files
database/        # Database files
vendor/          # Dependencies
```

**Rationale:**

- Security: Source code not accessible via web
- Clarity: Clear separation of concerns
- Standards: Follows PSR recommendations
- Scalability: Easy to add new components

### 2.2 Routing System

**Decision:** Front controller pattern with centralized routing

**Implementation:**

- Single entry point: `public/index.php`
- Routes defined in: `config/routes.php`
- Clean URLs without `.php` extensions

**Rationale:**

- SEO-friendly URLs
- Centralized route management
- Easy to add middleware
- Better security control

### 2.3 Autoloading

**Decision:** PSR-4 autoloading via Composer

**Namespace:** `App\`
**Mapping:** `src/` directory

**Rationale:**

- No manual `require` statements
- Follows PHP-FIG standards
- Better IDE support
- Easier testing

### 2.4 Configuration Management

**Decision:** Environment-based configuration with `.env` file

**Configuration Files:**

- `config/app.php` - Application settings
- `config/database.php` - Database settings
- `config/routes.php` - Route definitions
- `.env` - Environment-specific values

**Rationale:**

- Different configs for dev/staging/production
- Sensitive data not in version control
- Easy to deploy to different environments
- Industry standard approach

### 2.5 Database Layer

**Decision:** Singleton pattern for database connections

**Class:** `App\Database`
**Method:** `Database::getConnection()`

**Rationale:**

- Single connection instance
- Lazy loading
- PDO with prepared statements
- Easy to test and mock

### 2.6 Template System

**Decision:** Simple PHP-based template engine

**Class:** `App\View`
**Layouts:** `templates/layouts/main.php`
**Pages:** `templates/pages/`

**Rationale:**

- No external dependencies
- Familiar PHP syntax
- Layout inheritance
- Fast and simple

### 2.7 Controller Organization

**Decision:** Dedicated controller classes with namespaces

**Namespaces:**

- `App\Controllers\` - Main controllers
- `App\Controllers\Api\` - API endpoints

**Rationale:**

- Clear responsibility separation
- Easy to locate code
- Testable units
- RESTful API support

---

## 3. Consequences

### Positive Consequences

✅ **Security:**

- Source code outside web root
- Environment-based configuration
- Prepared statements everywhere

✅ **Maintainability:**

- Clear file organization
- Easy to find and modify code
- Separation of concerns

✅ **Scalability:**

- Easy to add new features
- Modular architecture
- Can grow with project needs

✅ **Developer Experience:**

- Modern PHP practices
- PSR standards compliance
- Better IDE support
- Clear documentation

✅ **Performance:**

- Autoloading (no unnecessary includes)
- Single database connection
- Efficient routing

### Negative Consequences (Trade-offs)

⚠️ **Learning Curve:**

- Developers familiar with flat structure need to adapt
- Understanding MVC pattern required

⚠️ **Initial Setup:**

- More files and directories to manage
- Configuration required before running

⚠️ **Migration Effort:**

- Existing code needs to be migrated
- Asset paths need updating
- URL structure changes

**Mitigation:**

- Comprehensive documentation provided
- Migration guide created
- Checklists for step-by-step migration
- Old files kept for reference

---

## 4. Design Patterns Used

### 4.1 MVC (Model-View-Controller)

- **Models:** `src/Models/` - Data and business logic
- **Views:** `templates/` - Presentation layer
- **Controllers:** `src/Controllers/` - Request handlers

### 4.2 Front Controller

- Single entry point (`public/index.php`)
- All requests routed through one file

### 4.3 Singleton

- Database connection (`App\Database`)
- Ensures single instance

### 4.4 Dependency Injection (Prepared for)

- Structure allows for DI container
- Controllers can accept dependencies

### 4.5 Factory Pattern (Implicit)

- Controllers instantiated by router
- Easy to add service locator later

---

## 5. Technology Stack

### Core

- **PHP:** 7.4+ (supports 8.x)
- **Database:** MySQL/MariaDB
- **Web Server:** Apache/Nginx (or built-in for dev)

### Dependencies

- **Composer:** Package management
- **phpdotenv:** Environment configuration
- **PHPUnit:** Testing (dev dependency)

### Frontend

- **HTML5:** Semantic markup
- **CSS3:** Styling (in `public/assets/css/`)
- **JavaScript:** Interactivity (in `public/assets/js/`)

---

## 6. Security Measures

### Application Security

- ✅ Source code outside web root
- ✅ Environment variables for sensitive data
- ✅ PDO prepared statements (SQL injection prevention)
- ✅ Password hashing with `password_hash()`
- ✅ Input validation and sanitization
- ✅ CSRF protection ready
- ✅ Session management configured

### Server Security

- ✅ `.htaccess` for Apache rewrites
- ✅ `.env` not in version control
- ✅ Error display off in production
- ✅ File permissions (644/755)

---

## 7. Future Considerations

### Potential Improvements

1. **Dependency Injection Container**
   - Could add a DI container for better testability
   - Consider PHP-DI or Symfony DI

2. **ORM (Object-Relational Mapping)**
   - Could integrate Eloquent or Doctrine
   - Would simplify database operations

3. **Template Engine**
   - Could use Twig or Blade
   - More features but adds complexity

4. **Middleware System**
   - Currently basic in router
   - Could create dedicated middleware stack

5. **Validation Layer**
   - Could add Respect\Validation
   - Centralized validation rules

6. **Caching**
   - Add Redis/Memcached support
   - File-based caching for views

7. **API**
   - Could expand to full RESTful API
   - Add API versioning
   - OpenAPI/Swagger documentation

8. **Testing**
   - Add comprehensive test suite
   - Integration tests
   - Code coverage reports

---

## 8. Standards Compliance

### PSR Standards Followed

- ✅ **PSR-1:** Basic Coding Standard
- ✅ **PSR-4:** Autoloading Standard
- ✅ **PSR-12:** Extended Coding Style (recommended)

### Best Practices

- ✅ SOLID principles
- ✅ DRY (Don't Repeat Yourself)
- ✅ KISS (Keep It Simple, Stupid)
- ✅ Separation of Concerns
- ✅ Single Responsibility Principle

---

## 9. Documentation

### Created Documents

1. **README.md** - Complete project guide
2. **MIGRATION.md** - Detailed migration instructions
3. **QUICKSTART.md** - Quick reference guide
4. **RESTRUCTURING_SUMMARY.md** - Overview of changes
5. **CHECKLIST.md** - Step-by-step migration checklist
6. **This file** - Architecture decisions

### Code Documentation

- Inline comments where needed
- Docblocks for classes and methods (to be added)
- Type hints for better IDE support

---

## 10. Conclusion

This restructuring transforms the EcoTech Solutions project from a flat, procedural structure into a modern, maintainable MVC application following PHP best practices. While it requires migration effort, the long-term benefits in security, maintainability, and scalability far outweigh the initial cost.

The architecture is designed to be:

- **Simple enough** for small teams to understand
- **Robust enough** to handle growth
- **Flexible enough** to accommodate future changes
- **Secure enough** for production deployment

**Status:** ✅ Architecture implemented and documented

**Next Steps:** Follow CHECKLIST.md to complete migration
