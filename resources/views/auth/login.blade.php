<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Posyandu</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Sisi Gambar (60%) -->
        <!-- Sisi Gambar (60%) - Hanya tampil di desktop -->
        <div class="hidden md:block md:w-3/5 h-64 md:h-auto relative">
            <img src="{{ asset('images/login.jpeg') }}" alt="Gambar Posyandu" class="object-cover w-full h-full">
        </div>


        <!-- Sisi Form Login (40%) -->
        <div class="w-full md:w-2/5 flex items-center justify-center p-6 md:p-10 bg-white">
            <div class="w-full max-w-md">
                <div class="text-center mb-8">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="mx-auto h-24 mb-4">
                    <h2 class="text-2xl font-semibold text-gray-800">Selamat Datang</h2>
                    <p class="text-gray-600 mt-2">Silakan masuk ke akun Anda</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Form Login -->
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- NIK -->
                    <div>
                        <x-input-label for="identifier" :value="__('Email')" class="text-gray-700 font-medium" />
                        <x-text-input id="identifier" name="identifier" type="text"
                            class="block mt-1 w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                            placeholder="Masukkan NIK" :value="old('identifier')" autocomplete="off" required autofocus />
                        <x-input-error :messages="$errors->get('identifier')" class="mt-2 text-red-600 text-sm" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-medium" />
                        <x-text-input id="password"
                            class="block mt-1 w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                            placeholder="Masukkan Password" type="password" name="password" required />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600 text-sm" />
                    </div>

                    <!-- Remember & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" type="checkbox" name="remember"
                                class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-600">
                                {{ __('Ingatkan Saya') }}
                            </label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-800">
                                {{ __('Lupa Password?') }}
                            </a>
                        @endif
                    </div>

                    <!-- Petunjuk -->
                    <div class="bg-blue-50 p-3 rounded-lg">
                        <p class="text-sm text-blue-800">
                            <span class="font-semibold">Petunjuk:</span> Gunakan <strong>NIK</strong> anak sebagai
                            username dan <strong>password</strong> yang diberikan.
                        </p>
                    </div>

                    <!-- Tombol Login -->
                    <div>
                        <x-primary-button
                            class="w-full justify-center py-3 text-sm font-medium bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
                            {{ __('Masuk') }}
                        </x-primary-button>
                    </div>
                </form>

                <!-- Footer -->
                <div class="mt-8 text-center text-sm text-gray-500">
                    <p>© {{ date('Y') }} Aplikasi Posyandu. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
