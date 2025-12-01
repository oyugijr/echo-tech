<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/search.css">
    <title>Search - EcoTech Solutions</title>
</head>
<body>
<?php 
require_once 'includes/auth.php';
include 'includes/header.php';

$query = htmlspecialchars($_GET['q'] ?? '');
?>

<main class="search-page">
    <section class="search-header">
        <h1>Search</h1>
        <form class="search-form" action="search.php" method="GET">
            <input type="search" name="q" placeholder="Search for services, projects, articles..." 
                   value="<?= $query ?>" autofocus>
            <button type="submit" class="cta-button">Search</button>
        </form>
    </section>
    
    <div class="search-container">
        <?php if ($query): ?>
            <div class="search-info">
                <p>Showing results for "<strong><?= $query ?></strong>"</p>
            </div>
            
            <div id="searchResults" class="search-results">
                <div class="loading">Searching...</div>
            </div>
        <?php else: ?>
            <div class="search-placeholder">
                <div class="placeholder-icon">🔍</div>
                <h2>Find what you're looking for</h2>
                <p>Search for services, projects, blog articles, and more.</p>
                <div class="search-suggestions">
                    <h3>Popular searches:</h3>
                    <div class="suggestion-tags">
                        <a href="?q=solar" class="suggestion-tag">Solar Energy</a>
                        <a href="?q=sustainability" class="suggestion-tag">Sustainability</a>
                        <a href="?q=energy" class="suggestion-tag">Energy Efficiency</a>
                        <a href="?q=water" class="suggestion-tag">Water Conservation</a>
                        <a href="?q=carbon" class="suggestion-tag">Carbon Footprint</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<script>
<?php if ($query): ?>
// Perform search when page loads with query
document.addEventListener('DOMContentLoaded', function() {
    const query = '<?= addslashes($query) ?>';
    performSearch(query);
});

function performSearch(query) {
    const resultsContainer = document.getElementById('searchResults');
    
    fetch('api/search.php?q=' + encodeURIComponent(query))
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayResults(data);
            } else {
                resultsContainer.innerHTML = '<div class="no-results"><p>An error occurred. Please try again.</p></div>';
            }
        })
        .catch(error => {
            resultsContainer.innerHTML = '<div class="no-results"><p>An error occurred. Please try again.</p></div>';
        });
}

function displayResults(data) {
    const container = document.getElementById('searchResults');
    let html = '';
    
    if (data.total === 0) {
        html = `
            <div class="no-results">
                <div class="no-results-icon">🔍</div>
                <h3>No results found</h3>
                <p>Try different keywords or browse our pages below.</p>
            </div>
        `;
    } else {
        // Pages results
        if (data.results.pages && data.results.pages.length > 0) {
            html += `
                <div class="result-section">
                    <h2>Pages</h2>
                    <div class="result-list">
                        ${data.results.pages.map(page => `
                            <a href="${page.url}" class="result-item">
                                <span class="result-type">Page</span>
                                <h3>${page.title}</h3>
                                <p>${page.description}</p>
                            </a>
                        `).join('')}
                    </div>
                </div>
            `;
        }
        
        // Services results
        if (data.results.services && data.results.services.length > 0) {
            html += `
                <div class="result-section">
                    <h2>Services</h2>
                    <div class="result-list">
                        ${data.results.services.map(service => `
                            <a href="services.php#${service.id}" class="result-item">
                                <span class="result-type">Service</span>
                                <h3>${service.title}</h3>
                                <p>${service.description}</p>
                            </a>
                        `).join('')}
                    </div>
                </div>
            `;
        }
        
        // Projects results
        if (data.results.projects && data.results.projects.length > 0) {
            html += `
                <div class="result-section">
                    <h2>Projects</h2>
                    <div class="result-list">
                        ${data.results.projects.map(project => `
                            <a href="projects.php#${project.id}" class="result-item">
                                <span class="result-type">Project</span>
                                <h3>${project.title}</h3>
                                <p>${project.description}</p>
                            </a>
                        `).join('')}
                    </div>
                </div>
            `;
        }
        
        // Blog results
        if (data.results.blog && data.results.blog.length > 0) {
            html += `
                <div class="result-section">
                    <h2>Blog Articles</h2>
                    <div class="result-list">
                        ${data.results.blog.map(post => `
                            <a href="blog-post.php?slug=${post.slug || post.id}" class="result-item">
                                <span class="result-type">Article</span>
                                <h3>${post.title}</h3>
                                <p>${post.excerpt}</p>
                            </a>
                        `).join('')}
                    </div>
                </div>
            `;
        }
        
        html = `<p class="results-count">${data.total} result${data.total !== 1 ? 's' : ''} found</p>` + html;
    }
    
    container.innerHTML = html;
}
<?php endif; ?>
</script>

<?php include 'includes/footer.php'; ?>
</body>
</html>
