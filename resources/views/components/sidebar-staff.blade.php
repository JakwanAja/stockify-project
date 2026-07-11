<p class="px-3 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Main</p>

<a href="{{ route('staff.dashboard') }}"
   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
          {{ request()->routeIs('staff.dashboard') ? 'bg-red-50 text-red-600' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
    </svg>
    Dashboard
</a>

<p class="px-3 mt-5 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Tugas Saya</p>

<a href="{{ route('staff.transaksi-masuk.index') }}"
   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition text-gray-600 hover:bg-gray-100 hover:text-gray-900">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
    </svg>
    Konfirmasi Barang Masuk
</a>

<a href="{{ route('staff.transaksi-keluar.index') }}"
   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition text-gray-600 hover:bg-gray-100 hover:text-gray-900">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
    </svg>
    Konfirmasi Barang Keluar
</a>