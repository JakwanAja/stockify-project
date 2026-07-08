<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan | Stockify</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 flex items-center justify-center">
    <div class="text-center px-6">

        {{-- Icon --}}
        <div class="flex justify-center mb-6">
            <div class="w-24 h-24 rounded-full bg-blue-100 flex items-center justify-center">
                <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        {{-- Kode Error --}}
        <h1 class="text-8xl font-bold text-blue-500 mb-2">404</h1>

        {{-- Pesan --}}
        <h2 class="text-2xl font-semibold text-gray-800 mb-3">Halaman Tidak Ditemukan</h2>
        <p class="text-gray-500 text-sm max-w-md mx-auto mb-8">
            Halaman yang kamu cari tidak ada atau mungkin sudah dipindahkan.
            Periksa kembali URL yang kamu masukkan.
        </p>

        {{-- Actions --}}
        <div class="flex items-center justify-center gap-3">
            @auth
                <a href="{{ url()->previous() }}"
                   class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">
                    ← Kembali
                </a>
                <a href="{{ match(Auth::user()->role) {
                        'Admin'          => route('admin.dashboard'),
                        'Manajer Gudang' => route('manager.dashboard'),
                        'Staff Gudang'   => route('staff.dashboard'),
                        default          => '/'
                    } }}"
                   class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                    Ke Dashboard
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                    Login
                </a>
            @endauth
        </div>

        {{-- Logo --}}
        <div class="mt-12">
            <p class="text-xs text-gray-400">Stockify — Sistem Manajemen Stok Gudang</p>
        </div>

    </div>
</body>
</html>