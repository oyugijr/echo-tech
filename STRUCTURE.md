# EcoTech Solutions - Visual Structure Guide

## 📊 Request Flow Diagram

```
┌─────────────────────────────────────────────────────────────────┐
│                         User Browser                             │
│                  http://localhost:8000/services                  │
└────────────────────────────────┬────────────────────────────────┘
                                 │
                                 ▼
┌─────────────────────────────────────────────────────────────────┐
│                      Web Server (Apache/Nginx)                   │
│                   Document Root: public/                         │
└────────────────────────────────┬────────────────────────────────┘
                                 │
                                 ▼
┌─────────────────────────────────────────────────────────────────┐
│                      public/index.php                            │
│                     (Front Controller)                           │
│  1. Load autoloader                                              │
│  2. Load environment (.env)                                      │
│  3. Initialize router                                            │
└────────────────────────────────┬────────────────────────────────┘
                                 │
                                 ▼
┌─────────────────────────────────────────────────────────────────┐
│                      src/Router.php                              │
│  1. Parse URL: /services                                         │
│  2. Match route from config/routes.php                           │
│  3. Check middleware (if required)                               │
│  4. Load controller: ServiceController                           │
└────────────────────────────────┬────────────────────────────────┘
                                 │
                                 ▼
┌─────────────────────────────────────────────────────────────────┐
│              src/Controllers/ServiceController.php               │
│  1. Get database connection                                      │
│  2. Fetch services data                                          │
│  3. Pass data to view                                            │
└────────────────────────────────┬────────────────────────────────┘
                                 │
                                 ▼
┌─────────────────────────────────────────────────────────────────┐
│                      src/View.php                                │
│  1. Load layout: templates/layouts/main.php                      │
│  2. Include page: templates/pages/services.php                   │
│  3. Render with data                                             │
└────────────────────────────────┬────────────────────────────────┘
                                 │
                                 ▼
┌─────────────────────────────────────────────────────────────────┐
│                      HTML Response                               │
│                   (Sent to browser)                              │
└─────────────────────────────────────────────────────────────────┘
```

---

## 📁 Directory Tree Structure

```
echo-tech/
│
├── 📂 public/                    ← WEB ROOT (Point server here)
│   ├── 📄 index.php              ← Single entry point
│   ├── 📄 .htaccess              ← Apache rewrite rules
│   │
│   └── 📂 assets/                ← Public static files
│       ├── 📂 css/
│       │   ├── styles.css
│       │   ├── home.css
│       │   └── ...
│       │
│       ├── 📂 js/
│       │   └── main.js
│       │
│       └── 📂 images/
│           ├── logo.png
│           └── ...
│
├── 📂 src/                       ← Application Source Code
│   ├── 📄 Database.php           ← DB connection manager
│   ├── 📄 Router.php             ← Routing system
│   ├── 📄 View.php               ← Template renderer
│   │
│   ├── 📂 Controllers/           ← Request handlers
│   │   ├── 📄 HomeController.php
│   │   ├── 📄 PageController.php
│   │   ├── 📄 BlogController.php
│   │   ├── 📄 AuthController.php
│   │   ├── 📄 ServiceController.php
│   │   ├── 📄 ProjectController.php
│   │   ├── 📄 ContactController.php
│   │   ├── 📄 DashboardController.php
│   │   ├── 📄 SearchController.php
│   │   │
│   │   └── 📂 Api/               ← API endpoints
│   │       ├── 📄 SearchController.php
│   │       └── 📄 SubscribeController.php
│   │
│   ├── 📂 Models/                ← Data models (to be created)
│   │   ├── 📄 User.php
│   │   ├── 📄 BlogPost.php
│   │   └── ...
│   │
│   ├── 📂 Services/              ← Business logic
│   │   └── (to be created)
│   │
│   └── 📂 Middleware/            ← Request filters
│       └── (to be created)
│
├── 📂 templates/                 ← View Templates
│   ├── 📂 layouts/
│   │   └── 📄 main.php           ← Main layout (header/footer)
│   │
│   └── 📂 pages/                 ← Page templates
│       ├── 📄 home.php
│       ├── 📄 about.php
│       ├── 📄 services.php
│       ├── 📄 blog.php
│       └── ...
│
├── 📂 config/                    ← Configuration Files
│   ├── 📄 app.php                ← App settings
│   ├── 📄 database.php           ← DB config
│   └── 📄 routes.php             ← Route definitions
│
├── 📂 database/                  ← Database Files
│   └── 📄 schema.sql             ← Database schema
│
├── 📂 vendor/                    ← Composer Dependencies
│   └── (managed by Composer)
│
├── 📄 .env                       ← Environment variables (create this)
├── 📄 .env.example               ← Environment template
├── 📄 .gitignore                 ← Git ignore rules
├── 📄 composer.json              ← Composer config
├── 📄 composer.lock              ← Locked dependencies
│
└── 📚 Documentation
    ├── 📄 README.md              ← Main documentation
    ├── 📄 MIGRATION.md           ← Migration guide
    ├── 📄 QUICKSTART.md          ← Quick start
    ├── 📄 RESTRUCTURING_SUMMARY.md
    ├── 📄 CHECKLIST.md           ← Migration checklist
    ├── 📄 ARCHITECTURE.md        ← Architecture decisions
    └── 📄 STRUCTURE.md           ← This file
```

