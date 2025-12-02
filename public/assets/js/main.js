// Main JavaScript file
document.addEventListener('DOMContentLoaded', function () {

    // Chat widget functionality
    const chatToggle = document.getElementById('chat-toggle');
    const chatWindow = document.getElementById('chat-window');
    const chatClose = document.getElementById('chat-close');

    if (chatToggle) {
        chatToggle.addEventListener('click', function () {
            chatWindow.style.display = chatWindow.style.display === 'none' ? 'block' : 'none';
        });
    }

    if (chatClose) {
        chatClose.addEventListener('click', function () {
            chatWindow.style.display = 'none';
        });
    }

    // Newsletter form submission
    const newsletterForms = document.querySelectorAll('.newsletter-form');
    newsletterForms.forEach(form => {
        form.addEventListener('submit', async function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            try {
                const response = await fetch('/api/subscribe', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    alert('Thank you for subscribing!');
                    this.reset();
                } else {
                    alert(result.message || 'Subscription failed. Please try again.');
                }
            } catch (error) {
                alert('An error occurred. Please try again later.');
            }
        });
    });

    // Mobile menu toggle
    const menuToggle = document.querySelector('.menu-toggle');
    const mainNav = document.querySelector('.main-nav');

    if (menuToggle) {
        menuToggle.addEventListener('click', function () {
            mainNav.classList.toggle('active');
        });
    }

});
