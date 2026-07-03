<p class="px-3 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Main</p>

<a href="{{ route('manager.dashboard') }}"
   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
          {{ request()->routeIs('manager.dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
    </svg>
    Dashboard
</a>

<p class="px-3 mt-5 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Produk</p>

<a href="#"
   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition text-gray-600 hover:bg-gray-100 hover:text-gray-900">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
    </svg>
    Daftar Produk
</a>

<a href="{{ route('admin.suppliers.index') }}"
   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition text-gray-600 hover:bg-gray-100 hover:text-gray-900">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
    </svg>
    Supplier
</a>

<p class="px-3 mt-5 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Stok</p>

<a href="#"
   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition text-gray-600 hover:bg-gray-100 hover:text-gray-900">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
    </svg>
    Transaksi Masuk
</a>

<a href="#"
   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition text-gray-600 hover:bg-gray-100 hover:text-gray-900">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
    </svg>
    Transaksi Keluar
</a>

<a href="#"
   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition text-gray-600 hover:bg-gray-100 hover:text-gray-900">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
    </svg>
    Laporan
</a>