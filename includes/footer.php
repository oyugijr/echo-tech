<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-main">
            <div class="footer-brand">
                <h3>EcoTech Solutions</h3>
                <p class="tagline">Pioneering sustainable technology solutions for a greener, more efficient future.</p>
                <!-- Footer Newsletter Signup -->
                <div class="footer-newsletter">
                    <h4>Subscribe to Newsletter</h4>
                    <form class="footer-newsletter-form" id="footerNewsletterForm">
                        <input type="email" name="email" placeholder="Your email" required>
                        <button type="submit">→</button>
                    </form>
                </div>
            </div>

            <div class="footer-links">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="services.php">Services</a></li>
                    <li><a href="projects.php">Projects</a></li>
                    <li><a href="blog.php">Blog</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </div>

            <div class="footer-contact">
                <h4>Contact Us</h4>
                <address>
                    123 Green Street<br>
                    Eco City, EC 12345<br>
                    +1 (555) 123-4587<br>
                    <a href="mailto:info@ecotechsolutions.com">info@ecotechsolutions.com</a>
                </address>
            </div>
        </div>

        <div class="footer-bottom">
            <p class="copyright">© 2025 EcoTech Solutions. All rights reserved.</p>
            <div class="legal-links">
                <a href="privacy-policy.php">Privacy Policy</a>
                <span class="divider">|</span>
                <a href="terms.php">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>

<!-- Live Chat Widget -->
<?php include_once __DIR__ . '/chat-widget.php'; ?>

<!-- Newsletter Form Handler -->
<script>
document.querySelectorAll('[id$="NewsletterForm"]').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const email = this.querySelector('input[name="email"]').value;
        const button = this.querySelector('button');
        const originalText = button.innerHTML;
        
        button.innerHTML = '...';
        button.disabled = true;
        
        fetch('api/subscribe.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email: email })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.success) {
                this.reset();
            }
        })
        .catch(error => {
            alert('Thank you for subscribing!');
            this.reset();
        })
        .finally(() => {
            button.innerHTML = originalText;
            button.disabled = false;
        });
    });
});
</script>