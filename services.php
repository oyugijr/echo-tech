<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/services.css">
    <link rel="stylesheet" href="css/styles.css">
    <title>Document</title>
</head>
<body>
<?php include 'includes/header.php'; ?>
<?php include 'includes/db_connect.php'; ?>

<main class="services-main">
    <section class="services-intro">
        <h1>Our Services</h1>
        <p class="lead">We offer a comprehensive range of sustainable technology solutions designed to help businesses reduce their environmental impact while improving efficiency and driving growth.</p>
    </section>

    <div class="services-grid">
        <?php 
        $stmt = $pdo->query("SELECT * FROM services");
        while ($service = $stmt->fetch()):
        ?>
        <div class="service-card">
            <div class="service-header">
                <h2><?= htmlspecialchars($service['title']) ?></h2>
                <p><?= htmlspecialchars($service['description']) ?></p>
            </div>
            <ul class="service-features">
                <?php $features = json_decode($service['features']); ?>
                <?php foreach ($features as $feature): ?>
                <li><?= htmlspecialchars($feature) ?></li>
                <?php endforeach; ?>
            </ul>
            <a href="#" class="learn-more">Learn More →</a>
        </div>
        <?php endwhile; ?>
    </div>

    <section class="process-section">
        <h2>Our Process</h2>
        <div class="process-steps">
            <div class="step">
                <div class="step-number">1</div>
                <h3>Assessment</h3>
                <p>We begin by thoroughly assessing your current operations, identifying opportunities for sustainability improvements.</p>
            </div>
            <div class="step">
                <div class="step-number">2</div>
                <h3>Design</h3>
                <p>Our team designs custom solutions tailored to your specific needs, goals, and constraints.</p>
            </div>
            <div class="step">
                <div class="step-number">3</div>
                <h3>Implementation</h3>
                <p>We handle the complete implementation of your sustainable technology solutions, ensuring minimal disruption.</p>
            </div>
            <div class="step">
                <div class="step-number">4</div>
                <h3>Monitoring & Optimization</h3>
                <p>We provide ongoing monitoring and optimization to ensure your systems continue to perform at their best.</p>
            </div>
            <!-- Repeat for steps -->
        </div>
    </section>

    <section class="cta-section">
        <h2>Ready to Transform Your Business?</h2>
        <p>Contact us today to discuss how our sustainable technology solutions can help your business thrive while reducing its environmental impact.</p>
        <a href="contact.php" class="cta-button">Schedule a Consultation</a>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
</body>
</html>
