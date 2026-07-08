<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Stockify') - Stockify</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('components.modal-confirm-delete')
</head>
<body class="bg-gray-50 antialiased h-full">
    <div class="flex h-screen overflow-hidden">
        {{-- Sidebar --}}
        <aside class="w-64 flex-shrink-0 bg-white border-r border-gray-200 flex flex-col h-full overflow-y-auto">
            {{-- Logo --}}
            <div class="flex items-center gap-3 px-5 py-5 border-b border-gray-200">
                <img src="{{ asset('images/stokify_logo_circle.png') }}" alt="Stockify" class="w-8 h-8 object-contain">
                <span class="text-xl font-bold text-gray-900">Stockify</span>
            </div>
            {{-- Navigation --}}
            <nav class="flex-1 px-3 py-4 space-y-1">
                @yield('sidebar')
            </nav>

            {{-- User Info di bawah sidebar --}}
            <div class="border-t border-gray-200 p-4">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                        <span class="text-sm font-semibold text-blue-600">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ Auth::user()->role }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" title="Logout" class="text-gray-400 hover:text-red-500 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Main Area --}}
        <div class="flex-1 flex flex-col overflow-hidden">

            {{-- Topbar --}}
            <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between flex-shrink-0">
                <div>
                    <h1 class="text-lg font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                    <p class="text-xs text-gray-500 mt-0.5">@yield('page-subtitle', '')</p>
                </div>
                <div class="flex items-center gap-3">
                    {{-- Notifikasi --}}
                    <button class="relative p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </button>
                    {{-- Tanggal --}}
                    <div class="text-xs text-gray-500 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-200">
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </div>
                </div>
            </header>

            {{-- Flash Message --}}
            <div class="px-6 pt-4">
                @if(session('success'))
                    <div id="alert-success" class="flex items-center gap-3 p-4 mb-2 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
                        <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ session('success') }}</span>
                        <button onclick="document.getElementById('alert-success').remove()" class="ml-auto text-green-500 hover:text-green-700">✕</button>
                    </div>
                @endif
                @if(session('error'))
                    <div id="alert-error" class="flex items-center gap-3 p-4 mb-2 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                        <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-.75-11.25a.75.75 0 011.5 0v4.5a.75.75 0 01-1.5 0v-4.5zm.75 7.5a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ session('error') }}</span>
                        <button onclick="document.getElementById('alert-error').remove()" class="ml-auto text-red-500 hover:text-red-700">✕</button>
                    </div>
                @endif
            </div>

            {{-- Page Content --}}
            <main class="flex-1 overflow-y-auto px-6 py-4">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>