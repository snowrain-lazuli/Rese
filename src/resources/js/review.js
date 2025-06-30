require('./bootstrap');

document.addEventListener('DOMContentLoaded', () => {
    const stars = document.querySelectorAll('.star-group .star');
    const ratingInput = document.getElementById('rating');

    function updateStars(value) {
        stars.forEach(star => {
            star.textContent = parseInt(star.dataset.value) <= value ? '★' : '☆';
        });
    }

    stars.forEach(star => {
        star.addEventListener('click', () => {
            const value = parseInt(star.dataset.value);
            ratingInput.value = value;
            updateStars(value);
        });
    });
});
