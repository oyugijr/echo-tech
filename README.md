# ECHO-TECH

*Empowering a sustainable future through innovative technology.*

![Last commit](https://img.shields.io/badge/last_commit-yesterday-blue) ![PHP](https://img.shields.io/badge/PHP-91.9%25-brightgreen) ![Languages](https://img.shields.io/badge/languages-4-orange)

### Built with the tools and technologies:

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

### User Authentication System
- **User Registration:** Secure account creation with password hashing
- **Login/Logout:** Session-based authentication with CSRF protection
- **Personal Dashboard:** Track inquiries and manage account settings
- **Protected Routes:** Dashboard and user-specific features require authentication

### Newsletter Subscription
- **Email Signup:** Subscribe to receive updates and sustainability tips
- **AJAX Form Submission:** Seamless subscription without page reload
- **Footer Integration:** Newsletter form available on every page

### Blog & News Section
- **Article Listing:** Browse sustainability tips, company news, and industry insights
- **Category Filtering:** Filter posts by category (Sustainability, Technology, News, etc.)
- **Individual Posts:** Full article view with social sharing buttons
- **Pagination:** Navigate through multiple pages of content

### Live Chat Widget
- **Floating Chat Button:** Always accessible from any page
- **Quick Responses:** Pre-defined options for common inquiries
- **Automated Replies:** Intelligent responses based on user queries
- **Mobile Responsive:** Works seamlessly on all devices

### Site-Wide Search
- **Universal Search:** Find services, projects, blog posts, and pages
- **Real-time Results:** AJAX-powered search with instant feedback
- **Popular Suggestions:** Quick links to common search terms

---

## Getting Started

### Prerequisites

This project requires the following dependencies:

- **Programming Language:** PHP 7.4+
- **Package Manager:** Composer
- **Database:** MySQL 5.7+ or MariaDB

### Installation

Build Echo-Tech from the source and install dependencies:

1. **Clone the repository:**

   ```sh
   git clone https://github.com/ogwgjr/echo-tech
   ```

2. **Navigate to the project directory:**

   ```sh
   cd echo-tech
   ```

3. **Install the dependencies:**
   Using [Composer](https://getcomposer.org/):

   ```sh
   composer install
   ```

4. **Configure environment variables:**
   Copy the example environment file and update it with your settings:

   ```sh
   cp .env.example .env
   ```

   Then edit `.env` with your database credentials and email settings.

### Database Setup

1. **Create the database:**
   ```sh
   mysql -u root -p -e "CREATE DATABASE ecotech;"
   ```

2. **Run the schema:**
   ```sh
   mysql -u root -p ecotech < database/schema.sql
   ```

### Usage

Run the project with PHP's built-in server:

```sh
php -S localhost:8000
```

Then open `http://localhost:8000/home.php` in your browser.

### Testing

Echo-Tech uses **PHPUnit** for testing. Run the test suite with:

Using Composer:

```sh
vendor/bin/phpunit
```
