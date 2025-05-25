document.addEventListener('DOMContentLoaded', () => {
    const headers = document.querySelectorAll('.accordion-header');

    headers.forEach(header => {
        header.addEventListener('click', () => {
            const content = header.nextElementSibling;

            // Alternar clase 'active' en el contenido
            content.classList.toggle('active');

            // Rotar el icono (si usas un svg con clase 'accordion-icon')
            const icon = header.querySelector('.accordion-icon');
            if (icon) {
                icon.classList.toggle('rotate-180');
            }
        });
    });
});
