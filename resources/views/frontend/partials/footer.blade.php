<footer class="bg-black text-white py-8 px-4 m-auto sm:px-8 lg:px-12 mt-12">
    <div class="max-w-screen-xl mx-auto flex flex-col sm:flex-row sm:justify-between gap-6">

        <div class="flex flex-col gap-3 sm:w-1/3">
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/logo.svg') }}" alt="Logo Mokitrokis" class="h-10 w-auto object-contain">
                <span class="font-bernier text-2xl font-semibold">Mokitrokis</span>
            </div>
            <p class="text-gray-400 text-sm">
                Tu lugar de confianza para hamburguesas, perritos y pizzas caseras. ¡Ven a disfrutarlo con los tuyos!
            </p>
        </div>

        <div class="flex flex-col gap-2 text-sm sm:w-1/3">
            <h3 class="text-white font-semibold mb-1">Contacto</h3>
            <p class="text-gray-400">Carrer Mare de Déu de Montserrat, 63, Llevant, 07008 Palma, Illes Balears</p>
            <p class="text-gray-400">Tel: +34 123 456 789</p>
            <p class="text-gray-400">Email: contacto@mokitrokis.com</p>
        </div>

        <div class="flex flex-col gap-2 sm:w-1/3">
            <h3 class="text-white font-semibold mb-1">Enlaces rápidos</h3>
            <div class="flex gap-4 text-sm flex-wrap">
                <a href="{{ route('reservas.create') }}" class="hover:text-red-500 transition-colors">Reserva</a>
                <a href="{{ route('productos.index') }}" class="hover:text-red-500 transition-colors">Carta</a>
                <a href="{{ route('home') }}" class="hover:text-red-500 transition-colors">Inicio</a>
            </div>
            <h3 class="text-white font-semibold mt-4 mb-1">Síguenos</h3>
            <div class="flex gap-4">
                <a href="#" target="_blank" class="hover:text-red-500 transition-colors"><i
                        class="fab fa-facebook-f"></i></a>
                <a href="#" target="_blank" class="hover:text-red-500 transition-colors"><i
                        class="fab fa-instagram"></i></a>
                <a href="#" target="_blank" class="hover:text-red-500 transition-colors"><i
                        class="fab fa-twitter"></i></a>
            </div>
        </div>

    </div>

    <div class="mt-8 text-center text-xs text-gray-500">
        &copy; {{ date('Y') }} Mokitrokis. Todos los derechos reservados.
    </div>
</footer>
