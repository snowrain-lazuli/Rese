require('./bootstrap');

document.addEventListener('DOMContentLoaded', function () {
    const stars = document.querySelectorAll('.star-rating .star');
    const ratingInput = document.getElementById('rating');

    function updateStars(value) {
        stars.forEach(star => {
            if (parseInt(star.dataset.value) <= value) {
                star.textContent = '★';
            } else {
                star.textContent = '☆';
            }
        });
    }

    stars.forEach(star => {
        star.addEventListener('click', function () {
            const value = parseInt(this.dataset.value);
            ratingInput.value = value;
            updateStars(value);
        });
    });
});