@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 py-8 px-4">
    <div class="max-w-3xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Tambah Produk</h2>
                <p class="text-slate-500 mt-1">Lengkapi detail produk baru Anda di bawah ini.</p>
            </div>
            <a href="{{ route('produk.index') }}" 
                class="inline-flex items-center text-slate-600 hover:text-indigo-600 font-semibold transition-colors">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Katalog
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/60 border border-slate-100 overflow-hidden">
            <div class="p-8">
                <form action="{{ route('produk.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 tracking-wide">Nama Produk</label>
                            <input type="text" name="nama_produk" value="{{ old('nama_produk') }}" 
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none" 
                                placeholder="Contoh: Kopi Susu Gula Aren" required>
                            @error('nama_produk')
                                <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 tracking-wide">Kategori</label>
                            <div class="relative">
                                <select name="kategori" 
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none appearance-none bg-white" required>
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->nama_kategori }}" {{ old('kategori') == $kategori->nama_kategori ? 'selected' : '' }}>
                                            {{ $kategori->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                            @error('kategori')
                                <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 tracking-wide">Harga Jual (Rp)</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-medium border-r pr-3 border-slate-200">Rp</span>
                                <input type="number" name="harga" value="{{ old('harga') }}" min="0" 
                                    class="w-full pl-16 pr-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none" 
                                    placeholder="0" required>
                            </div>
                            @error('harga')
                                <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 tracking-wide">Stok Awal</label>
                            <div class="relative">
                                <input type="number" name="stok" value="{{ old('stok') }}" min="0" 
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none" 
                                    placeholder="0" required>
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-medium">Pcs</span>
                            </div>
                            @error('stok')
                                <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <hr class="border-slate-100 my-2">

                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ route('produk.index') }}" 
                            class="px-6 py-3 text-sm font-bold text-slate-500 hover:text-slate-700 transition-colors">
                            Batal
                        </a>
                        <button type="submit" 
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-10 rounded-xl shadow-lg shadow-indigo-200 transition-all transform hover:-translate-y-1 active:scale-95">
                            Simpan Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection