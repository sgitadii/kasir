@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Buat Transaksi Baru</h2>
                <p class="text-slate-500 mt-2 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="id-card-10 12h4m-2-2v4m5.338 1.833L11 15.033l-3.338-3.2m-1.33 0a7.5 7.5 0 1010.668 0h1.33z"/></svg>
                    Kelola penjualan barang dengan pencatatan otomatis.
                </p>
            </div>
            <a href="{{ route('transaksi.index') }}" class="hidden md:flex items-center text-sm font-medium text-slate-500 hover:text-slate-700 transition">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/></svg>
                Kembali ke Daftar
            </a>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl shadow-sm animate-pulse">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-red-800">Terdapat kesalahan input:</h3>
                        <ul class="mt-1 list-disc list-inside text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/60 border border-slate-100 overflow-hidden">
            <form action="{{ route('transaksi.store') }}" method="POST" class="p-8">
                @csrf

                <div class="mb-8">
                    <label class="block text-sm font-bold text-slate-700 mb-4 uppercase tracking-wider">
                        Data Pelanggan <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="nama_pelanggan" class="block text-xs font-semibold text-slate-600 mb-2">Nama Pelanggan</label>
                            <input type="text" name="nama_pelanggan" id="nama_pelanggan" placeholder="Nama lengkap" value="{{ old('nama_pelanggan') }}"
                                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all @error('nama_pelanggan') border-red-500 @enderror">
                            @error('nama_pelanggan')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="alamat_pelanggan" class="block text-xs font-semibold text-slate-600 mb-2">Alamat</label>
                            <input type="text" name="alamat_pelanggan" id="alamat_pelanggan" placeholder="Jl. Contoh No. 123" value="{{ old('alamat_pelanggan') }}"
                                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all @error('alamat_pelanggan') border-red-500 @enderror">
                            @error('alamat_pelanggan')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="telepon_pelanggan" class="block text-xs font-semibold text-slate-600 mb-2">Nomor HP</label>
                            <input type="text" name="telepon_pelanggan" id="telepon_pelanggan" placeholder="081234567890" value="{{ old('telepon_pelanggan') }}"
                                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all @error('telepon_pelanggan') border-red-500 @enderror">
                            @error('telepon_pelanggan')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="md:col-span-1">
                        <label for="nama_produk_id" class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wider">Produk <span class="text-red-500">*</span></label>
                        <select name="nama_produk_id" id="nama_produk_id"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all @error('nama_produk_id') border-red-500 @enderror"
                            required onchange="updateHarga()">
                            <option value="">-- Pilih --</option>
                            @foreach ($produks as $produk)
                                <option value="{{ $produk->id }}" data-harga="{{ $produk->harga }}"
                                    data-stok="{{ $produk->stok }}"
                                    {{ old('nama_produk_id') == $produk->id ? 'selected' : '' }}>
                                    {{ $produk->nama_produk }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wider">Harga Satuan</label>
                        <input type="text" id="hargaSatuan" readonly
                            class="w-full px-4 py-3 bg-slate-100 border border-slate-200 rounded-xl text-slate-600 font-semibold cursor-not-allowed">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wider">Stok</label>
                        <input type="text" id="stokTersedia" readonly
                            class="w-full px-4 py-3 border rounded-xl font-bold transition-colors duration-300 cursor-not-allowed">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8 border-t border-slate-100 pt-8">
                    <div class="space-y-6">
                        <div>
                            <label for="jumlah" class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wider">Jumlah Unit <span class="text-red-500">*</span></label>
                            <input type="number" name="jumlah" id="jumlah" min="1" value="{{ old('jumlah', 1) }}"
                                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all @error('jumlah') border-red-500 @enderror"
                                required oninput="updateHarga()">
                        </div>

                        <div>
                            <label for="uangCustomer" class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wider">Bayar (Cash) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 font-medium">Rp</span>
                                <input type="number" name="uang_customer" id="uangCustomer" min="0" value="{{ old('uang_customer', 0) }}"
                                    class="w-full pl-12 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all @error('uang_customer') border-red-500 @enderror"
                                    required oninput="updateHarga()">
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100 space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-500 font-medium">Total Tagihan</span>
                            <p id="totalHarga" class="text-2xl font-black text-indigo-600 tracking-tight">Rp 0</p>
                        </div>
                        <div class="h-px bg-slate-200 w-full"></div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-500 font-medium">Kembalian</span>
                            <p id="uangKembalian" class="text-2xl font-black tracking-tight">Rp 0</p>
                        </div>
                        <div class="pt-2">
                             <div id="statusBadge" class="hidden text-center py-1 rounded-full text-xs font-bold uppercase tracking-widest"></div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-4 pt-6 border-t border-slate-100">
                    <button type="submit"
                        class="flex-1 bg-indigo-600 text-white px-8 py-4 rounded-xl font-bold hover:bg-indigo-700 transition-all transform hover:-translate-y-1 shadow-lg shadow-indigo-200 active:scale-95">
                        Konfirmasi & Simpan Transaksi
                    </button>
                    <a href="{{ route('transaksi.index') }}"
                        class="px-8 py-4 text-center rounded-xl font-bold text-slate-500 hover:bg-slate-100 transition-all">
                        Batalkan
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID').format(angka);
    }

    function updateHarga() {
        const produkSelect = document.getElementById('nama_produk_id');
        const jumlahInput = document.getElementById('jumlah');
        const uangCustomerInput = document.getElementById('uangCustomer');
        const hargaSatuanEl = document.getElementById('hargaSatuan');
        const stokTersediaEl = document.getElementById('stokTersedia');
        const totalHargaEl = document.getElementById('totalHarga');
        const uangKembalianEl = document.getElementById('uangKembalian');
        const statusBadge = document.getElementById('statusBadge');

        const selectedOption = produkSelect.selectedOptions[0];

        if (!selectedOption || !selectedOption.value) {
            hargaSatuanEl.value = '-';
            stokTersediaEl.value = '-';
            stokTersediaEl.className = "w-full px-4 py-3 bg-slate-100 border-slate-200 border rounded-xl cursor-not-allowed";
            totalHargaEl.textContent = 'Rp 0';
            uangKembalianEl.textContent = 'Rp 0';
            uangKembalianEl.className = 'text-2xl font-black text-slate-400 tracking-tight';
            statusBadge.classList.add('hidden');
            return;
        }

        const hargaSatuan = parseInt(selectedOption.dataset.harga) || 0;
        const stokTersedia = parseInt(selectedOption.dataset.stok) || 0;
        const jumlah = parseInt(jumlahInput.value) || 0;
        const uangCustomer = parseInt(uangCustomerInput.value) || 0;
        const total = hargaSatuan * jumlah;
        const kembalian = uangCustomer - total;

        hargaSatuanEl.value = 'Rp ' + formatRupiah(hargaSatuan);
        totalHargaEl.textContent = 'Rp ' + formatRupiah(total);
        
        // UI untuk Kembalian
        uangKembalianEl.textContent = 'Rp ' + formatRupiah(kembalian >= 0 ? kembalian : 0);
        statusBadge.classList.remove('hidden');

        if (kembalian < 0) {
            uangKembalianEl.className = 'text-2xl font-black text-red-500 tracking-tight';
            statusBadge.textContent = 'Uang Kurang';
            statusBadge.className = 'text-center py-1 rounded-full text-xs font-bold uppercase tracking-widest bg-red-100 text-red-600';
        } else {
            uangKembalianEl.className = 'text-2xl font-black text-emerald-500 tracking-tight';
            statusBadge.textContent = 'Pembayaran Cukup';
            statusBadge.className = 'text-center py-1 rounded-full text-xs font-bold uppercase tracking-widest bg-emerald-100 text-emerald-600';
        }

        // UI untuk Stok
        stokTersediaEl.value = stokTersedia + ' unit';
        if (stokTersedia <= 0) {
            stokTersediaEl.className = 'w-full px-4 py-3 border-red-200 bg-red-50 text-red-600 rounded-xl font-bold cursor-not-allowed';
        } else if (stokTersedia < 10) {
            stokTersediaEl.className = 'w-full px-4 py-3 border-orange-200 bg-orange-50 text-orange-600 rounded-xl font-bold cursor-not-allowed';
        } else {
            stokTersediaEl.className = 'w-full px-4 py-3 border-emerald-200 bg-emerald-50 text-emerald-600 rounded-xl font-bold cursor-not-allowed';
        }
    }

    window.addEventListener('load', updateHarga);
</script>
@endsection