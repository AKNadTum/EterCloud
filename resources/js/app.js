import './bootstrap';
import Alpine from 'alpinejs';
import { initPlansCarousel } from './components/plans-carousel';

window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    initPlansCarousel();
});
