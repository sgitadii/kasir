@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-slate-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-8">
                <div>
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Data Transaksi</h2>
                    <p class="text-slate-500 mt-1">Kelola dan pantau aktivitas penjualan Anda.</p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                    <form action="{{ route('transaksi.index') }}" method="GET" class="relative flex-1 sm:min-w-[300px]">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari pelanggan atau produk..."
                            class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none text-sm">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        @if (request('search'))
                            <a href="{{ route('transaksi.index') }}"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-red-500">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        @endif
                    </form>

                    <a href="{{ route('transaksi.create') }}"
                        class="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-indigo-200 transition-all transform hover:-translate-y-1 active:scale-95 whitespace-nowrap">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Transaksi
                    </a>
                    <a href="{{ route('transaksi.export') }}"
                        class="inline-flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-emerald-200 transition-all transform hover:-translate-y-1 active:scale-95 whitespace-nowrap"
                        title="Export transaksi ke Excel">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 5v14m7-7H5"></path>
                        </svg>
                        Export Excel
                    </a>
                </div>
            </div>

            @if (request('search') && $transaksis->count() == 0)
                <div class="bg-white rounded-2xl p-12 text-center border border-dashed border-slate-300 mb-8">
                    <p class="text-slate-500">Tidak ada hasil untuk pencarian <span
                            class="font-bold text-slate-800">"{{ request('search') }}"</span></p>
                    <a href="{{ route('transaksi.index') }}" class="text-indigo-600 font-bold mt-2 inline-block">Reset
                        Pencarian</a>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-xl shadow-sm flex items-center">
                    <svg class="w-5 h-5 text-emerald-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="text-emerald-800 font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/60 border border-slate-100 overflow-hidden">
                @if ($transaksis->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-100">
                                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Kode Transaksi</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">
                                        Pelanggan</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Produk
                                    </th>
                                    <th
                                        class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-center">
                                        Qty</th>
                                    <th
                                        class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-right">
                                        Total Harga</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Tanggal
                                    </th>
                                    <th
                                        class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-center">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach ($transaksis as $transaksi)
                                    <tr class="hover:bg-indigo-50/30 transition-colors group">
                                        <td class="px-6 py-4 text-sm text-slate-500 font-medium">{{ $transaksi->kode_transaksi }}</td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-bold text-slate-900">
                                                {{ $transaksi->customer->nama ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-600 italic font-medium">
                                            {{ $transaksi->produk->nama_produk ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-center font-bold text-slate-700 bg-slate-50/50">
                                            {{ $transaksi->jumlah }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-black text-right text-indigo-600">
                                            Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-500">
                                            {{ $transaksi->created_at->format('d M Y') }}
                                            <span
                                                class="block text-xs text-slate-400">{{ $transaksi->created_at->format('H:i') }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex justify-center items-center gap-3">
                                                <a href="{{ route('transaksi.download-invoice', $transaksi->id) }}"
                                                    class="p-2 text-emerald-500 hover:bg-emerald-50 rounded-lg transition-all"
                                                    title="Download Invoice">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4">
                                                        </path>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('transaksi.destroy', $transaksi->id) }}"
                                                    method="POST" class="inline"
                                                    onsubmit="return confirm('Yakin hapus transaksi ini?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-all"
                                                        title="Hapus">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-16 text-center">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-slate-50 rounded-full mb-4">
                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                </path>
                            </svg>
                        </div>
                        <p class="text-slate-500 text-lg font-medium">Belum ada data transaksi tersimpan</p>
                        <a href="{{ route('transaksi.create') }}"
                            class="mt-4 inline-block text-indigo-600 font-bold hover:underline">Buat Transaksi Pertama
                            &rarr;</a>
                    </div>
                @endif
            </div>

            @if ($transaksis->count() > 0)
                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center">
                        <div
                            class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Transaksi</p>
                            <p class="text-2xl font-black text-slate-800">{{ $transaksis->count() }}</p>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center">
                        <div
                            class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Pendapatan Hari Ini</p>
                            <p class="text-2xl font-black text-slate-800">Rp
                                {{ number_format($todayTotal ?? 0, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center">
                        <div
                            class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center text-purple-600 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Bulan Ini</p>
                            <p class="text-2xl font-black text-slate-800">Rp
                                {{ number_format($monthTotal ?? 0, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
