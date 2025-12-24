export function initPlansCarousel() {
    const carousel = document.getElementById('plans-carousel');
    const prevBtn = document.getElementById('carousel-prev');
    const nextBtn = document.getElementById('carousel-next');

    if (!carousel || !carousel.firstElementChild) return;

    let isPaused = false;
    let isManual = false;
    const speed = 0.5; // Vitesse de défilement (pixels par frame)
    let animationId = null;

    // Calcul des dimensions
    const getDimensions = () => {
        const firstItem = carousel.firstElementChild;
        if (!firstItem) return { itemWidth: 0, totalItems: 0, setWidth: 0 };
        const style = window.getComputedStyle(carousel);
        const gap = parseFloat(style.gap) || 24;
        const itemWidth = firstItem.offsetWidth + gap;
        const totalItems = carousel.children.length / 3;
        const setWidth = itemWidth * totalItems;
        return { itemWidth, totalItems, setWidth };
    };

    let dims = getDimensions();

    const setInitialPosition = () => {
        dims = getDimensions();
        if (dims.setWidth > 0) {
            carousel.scrollLeft = dims.setWidth;
        }
    };

    // Attendre que le layout soit stabilisé
    setTimeout(setInitialPosition, 100);

    const animate = () => {
        if (!isPaused && !isManual) {
            carousel.scrollLeft += speed;

            // Saut invisible pour l'infini
            if (carousel.scrollLeft >= dims.setWidth * 2) {
                carousel.scrollLeft -= dims.setWidth;
            } else if (carousel.scrollLeft <= 0) {
                carousel.scrollLeft += dims.setWidth;
            }
        }
        animationId = requestAnimationFrame(animate);
    };

    // Lancer l'animation
    animationId = requestAnimationFrame(animate);

    // Pause au survol (incluant les boutons)
    const container = carousel.closest('.group');
    if (container) {
        container.addEventListener('mouseenter', () => { isPaused = true; });
        container.addEventListener('mouseleave', () => {
            isPaused = false;
            isManual = false;
        });
    }

    // Navigation manuelle
    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            isManual = true;
            carousel.scrollBy({ left: -400, behavior: 'smooth' });
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            isManual = true;
            carousel.scrollBy({ left: 400, behavior: 'smooth' });
        });
    }

    // Re-calculer au redimensionnement
    window.addEventListener('resize', () => {
        setInitialPosition();
    });

    // Gérer le repositionnement lors du scroll manuel ou interaction
    carousel.addEventListener('scroll', () => {
        if (isPaused || isManual) {
            if (carousel.scrollLeft <= 10) {
                carousel.scrollLeft = dims.setWidth + carousel.scrollLeft;
            } else if (carousel.scrollLeft >= dims.setWidth * 2 - 10) {
                carousel.scrollLeft = carousel.scrollLeft - dims.setWidth;
            }
        }
    });

    return () => cancelAnimationFrame(animationId);
}
