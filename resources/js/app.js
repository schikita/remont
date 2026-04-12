import './bootstrap';
import Alpine from 'alpinejs';
import leadForm from './leadForm';
import quizWizard from './quizWizard';

window.leadForm = leadForm;

document.addEventListener('alpine:init', () => {
    Alpine.data('quizWizard', quizWizard);
});

window.Alpine = Alpine;
Alpine.start();

function initScrollToTopButton() {
    const btn = document.getElementById('scroll-top-button');
    if (!btn) {
        return;
    }

    const threshold = 280;

    const sync = () => {
        const y = window.scrollY || document.documentElement.scrollTop || 0;
        const show = y > threshold;
        // Атрибут hidden (а не класс .hidden), чтобы не конфликтовать с display:inline-flex в Tailwind.
        btn.toggleAttribute('hidden', !show);
        btn.setAttribute('aria-hidden', show ? 'false' : 'true');
    };

    window.addEventListener('scroll', sync, { passive: true });
    window.addEventListener('resize', sync, { passive: true });
    sync();

    btn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initScrollToTopButton);
} else {
    initScrollToTopButton();
}