---

## 🔄 Component Interaction Diagram

```
┌──────────────┐
│   Browser    │
└──────┬───────┘
       │
       │ HTTP Request
       ▼
┌──────────────────────────────────────┐
│         Front Controller              │
│         (public/index.php)            │
│  ┌────────────────────────────────┐  │
│  │ 1. Load Composer Autoloader    │  │
│  │ 2. Load .env file              │  │
│  │ 3. Initialize Router           │  │
│  └────────────────────────────────┘  │
└──────────────┬───────────────────────┘
               │
               ▼
       ┌───────────────┐
       │    Router     │◄─────────┐
       │               │          │
       │ Match route   │          │
       │ Check auth    │          │
       └───────┬───────┘          │
               │              ┌───┴────┐
               │              │ Routes │
               │              │ Config │
               │              └────────┘
               ▼
       ┌───────────────┐
       │  Controller   │
       │               │
       │ index()       │
       │ show()        │
       │ create()      │
       └───┬───────┬───┘
           │       │
           │       │
    ┌──────▼─┐ ┌──▼──────┐
    │ Model  │ │  View   │
    │        │ │         │
    │ Query  │ │ Render  │
    │ Data   │ │ HTML    │
    └────┬───┘ └──┬──────┘
         │        │
         │        │
    ┌────▼────┐   │
    │Database │   │
    │         │   │
    │ MySQL   │   │
    └─────────┘   │
                  │
         ┌────────▼────────┐
         │   Templates     │
         │ ┌─────────────┐ │
         │ │   Layout    │ │
         │ │  (Header/   │ │
         │ │   Footer)   │ │
         │ └──────┬──────┘ │
         │        │        │
         │ ┌──────▼──────┐ │
         │ │  Page View  │ │
         │ │  (Content)  │ │
         │ └─────────────┘ │
         └─────────────────┘
                  │
                  ▼
            HTML Response
                  │
                  ▼
            ┌──────────┐
            │ Browser  │
            └──────────┘
```

---

## 🗺️ URL Routing Map

```
URL Pattern              Controller              Method          Auth Required
─────────────────────────────────────────────────────────────────────────────
/                       HomeController          index()         No
/home                   HomeController          index()         No
/about                  PageController          about()         No
/services               ServiceController       index()         No
/projects               ProjectController       index()         No
/contact                ContactController       index()         No
/contact/submit         ContactController       submit()        No
/blog                   BlogController          index()         No
/blog/post?id=1         BlogController          show()          No
/search?q=term          SearchController        index()         No
/login                  AuthController          login()         No
/register               AuthController          register()      No
/logout                 AuthController          logout()        No
/dashboard              DashboardController     index()         Yes ✓
/privacy-policy         PageController          privacy()       No
/terms                  PageController          terms()         No

API Endpoints
─────────────────────────────────────────────────────────────────────────────
/api/search             Api\SearchController    search()        No
/api/subscribe          Api\SubscribeController subscribe()     No
```

