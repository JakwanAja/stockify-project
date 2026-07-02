@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('sidebar')
    <p class="text-xs font-semibold text-gray-400 uppercase mb-3">Menu Admin</p>
    <a href="{{ route('admin.dashboard') }}" class="block py-2 px-3 rounded-lg text-sm text-blue-600 bg-blue-50 font-medium">Dashboard</a>
@endsection

@section('content')
    <h2 class="text-2xl font-bold text-gray-800 mb-2">Dashboard Admin</h2>
    <p class="text-gray-500 text-sm">Selamat datang, {{ Auth::user()->name }}. Phase 1 berhasil! ✅</p>
@endsection