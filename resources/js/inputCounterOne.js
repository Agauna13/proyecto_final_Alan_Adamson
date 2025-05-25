document.addEventListener('DOMContentLoaded', () => {
    const totalElement = document.getElementById('precioTotalFooter');
    // Seleccionamos el formulario por acción (ajusta si cambias ruta)
    const form = document.getElementById('form-productos');
    if (!form) {
        console.warn('Formulario no encontrado');
        return;
    }

    if (!form || !totalElement) return;

    function actualizarTotal() {
        let total = 0;

        // Suma todos los inputs cantidad con data-precio dentro del form
        const cantidades = form.querySelectorAll('input.cantidad-input[data-precio]');
        cantidades.forEach(input => {
            const precio = parseFloat(input.dataset.precio) || 0;
            const cantidad = parseInt(input.value) || 0;
            total += precio * cantidad;
        });

        totalElement.textContent = `Total: ${total.toFixed(2)} €`;
    }

    form.querySelectorAll('button.decrease').forEach(button => {
        button.addEventListener('click', () => {
            const input = button.nextElementSibling;
            if (!input) return;
            let current = parseInt(input.value) || 0;
            if (current > 0) {
                input.value = current - 1;
                input.dispatchEvent(new Event('input'));
            }
        });
    });

    form.querySelectorAll('button.increase').forEach(button => {
        button.addEventListener('click', () => {
            const input = button.previousElementSibling;
            if (!input) return;
            let current = parseInt(input.value) || 0;
            input.value = current + 1;
            input.dispatchEvent(new Event('input'));
        });
    });

    form.querySelectorAll('input.cantidad-input').forEach(input => {
        input.addEventListener('input', () => {
            if (input.value === '' || parseInt(input.value) < 0) {
                input.value = 0;
            }
            actualizarTotal();
        });
    });

    actualizarTotal();
});
