document.addEventListener('DOMContentLoaded', () => {
    const favoriteForms = document.querySelectorAll('.favorite-form');

    favoriteForms.forEach(form => {
        const icon = form.querySelector('.shop-list__favorite-icon');

        icon.addEventListener('click', (event) => {
            event.preventDefault();

            const isFavorite = icon.getAttribute('src') === '/images/heart_red.png';

            icon.setAttribute('src', isFavorite ? '/images/heart_gray.png' : '/images/heart_red.png');

            form.submit();
        });
    });
});
