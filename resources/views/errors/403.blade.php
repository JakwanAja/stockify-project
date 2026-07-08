<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak | Stockify</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 flex items-center justify-center">
    <div class="text-center px-6">

        {{-- Icon --}}
        <div class="flex justify-center mb-6">
            <div class="w-24 h-24 rounded-full bg-red-100 flex items-center justify-center">
                <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
        </div>

        {{-- Kode Error --}}
        <h1 class="text-8xl font-bold text-red-500 mb-2">403</h1>

        {{-- Pesan --}}
        <h2 class="text-2xl font-semibold text-gray-800 mb-3">Akses Ditolak</h2>
        <p class="text-gray-500 text-sm max-w-md mx-auto mb-8">
            Kamu tidak memiliki izin untuk mengakses halaman ini.
            Pastikan kamu login dengan akun yang memiliki hak akses yang sesuai.
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