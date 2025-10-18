// Mobile menu toggle
const mobileToggle = document.getElementById('mobileToggle');
const navMenu = document.getElementById('navMenu');

if (mobileToggle && navMenu) {
    mobileToggle.addEventListener('click', function() {
        navMenu.classList.toggle('active');
    });

    // Close mobile menu when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.top-nav')) {
            navMenu.classList.remove('active');
        }
    });
}

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Grade card click tracking
document.querySelectorAll('.grade-button').forEach(button => {
    button.addEventListener('click', function(e) {
        const gradeCard = this.closest('.grade-card');
        if (gradeCard) {
            const grade = gradeCard.querySelector('.grade-title').textContent;
            console.log(`Grade selected: ${grade}`);
            // Add analytics tracking here if needed
            // gtag('event', 'grade_selection', { 'grade': grade });
        }
    });
});

// Utility function for analytics (if you add Google Analytics later)
function trackEvent(eventName, eventData = {}) {
    // Google Analytics 4 tracking
    if (typeof gtag !== 'undefined') {
        gtag('event', eventName, eventData);
    }
    
    // Console log for development
    console.log('Event tracked:', eventName, eventData);
}