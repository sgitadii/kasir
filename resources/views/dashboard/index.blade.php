@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Dashboard</h2>
        <p class="text-gray-600 mt-1">Ringkasan singkat sistem</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Total Produk -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-500">Total Produk</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($totalProduk ?? 0) }}</p>
                <a href="{{ route('produk.index') }}" class="text-sm text-blue-600 mt-2 inline-block">Lihat produk</a>
            </div>
        </div>

        <!-- Transaksi Hari Ini -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-500">Total Transaksi Hari Ini</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($transaksiHariIni ?? 0) }}</p>
                <a href="{{ route('transaksi.index') }}" class="text-sm text-blue-600 mt-2 inline-block">Lihat transaksi</a>
            </div>
        </div>

        <!-- Transaksi Bulan Ini -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-500">TotalTransaksi Bulan Ini</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($transaksiBulanIni ?? 0) }}</p>
                <a href="{{ route('transaksi.index') }}" class="text-sm text-blue-600 mt-2 inline-block">Lihat transaksi</a>
            </div>
        </div>
    </div>
</div>
@endsection
