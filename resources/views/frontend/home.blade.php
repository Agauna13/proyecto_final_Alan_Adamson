<!doctype html>
<html class="bg-black">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    @vite('resources/css/app.css')
</head>

<body class="bg-black text-white">
    {{-- Header --}}
    @include('frontend.partials.header')

    {{-- HERO --}}
    <section class="min-h-[75vh] bg-black text-white pt-20 pb-24">
        <div class="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 md:items-center">
                <div class="max-w-lg flex flex-col gap-10">
                    <h2 id="hero_title" class="text-4xl font-semibold text-white">
                        Mokitrokis.
                    </h2>

                    <p class="text-gray-200 text-lg leading-relaxed">
                        Desde 2022, Mokitrokis ha sido el lugar de encuentro para familias, amigos y parejas que
                        buscan disfrutar de una deliciosa comida en un ambiente relajado y acogedor.
                    </p>

                    <div>
                        <a href="{{ route('reservas.create') }}"
                            class="inline-flex items-center gap-2 rounded-md bg-red-600 px-6 py-2.5 text-sm font-medium text-white transition hover:bg-white hover:text-red-600">
                            Reserva ya con nosotros
                            <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1"
                                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>

                <div>
                    <img src="{{ asset('images/hamburguesa.jpg') }}" alt="Hamburguesa Mokitrokis"
                        class="rounded-xl shadow-md" />
                </div>
            </div>
        </div>
    </section>

    {{-- COMIDAS / GALERÍA --}}
    <section class="py-16 bg-black text-white">
        <div class="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
            <div class="mb-12 text-center max-w-2xl mx-auto">
                <h2 class="text-4xl font-semibold text-red-700 mb-4">Mucho más que hamburguesas</h2>
                <p class="text-gray-300 text-lg leading-relaxed">
                    Mokitrokis es un restaurante de barrio donde la comida se disfruta con los tuyos.
                    Servimos hamburguesas, perritos, pepitos y pizzas caseras con un toque especial.
                    Reserva desde nuestra web y organiza tu cena o evento con antelación para que todo
                    esté listo cuando llegues.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="overflow-hidden rounded-xl group relative">
                    <img src="{{ asset('images/hamburguesa.jpg') }}" alt="Hamburguesas"
                        class="w-full h-60 object-cover group-hover:scale-105 transition-transform duration-300" />
                    <div
                        class="absolute bottom-0 left-0 right-0 bg-black/60 text-center py-2 text-sm font-semibold text-white">
                        Hamburguesas caseras
                    </div>
                </div>

                <div class="overflow-hidden rounded-xl group relative">
                    <img src="{{ asset('images/nachos4q.png') }}" alt="Nachos"
                        class="w-full h-60 object-cover group-hover:scale-105 transition-transform duration-300" />
                    <div
                        class="absolute bottom-0 left-0 right-0 bg-black/60 text-center py-2 text-sm font-semibold text-white">
                        Nachos
                    </div>
                </div>

                <div class="overflow-hidden rounded-xl group relative">
                    <img src="{{ asset('images/sandwich.jpeg') }}" alt="Sandwich"
                        class="w-full h-60 object-cover group-hover:scale-105 transition-transform duration-300" />
                    <div
                        class="absolute bottom-0 left-0 right-0 bg-black/60 text-center py-2 text-sm font-semibold text-white">
                        Sandwiches
                    </div>
                </div>

                <div class="overflow-hidden rounded-xl group relative">
                    <img src="{{ asset('images/pizza.png') }}" alt="Pizzas"
                        class="w-full h-60 object-cover group-hover:scale-105 transition-transform duration-300" />
                    <div
                        class="absolute bottom-0 left-0 right-0 bg-black/60 text-center py-2 text-sm font-semibold text-white">
                        Pizzas
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- MAPA --}}
    <section class="py-20 bg-gray-950 text-white">
        <div class="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-12 md:grid-cols-2 md:items-center">
                <div>
                    <div id="map" class="w-full aspect-[4/3] rounded-lg shadow-md"></div>
                </div>

                <div class="max-w-lg">
                    <h2 class="text-4xl font-semibold text-red-700">
                        ¡Estamos muy cerca de ti!
                    </h2>
                    <p class="mt-4 text-xl text-gray-200 leading-relaxed">
                        Ven a vernos y disfruta de la mejor experiencia gastronómica.
                    </p>
                    <div class="mt-6 text-sm sm:text-base text-gray-400">
                        <span class="block">Dirección:</span>
                        <span class="font-medium text-white">
                            Carrer Mare de Déu de Montserrat, 63, Llevant, 07008 Palma, Illes Balears
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('frontend.partials.footer')

    @vite('resources/js/app.js')
    @vite('resources/js/map.js')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</body>

</html>
