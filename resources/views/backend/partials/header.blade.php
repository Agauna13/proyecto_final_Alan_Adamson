<header class="flex items-center justify-between bg-indigo-700 p-6 rounded-b-xl shadow-lg mb-8">
    <h1 class="text-white text-3xl font-extrabold tracking-tight">Dashboard</h1>

    <nav class="space-x-4">
        <a href="{{ route('admin.pedidos.index') }}"
            class="inline-block px-5 py-2 bg-indigo-500 hover:bg-indigo-600 text-white font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-300 transition">
            Pedidos
        </a>

        <a href="{{ route('admin.reservas.index') }}"
            class="inline-block px-5 py-2 bg-indigo-500 hover:bg-indigo-600 text-white font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-300 transition">
            Reservas
        </a>

        <a href="{{ route('admin.mesas.index') }}"
            class="inline-block px-5 py-2 bg-indigo-500 hover:bg-indigo-600 text-white font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-300 transition">
            Mesas
        </a>
    </nav>
</header>
