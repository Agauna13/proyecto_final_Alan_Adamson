/*document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.desplegable').forEach(item => {
        item.addEventListener('click', (event) => {
            // El siguiente hermano es el contenido que se oculta/muestra
            const content = event.target.nextElementSibling;
            if (content) {
                content.classList.toggle('hidden');
            }
        });
    });
});*/

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.desplegable').forEach(el => {
        el.addEventListener('click', () => {
            const next = el.nextElementSibling;
            if (next) {
                next.classList.toggle('hidden');
            }
        });
    });
});
