@extends('layouts.app')

@section('title', 'Riwayat Transaksi')
@section('page-title', 'Riwayat Transaksi')
@section('page-subtitle', 'Semua riwayat transaksi stok gudang')

@section('sidebar')
    @include('components.sidebar-manager')
@endsection

@section('content')
    @include('partials.riwayat-transaksi-table', [
        'filterRoute' => route('manager.riwayat-transaksi.index')
    ])
@endsection