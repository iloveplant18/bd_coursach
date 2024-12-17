import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('click', function (event) {
    let navLink = event.target.closest('.nav-link')
    if (!navLink) return

    navLink.classList.add('active')
})
