<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/home.css">
    <title>Document</title>
</head>
<body>
<?php include 'includes/header.php'; ?>
<?php include 'includes/db_connect.php'; ?>

<main class="home-page">
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Sustainable Technology for a Better Future</h1>
            <p class="subheading">Innovative solutions that protect our planet while driving business growth</p>
            <div class="hero-cta">
                <a href="services.php" class="cta-button">Our Services</a>
                <a href="contact.php" class="cta-button secondary">Contact Us</a>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="why-choose">
        <div class="section-container">
            <h2>Why Choose EcoTech Solutions?</h2>
            <p class="section-intro">We combine cutting-edge technology with sustainable practices to deliver solutions that benefit both businesses and the environment.</p>
            
            <div class="benefits-grid">
                <div class="benefit-card">
                    <div class="benefit-icon">🌿</div>
                    <h3>Eco-Friendly</h3>
                    <p>All our solutions are designed with environmental sustainability as a core principle.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">⚡</div>
                    <h3>Energy Efficient</h3>
                    <p>Reduce your carbon footprint and operational costs with our energy-efficient technologies.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">💧</div>
                    <h3>Resource Saving</h3>
                    <p>Our systems optimize resource usage, minimizing waste and maximizing efficiency.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">🔄</div>
                    <h3>Circular Economy</h3>
                    <p>We implement circular economy principles in all our product lifecycles.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Projects -->
    <section class="featured-projects">
        <div class="section-container">
            <div class="section-header">
                <h2>Featured Projects</h2>
                <a href="projects.php" class="view-all">View All →</a>
            </div>
            
            <div class="projects-grid">
                <?php 
                $stmt = $pdo->query("SELECT * FROM projects WHERE featured = TRUE ORDER BY year DESC LIMIT 3");
                while ($project = $stmt->fetch()):
                ?>
                <div class="project-card">
                    <img src="images/projects/<?= htmlspecialchars($project['image']) ?>" alt="<?= htmlspecialchars($project['title']) ?>">
                    <div class="project-info">
                        <h3><?= htmlspecialchars($project['title']) ?></h3>
                        <p><?= htmlspecialchars($project['description']) ?></p>
                        <a href="projects.php#<?= $project['id'] ?>" class="project-link">View Project →</a>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- Final CTA -->
    <section class="final-cta">
        <div class="cta-content">
            <h2>Ready to Make a Difference?</h2>
            <p>Join us in creating a sustainable future with technology that makes a positive impact.</p>
            <a href="contact.php" class="cta-button">Get in Touch Today</a>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
</body>
</html>