<header
    class="flex flex-wrap justify-between items-center bg-black text-white px-12 py-8 sticky top-0 z-50 backdrop-blur-sm animate-slideInFromTop">

    <a href="{{ route('home') }}"
        class="font-bernier text-3xl sm:text-4xl font-black tracking-wide hover:scale-110 transition-transform duration-300 animate-slideInFromLeft mb-2 sm:mb-0">
        Mokitrokis
    </a>

    <nav class="flex flex-wrap gap-4 sm:gap-6 items-center">
        <a href="{{ route('reservas.create') }}"
            class="uppercase font-semibold tracking-wide text-white bg-red-700 rounded-md px-4 py-2 hover:bg-red-600 hover:scale-95 transition-transform duration-200 whitespace-nowrap">
            Reserva
        </a>

        <a href="{{ route('productos.index') }}"
            class="uppercase font-semibold tracking-wide text-white bg-gray-800 rounded-md px-4 py-2 hover:bg-gray-700 hover:scale-95 transition-transform duration-200 whitespace-nowrap">
            Carta
        </a>
    </nav>
</header>
