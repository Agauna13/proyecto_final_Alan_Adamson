<header
    class="flex justify-between items-center bg-gradient-to-r from-black via-gray-900 to-black text-white px-10 py-6 shadow-2xl sticky top-0 z-50 border-b-2 border-yellow-500/70 backdrop-blur-sm animate-slideInFromTop">
    <a href="{{route('home')}}"
        class="text-4xl font-black text-yellow-400 tracking-wide hover:scale-110 transition-transform duration-300 animate-slideInFromLeft">
        Mokitrokis
    </a>

    <nav class="flex items-center gap-8 animate-slideInFromRight">
        <a href="{{ route('reservas.create') }}"
            class="uppercase font-bold tracking-wide text-black bg-yellow-400 rounded-md px-5 py-2 hover:bg-yellow-500 hover:scale-[0.95] transition transform duration-300 shadow-md">
            Reserva
        </a>

        <a href="{{ route('productos.index') }}"
            class="uppercase font-bold tracking-wide text-gray-200 bg-gray-700 rounded-md px-5 py-2 hover:bg-gray-600 hover:scale-[0.95] transition transform duration-300 shadow-md">
            Carta
        </a>

    </nav>
</header>
