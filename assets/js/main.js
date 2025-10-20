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

// Mobile dropdown menu toggle
document.querySelectorAll('.grades-dropdown > a').forEach(dropdownToggle => {
    dropdownToggle.addEventListener('click', function(e) {
        // Only handle on mobile (when hamburger menu is visible)
        if (window.innerWidth <= 768) {
            const href = this.getAttribute('href');
            
            // If it's a dropdown toggle (href is # or empty)
            if (!href || href === '#') {
                e.preventDefault();
                const parentLi = this.parentElement;
                
                // Close other dropdowns
                document.querySelectorAll('.grades-dropdown').forEach(dropdown => {
                    if (dropdown !== parentLi) {
                        dropdown.classList.remove('active');
                    }
                });
                
                // Toggle current dropdown
                parentLi.classList.toggle('active');
            }
        }
    });
});

// Smooth scrolling for anchor links (skip empty # or dropdown toggles)
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        
        // Skip if href is just "#" or empty (dropdown toggles)
        if (!href || href === '#' || href.length <= 1) {
            return;
        }
        
        e.preventDefault();
        const target = document.querySelector(href);
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