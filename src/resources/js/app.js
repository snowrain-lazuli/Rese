require('./bootstrap');

document.addEventListener('DOMContentLoaded', function () {
    const hamburger = document.getElementById('hamburger');
    const overlayMenu = document.getElementById('overlayMenu');

    hamburger.addEventListener('click', function () {
        hamburger.classList.toggle('open');
        overlayMenu.classList.toggle('open');
    });
});