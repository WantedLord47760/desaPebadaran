import './bootstrap';
import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay, EffectFade } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/effect-fade';

Alpine.plugin(intersect);
window.Alpine = Alpine;

// Alpine stores and components
Alpine.store('mobileMenu', { open: false });
Alpine.store('lightbox', { open: false, currentSrc: '', currentTitle: '', isVideo: false });

// Initialize Swiper for hero carousel
document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('.hero-swiper')) {
        new Swiper('.hero-swiper', {
            modules: [Navigation, Pagination, Autoplay, EffectFade],
            effect: 'fade',
            loop: true,
            autoplay: { delay: 5000, disableOnInteraction: false },
            pagination: { el: '.swiper-pagination', clickable: true },
            navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
        });
    }
});

Alpine.start();
