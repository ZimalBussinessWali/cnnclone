/**
 * CNN Clone - Client Side Interactive logic
 */

document.addEventListener('DOMContentLoaded', () => {
    
    // 1. Smooth Reveal for News Cards
    const observerOptions = {
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'all 0.6s ease-out';
        observer.observe(card);
    });

    // 2. Breaking News Ticker Optimization
    // If the ticker content is shorter than the screen, we clone it to ensure seamless looping
    const ticker = document.querySelector('.ticker');
    if (ticker) {
        const tickerItems = ticker.innerHTML;
        ticker.innerHTML += tickerItems + tickerItems; // Triple it for smooth infinite scroll
    }

    // 3. Simple Header Scroll Effect
    const header = document.querySelector('header');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            header.style.padding = '0.5rem 5%';
            header.style.boxShadow = '0 5px 15px rgba(0,0,0,0.3)';
        } else {
            header.style.padding = '1rem 5%';
            header.style.boxShadow = 'none';
        }
    });

    // 4. Share Button Interactions (UI Only)
    const shareBtns = document.querySelectorAll('.share-buttons div');
    shareBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            this.style.transform = 'scale(0.9)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
                alert('Shared successfully (Simulated)');
            }, 100);
        });
    });

});
