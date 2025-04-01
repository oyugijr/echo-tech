<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/projects.css">
    <link rel="stylesheet" href="css/styles.css">
    <title>Document</title>
</head>
<body>
<?php include 'includes/header.php'; ?>
<?php include 'includes/db_connect.php'; ?>

<main class="projects-main">
    <section class="projects-intro">
        <h1>Our Projects</h1>
        <p>Explore our portfolio of sustainable technology projects that have made a real impact for our clients and the environment.</p>
    </section>

    <div class="projects-grid">
    <?php 
    $stmt = $pdo->query("SELECT * FROM projects ORDER BY year DESC");
    while ($project = $stmt->fetch()):
    ?>
    <div class="project-card">
        <div class="project-image" style="background-image: url('images/projects/<?= htmlspecialchars($project['image']) ?>')"></div>
        <div class="project-header">
            <div class="project-client"><?= htmlspecialchars($project['client']) ?> <?= htmlspecialchars($project['year']) ?></div>
            <h2 class="project-title"><?= htmlspecialchars($project['title']) ?></h2>
        </div>
        <div class="project-details">
            <p class="project-description"><?= htmlspecialchars($project['description']) ?></p>
            <div class="project-location"><strong>Locations:</strong> <?= htmlspecialchars($project['location']) ?></div>
            <a href="#" class="project-link">
                View Details
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
    <?php endwhile; ?>
</div>

<section class="case-studies">
    <h2>Featured Case Studies</h2>
    <div class="case-study-grid">
        <!-- Case Study 1 -->
        <div class="case-study-card">
            <div class="case-study-image" style="background-image: url('images/case-studies/carbon-footprint.jpg')"></div>
            <div class="case-study-content">
                <h3>Reducing Carbon Footprint for Global Tech Company</h3>
                <p class="case-study-description">How we helped a Fortune 500 tech company reduce their carbon emissions by 30% while cutting energy costs.</p>
                <div class="stats-row">
                    <div class="stat-item">
                        <div class="stat-value">30%</div>
                        <div class="stat-label">Carbon Reduction</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">$2.4M</div>
                        <div class="stat-label">Energy Savings</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">8</div>
                        <div class="stat-label">Months</div>
                    </div>
                </div>
                <a href="#" class="btn btn-primary">
                    Read Full Case Study
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
        
        <!-- Case Study 2 -->
        <div class="case-study-card">
            <div class="case-study-image" style="background-image: url('images/case-studies/water-conservation-system.png')"></div>
            <div class="case-study-content">
                <h3>Water Conservation for Hospitality Chain</h3>
                <p class="case-study-description">A comprehensive water management solution that dramatically reduced consumption across 12 hotel properties.</p>
                <div class="stats-row">
                    <div class="stat-item">
                        <div class="stat-value">42M</div>
                        <div class="stat-label">Gallons Saved</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">37%</div>
                        <div class="stat-label">Reduction</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">18</div>
                        <div class="stat-label">Months</div>
                    </div>
                </div>
                <a href="#" class="btn btn-primary">
                    Read Full Case Study
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
        <!-- case study 3 -->
        <div class="case-study-card">
            <div class="case-study-image" style="background-image: url('images/case-studies/water-conservation-system.png')"></div>
            <div class="case-study-content">
                <h3>Optimizing Supply Chain for Retail Giant</h3>
                <p class="case-study-description">We implemented a smart logistics system that improved delivery efficiency and reduced costs by 25%.</p>
                <div class="stats-row">
                    <div class="stat-item">
                        <div class="stat-value">25%</div>
                        <div class="stat-label">Cost Reduction</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">50%</div>
                        <div class="stat-label">Faster Deliveries</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">12</div>
                        <div class="stat-label">Months</div>
                    </div>
                </div>
                <a href="#" class="btn btn-primary">
                    Read Full Case Study
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
        <!-- Case study 4 -->
        <div class="case-study-card">
            <div class="case-study-image" style="background-image: url('images/case-studies/water-conservation-system.png')"></div>
            <div class="case-study-content">
                <h3>AI-Powered Fraud Detection for Financial Institution</h3>
                <p class="case-study-description">Our AI-driven fraud detection system reduced false positives and increased fraud detection rates by 40%.</p>
                <div class="stats-row">
                    <div class="stat-item">
                        <div class="stat-value">40%</div>
                        <div class="stat-label">Detection Increase</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">60%</div>
                        <div class="stat-label">Positive Reduction</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">6</div>
                        <div class="stat-label">Months</div>
                    </div>
                </div>
                <a href="#" class="btn btn-primary">
                    Read Full Case Study
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

    <!-- <?php include 'includes/footer.php'; ?> -->
</main>

<?php include 'includes/footer.php'; ?>
</body>
</html>
