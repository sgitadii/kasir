@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden max-w-2xl">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-2xl font-bold text-gray-800">Edit Pelanggan</h2>
        </div>

        <form action="{{ route('customers.update', $customer->id) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">Nama Pelanggan</label>
                <input type="text" id="nama" name="nama" placeholder="Masukkan nama pelanggan"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('nama') border-red-500 @enderror"
                    value="{{ old('nama', $customer->nama) }}">
                @error('nama')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-2">Alamat</label>
                <textarea id="alamat" name="alamat" rows="4" placeholder="Masukkan alamat pelanggan"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('alamat') border-red-500 @enderror">{{ old('alamat', $customer->alamat) }}</textarea>
                @error('alamat')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="telepon" class="block text-sm font-semibold text-gray-700 mb-2">Telepon</label>
                <input type="text" id="telepon" name="telepon" placeholder="Contoh: 08123456789"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('telepon') border-red-500 @enderror"
                    value="{{ old('telepon', $customer->telepon) }}">
                @error('telepon')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                    Perbarui
                </button>
                <a href="{{ route('customers.index') }}"
                    class="bg-gray-300 text-gray-800 px-6 py-2 rounded-lg font-semibold hover:bg-gray-400 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
