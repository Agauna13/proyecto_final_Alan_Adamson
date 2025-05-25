<header
    class="bg-indigo-700 p-4 sm:p-6 rounded-b-xl shadow-lg mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 sm:gap-4">
    <a href="{{route('admin.dashboard')}}" class="text-white text-2xl sm:text-3xl font-extrabold tracking-tight">Dashboard</a>

    <nav class="flex flex-wrap gap-2 sm:gap-4 justify-center sm:justify-end">
        <a href="{{ route('admin.pedidos.index') }}"
            class="px-4 py-1 text-sm bg-indigo-500 hover:bg-indigo-600 text-white font-semibold rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-indigo-300 transition">Pedidos</a>
        <a href="{{ route('admin.reservas.index') }}"
            class="px-4 py-1 text-sm bg-indigo-500 hover:bg-indigo-600 text-white font-semibold rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-indigo-300 transition">Reservas</a>
        <a href="{{ route('admin.mesas.index') }}"
            class="px-4 py-1 text-sm bg-indigo-500 hover:bg-indigo-600 text-white font-semibold rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-indigo-300 transition">Mesas</a>
    </nav>
</header>
