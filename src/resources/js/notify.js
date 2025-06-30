require('./bootstrap');

document.addEventListener('DOMContentLoaded', () => {
    const visitedOptions = document.getElementById('visited-options');
    const favoritedOptions = document.getElementById('favorited-options');
    const radios = document.querySelectorAll('input[name="recipient"]');

    const toggleOptions = () => {
        const selected = document.querySelector('input[name="recipient"]:checked')?.value;
        if (!selected) return;
        if (visitedOptions) visitedOptions.style.display = selected === 'visited' ? 'block' : 'none';
        if (favoritedOptions) favoritedOptions.style.display = selected === 'favorited' ? 'block' : 'none';
    };

    radios.forEach(radio => radio.addEventListener('change', toggleOptions));
    toggleOptions();
});
