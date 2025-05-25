    <div
        class="flex flex-col min-h-screen bg-white rounded-2xl shadow-lg border border-gray-200 justify-center items-center p-6">
        <h1 class="text-3xl font-extrabold text-indigo-700 tracking-wide mb-6 text-center">Iniciar Sesión</h1>

        <div class="w-full max-w-md bg-white border border-gray-300 rounded-xl shadow p-6">
            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 text-green-600 font-semibold text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs uppercase text-gray-600 font-semibold">Correo
                        Electrónico</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="mt-1 w-full px-4 py-2 rounded border border-gray-300 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                        placeholder="correo@ejemplo.com">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs uppercase text-gray-600 font-semibold">Contraseña</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="mt-1 w-full px-4 py-2 rounded border border-gray-300 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                        placeholder="••••••••">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center gap-2">
                    <input id="remember_me" type="checkbox" name="remember"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-400 focus:outline-none">
                    <label for="remember_me" class="text-sm text-gray-600">Recuérdame</label>
                </div>

                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-6">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            class="text-xs text-gray-500 hover:text-indigo-600 transition">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif

                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2 rounded shadow shadow-indigo-500/20 transition">
                        Entrar
                    </button>
                </div>
            </form>
        </div>
    </div>
