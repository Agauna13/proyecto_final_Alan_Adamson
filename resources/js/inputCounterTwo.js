document.addEventListener('DOMContentLoaded', () => {
    const totalElement = document.getElementById('precioTotalFooter');
    const form = document.getElementById('pedidoForm');

    if (!form || !totalElement) return;

    function actualizarTotal() {
        let total = 0;

        // Precio base de productos únicos (inputs hidden .precio-unitario)
        const preciosBase = form.querySelectorAll('input.precio-unitario[data-precio]');
        preciosBase.forEach(input => {
            const precio = parseFloat(input.dataset.precio) || 0;
            total += precio;
        });

        // Extras y entrantes (inputs cantidad con data-precio)
        const cantidades = form.querySelectorAll('input.cantidad-input[data-precio]');
        cantidades.forEach(input => {
            const precio = parseFloat(input.dataset.precio) || 0;
            const cantidad = parseInt(input.value) || 0;
            total += precio * cantidad;
        });

        // Extras de licores seleccionados en los <select>
        const selectsLicor = form.querySelectorAll('select[name*="[extra_licor]"]');
        selectsLicor.forEach(select => {
            const selectedOption = select.options[select.selectedIndex];
            if (selectedOption && selectedOption.value) {
                // Extraer precio del texto: (+2.00 €)
                const extraText = selectedOption.textContent;
                const match = extraText.match(/\+([\d,.]+) €/);
                if (match) {
                    const precioExtra = parseFloat(match[1].replace(',', '.')) || 0;
                    total += precioExtra;
                }
            }
        });

        totalElement.textContent = `Total: ${total.toFixed(2)} €`;
    }

    // Botones de decrease
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

    // Botones de increase
    form.querySelectorAll('button.increase').forEach(button => {
        button.addEventListener('click', () => {
            const input = button.previousElementSibling;
            if (!input) return;
            let current = parseInt(input.value) || 0;
            input.value = current + 1;
            input.dispatchEvent(new Event('input'));
        });
    });

    // Inputs cantidad normales
    form.querySelectorAll('input.cantidad-input').forEach(input => {
        input.addEventListener('input', () => {
            if (input.value === '' || parseInt(input.value) < 0) {
                input.value = 0;
            }
            actualizarTotal();
        });
    });

    // Selects de extras de licores
    const selectsLicor = form.querySelectorAll('select[name*="[extra_licor]"]');
    selectsLicor.forEach(select => {
        select.addEventListener('change', () => {
            actualizarTotal();
        });
    });

    actualizarTotal();
});


/*document.addEventListener('DOMContentLoaded', () => {
    const totalElement = document.getElementById('precioTotalFooter');
    const form = document.getElementById('pedidoForm');

    if (!form || !totalElement) return;

    function actualizarTotal() {
        let total = 0;

        // Precio base de productos únicos (inputs hidden .precio-unitario)
        const preciosBase = form.querySelectorAll('input.precio-unitario[data-precio]');
        preciosBase.forEach(input => {
            const precio = parseFloat(input.dataset.precio) || 0;
            total += precio;
        });

        // Extras y entrantes (inputs cantidad con data-precio)
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
*/
