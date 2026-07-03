@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang kembali, ' . Auth::user()->name)

@section('sidebar')
    @include('components.sidebar-manager')
@endsection

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-sm text-gray-500">Stok Menipis</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">—</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-sm text-gray-500">Barang Masuk Hari Ini</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">—</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-sm text-gray-500">Barang Keluar Hari Ini</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">—</p>
        </div>
    </div>
@endsection