<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile User</title>

    <!-- Tailwind & Alpine -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">

    <style>
        [x-cloak] {
            display: none !important;
        }
        .profile-card {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- User Profile Card -->
        <div class="profile-card rounded-xl shadow-lg overflow-hidden mb-8">
            <div class="flex flex-col md:flex-row">
                <!-- User Avatar -->
                <div class="md:w-1/3 bg-green-600 flex items-center justify-center p-8">
                    <div class="relative">
                        <div class="w-32 h-32 rounded-full bg-white flex items-center justify-center shadow-lg">
                            <i class="fas fa-user text-5xl text-green-600"></i>
                        </div>
                        <div class="absolute -bottom-2 -right-2 bg-white rounded-full p-2 shadow-md">
                            <i class="fas fa-pencil-alt text-green-600 text-sm"></i>
                        </div>
                    </div>
                </div>
                
                <!-- User Info -->
                <div class="md:w-2/3 p-6 md:p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-1">{{ $user->name }}</h2>
                    <p class="text-gray-600 mb-4 flex items-center">
                        <i class="fas fa-envelope mr-2 text-green-600"></i>
                        {{ $user->email }}
                    </p>
                    <div class="flex flex-wrap gap-2">
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium">
                            <i class="fas fa-shield-alt mr-1"></i> Pengguna Terdaftar
                        </span>
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-medium">
                            <i class="fas fa-calendar-check mr-1"></i> Bergabung {{ $user->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Success Message -->
            @if (session('status'))
            <div class="mx-6 mt-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg flex items-center animate-fade-in">
                <i class="fas fa-check-circle mr-2 text-xl"></i>
                <p class="font-medium">{{ session('status') }}</p>
            </div> @endif

            <!-- Profile Update Section -->
            <div class="p-6
        sm:p-8">
    <div class="flex items-center mb-6">
        <div class="bg-green-100 p-3 rounded-full mr-4">
            <i class="fas fa-user-edit text-green-600 text-xl"></i>
        </div>
        <h3 class="text-xl font-semibold text-gray-800">Informasi Profil</h3>
    </div>

    <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <!-- Name Field -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="pl-10 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-4 focus:ring-green-500 focus:border-green-500 bg-white">
                </div>
                @error('name')
                    <div class="text-red-500 text-sm mt-2 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Email Field -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <label class="block text-sm font-medium text-gray-700 mb-2">Email (NIK)</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="pl-10 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-4 focus:ring-green-500 focus:border-green-500 bg-white">
                </div>
                @error('email')
                    <div class="text-red-500 text-sm mt-2 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="flex justify-between items-center pt-4">
            <a href="{{ route('user.tampil14') }}"
                class="inline-flex items-center px-6 py-2 border border-gray-300 text-base font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
            <button type="submit"
                class="inline-flex items-center px-6 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                <i class="fas fa-save mr-2"></i>
                Simpan Perubahan
            </button>
        </div>
    </form>
    </div>

    <!-- Password Update Section -->
    <div class="p-6 sm:p-8 bg-gray-50 border-t border-gray-200">
        <div class="flex items-center mb-6">
            <div class="bg-blue-100 p-3 rounded-full mr-4">
                <i class="fas fa-key text-blue-600 text-xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-800">Keamanan Akun</h3>
        </div>

        <form action="{{ route('profile.updatePassword') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <!-- Current Password -->
                <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password Saat Ini</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" name="current_password" required
                            class="pl-10 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-4 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    @error('current_password')
                        <div class="text-red-500 text-sm mt-2 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- New Password -->
                <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" name="new_password" required
                            class="pl-10 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-4 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    @error('new_password')
                        <div class="text-red-500 text-sm mt-2 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="sm:col-span-2 bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" name="new_password_confirmation" required
                            class="pl-10 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-4 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4 pt-4">
                <button type="submit"
                    class="inline-flex items-center px-6 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <i class="fas fa-key mr-2"></i>
                    Ganti Password
                </button>
                <a href="{{ route('user.tampil14') }}" class="bg-gray-400 rounded-lg px-4 py-2">Kembali</a>
            </div>
        </form>
    </div>
    </div>
    </div>
    </body>

</html>
