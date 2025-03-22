<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=       , initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/contact.css">
    <title>Document</title>
</head>
<body>
<?php include 'includes/header.php'; ?>

<main class="contact-page">
    <div class="contact-container">
        <!-- Contact Form Section -->
        <section class="contact-form-section">
            <h1>Contact Us</h1>
            <p class="contact-intro">Have questions about our sustainable technology solutions? Get in touch with our team today.</p>
            
            <form class="contact-form" id="contactForm" action="/cgi-bin/process_form.py" method="POST">
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" required>
                        <span class="validation-error"></span>
                    </div>
                    <div class="form-group">
                        <label for="company">Company</label>
                        <input type="text" id="company" name="company">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" required>
                        <span class="validation-error"></span>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" pattern="\(\d{3}\) \d{3}-\d{4}" placeholder="(123) 456-7890" required>
                        <span class="validation-error"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="5" required></textarea>
                    <span class="validation-error"></span>
                </div>

                <button type="submit" class="cta-button">Send Message</button>
            </form>
        </section>

        <!-- Contact Info Section -->
        <section class="contact-info-section">
            <div class="contact-info-card">
                <h2>Contact Information</h2>
                
                <div class="contact-details">
                    <div class="detail-group">
                        <h3>Our Location</h3>
                        <p>123 Green Street<br>
                        Eco City, EC 12345<br>
                        United States</p>
                    </div>

                    <div class="detail-group">
                        <h3>Phone</h3>
                        <p>Main: +1 (555) 123-4567<br>
                        Support: +1 (555) 987-6543</p>
                    </div>

                    <div class="detail-group">
                        <h3>Email</h3>
                        <p>General: info@ecotechsolutions.com<br>
                        Support: support@ecotechsolutions.com<br>
                        Sales: sales@ecotechsolutions.com</p>
                    </div>

                    <div class="detail-group">
                        <h3>Business Hours</h3>
                        <p>Monday - Friday: 8:00 AM - 6:00 PM<br>
                        Saturday: 9:00 AM - 2:00 PM<br>
                        Sunday: Closed</p>
                    </div>
                </div>

                <!-- <div class="map-container">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12345.6789!2d-0.123456!3d51.5074!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNTHCsDMwJzI2LjgiTiAwwrAwNyczOS42Ilc!5e0!3m2!1sen!2suk!4v1620000000000!5m2!1sen!2suk" 
                        width="100%" 
                        height="300" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div> -->
            </div>
        </section>
        <!-- Map Section -->
        <section class="map-section">
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d255282.32335424496!2d36.84739685!3d-1.3032089500000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f1172d84d49a7%3A0xf7cf0254b297924c!2sNairobi!5e0!3m2!1sen!2ske!4v1742586530370!5m2!1sen!2ske" 
                    width="100%" 
                    height="450" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </section>
    </div>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="faq-container">
            <h2>Frequently Asked Questions</h2>
            
            <div class="faq-grid">
                <div class="faq-card">
                    <h3>What industries do you serve?</h3>
                    <p>We work with clients across various industries including commercial real estate, hospitality, manufacturing, technology, healthcare, education, and government.</p>
                </div>

                <div class="faq-card">
                    <h3>Do you offer maintenance services?</h3>
                    <p>Yes, we provide ongoing maintenance and support services for all our solutions. We offer different service level agreements to meet your specific needs.</p>
                </div>

                <div class="faq-card">
                    <h3>Can you work with our existing systems?</h3>
                    <p>Yes, our solutions are designed to integrate with existing infrastructure whenever possible, maximizing your current investments while improving sustainability.</p>
                </div>

                <div class="faq-card">
                    <h3>How long does implementation typically take?</h3>
                    <p>Implementation timelines vary based on the scope and complexity of the project. Small-scale solutions can be implemented in a few weeks, while larger projects may take several months.</p>
                </div>

                <div class="faq-card">
                    <h3>What is the typical return on investment?</h3>
                    <p>ROI varies by project, but our clients typically see returns within 1-3 years. Many of our solutions also qualify for tax incentives and rebates that can improve ROI.</p>
                </div>

                <div class="faq-card">
                    <h3>Do you offer financing options?</h3>
                    <p>We partner with several financial institutions that specialize in sustainable technology financing. We can help you explore these options during our consultation.</p>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
document.getElementById('contactForm').addEventListener('submit', function(e) {
    let valid = true;
    const inputs = this.querySelectorAll('input, textarea');
    
    inputs.forEach(input => {
        const error = input.nextElementSibling;
        if (!input.checkValidity()) {
            error.style.opacity = '1';
            input.style.borderColor = '#e74c3c';
            valid = false;
        } else {
            error.style.opacity = '0';
            input.style.borderColor = '#e3e9ed';
        }
    });

    if (!valid) {
        e.preventDefault();
        this.classList.add('form-error');
        setTimeout(() => this.classList.remove('form-error'), 500);
    }
});

// Add input event listeners for real-time validation
document.querySelectorAll('#contactForm input, #contactForm textarea').forEach(input => {
    input.addEventListener('input', function() {
        const error = this.nextElementSibling;
        if (this.checkValidity()) {
            error.style.opacity = '0';
            this.style.borderColor = '#e3e9ed';
        }
    });
});
</script>

<?php include 'includes/footer.php'; ?>
</body>
</html>
