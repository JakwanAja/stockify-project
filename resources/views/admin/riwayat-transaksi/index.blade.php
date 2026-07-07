@extends('layouts.app')

@section('title', 'Riwayat Transaksi')
@section('page-title', 'Riwayat Transaksi')
@section('page-subtitle', 'Semua riwayat transaksi stok gudang')

@section('sidebar')
    @include('components.sidebar-admin')
@endsection

@section('content')
    @include('partials.riwayat-transaksi-table', [
        'filterRoute' => route('admin.riwayat-transaksi.index')
    ])
@endsection