require('./bootstrap');

document.addEventListener('DOMContentLoaded', () => {
    const visitedOptions = document.getElementById('visited-options');
    const favoritedOptions = document.getElementById('favorited-options');
    const radios = document.querySelectorAll('input[name="recipient"]');

    const toggleOptions = () => {
        const selected = document.querySelector('input[name="recipient"]:checked').value;
        visitedOptions.style.display = selected === 'visited' ? 'block' : 'none';
        favoritedOptions.style.display = selected === 'favorited' ? 'block' : 'none';
    };

    radios.forEach(r => r.addEventListener('change', toggleOptions));
    toggleOptions(); // 初期表示
});