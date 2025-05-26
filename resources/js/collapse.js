document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.desplegable').forEach(item => {
        item.addEventListener('click', (event) => {
            const content = event.target.nextElementSibling;
            content.classList.toggle('oculto');
        });
    });
});
