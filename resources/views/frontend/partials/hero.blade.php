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
                    <a
                        href="{{ route('reservas.create') }}"
                        class="inline-flex items-center gap-2 rounded-md bg-red-600 px-6 py-2.5 text-sm font-medium text-white transition hover:bg-white hover:text-red-600"
                    >
                        Reserva ya con nosotros
                        <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1"
                            fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <div>
                <img src="{{ asset('images/hamburguesa.jpg') }}"
                    alt="Hamburguesa Mokitrokis" class="rounded-xl shadow-md" />
            </div>
        </div>
    </div>
</section>
