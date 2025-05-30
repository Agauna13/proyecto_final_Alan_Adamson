/**
 * Script simple para cambiar quitar/poner el estado 'oculto' en las diferentes
 * secciones de la carta
 */

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
