document.querySelectorAll('.botonReserva').forEach(item => {
    item.addEventListener('click', function() {
        document.querySelector('.reserva').scrollIntoView({
            behavior: 'smooth'
        });
    });
});