---

## 🔐 Authentication Flow

```
┌─────────────┐
│ User visits │
│  /dashboard │
└──────┬──────┘
       │
       ▼
┌─────────────────┐
│ Router checks   │
│ if middleware   │
│ = 'auth'        │
└──────┬──────────┘
       │
       ▼
    Is user
  authenticated?
       │
   ┌───┴───┐
   │       │
  Yes      No
   │       │
   │       └──► Redirect to /login
   │
   ▼
Load Dashboard
Controller
   │
   ▼
Render Dashboard
Template
```

---

## 📦 Namespace Organization

```
App\
├── Controllers\
│   ├── HomeController
│   ├── PageController
│   ├── BlogController
│   ├── AuthController
│   ├── ServiceController
│   ├── ProjectController
│   ├── ContactController
│   ├── DashboardController
│   ├── SearchController
│   │
│   └── Api\
│       ├── SearchController
│       └── SubscribeController
│
├── Models\
│   ├── User
│   ├── BlogPost
│   ├── Service
│   └── Project
│
├── Services\
│   ├── EmailService
│   └── ValidationService
│
├── Middleware\
│   ├── AuthMiddleware
│   └── AdminMiddleware
│
├── Database
├── Router
└── View
```

---

## 🔧 Configuration Flow

```
┌─────────────┐
│   .env      │  ← Environment-specific values
│             │     (DB credentials, API keys)
└──────┬──────┘
       │
       ▼
┌─────────────────┐
│ config/app.php  │  ← Application settings
│                 │     Uses $_ENV from .env
└─────────────────┘

┌─────────────────┐
│config/database │  ← Database configuration
│     .php       │     Uses $_ENV from .env
└─────────────────┘

┌─────────────────┐
│config/routes.php│  ← Route definitions
│                 │     URL → Controller mapping
└─────────────────┘
```

---

## 💾 Database Access Pattern

```
Controller
    │
    ▼
┌─────────────────────┐
│ App\Database::      │
│  getConnection()    │
└──────────┬──────────┘
           │
           ▼
    ┌──────────────┐
    │ PDO Instance │  ← Singleton
    │ (Reused)     │
    └──────┬───────┘
           │
           ▼
    ┌──────────────┐
    │ MySQL Server │
    └──────────────┘
```

---

## 🎨 Template Rendering

```
Controller calls:
View::renderWithLayout('pages/home', $data)
           │
           ▼
    ┌──────────────────┐
    │ Start output     │
    │ buffering        │
    └─────────┬────────┘
              │
              ▼
    ┌──────────────────┐
    │ Include page:    │
    │ pages/home.php   │
    └─────────┬────────┘
              │
              ▼
    ┌──────────────────┐
    │ Capture $content │
    └─────────┬────────┘
              │
              ▼
    ┌──────────────────┐
    │ Include layout:  │
    │ layouts/main.php │
    │ (with $content)  │
    └─────────┬────────┘
              │
              ▼
    ┌──────────────────┐
    │ Output final     │
    │ HTML             │
    └──────────────────┘
```

---

## 📊 File Relationships

```
public/index.php
    │
    ├─► vendor/autoload.php
    ├─► .env (via Dotenv)
    └─► src/Router.php
            │
            ├─► config/routes.php
            └─► src/Controllers/*.php
                    │
                    ├─► src/Database.php
                    │       │
                    │       └─► config/database.php
                    │
                    ├─► src/Models/*.php
                    │
                    └─► src/View.php
                            │
                            ├─► templates/layouts/*.php
                            └─► templates/pages/*.php
```

---

This visual guide should help you understand how all the pieces fit together!
