@extends('layouts.app')

@section('content')
	<div class="max-w-2xl mx-auto">
		<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
			<div class="p-6 border-b border-gray-100 flex justify-between items-center">
				<div>
					<h2 class="text-2xl font-bold text-gray-800">Edit Produk</h2>
					<p class="text-gray-600 mt-1">Perbarui informasi produk</p>
				</div>
				<a href="{{ route('produk.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded">Kembali</a>
			</div>

			<div class="p-6">
				@if ($errors->any())
					<div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg">
						<ul class="list-disc list-inside">
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif

				<form action="{{ route('produk.update', $produk->id) }}" method="POST">
					@csrf
					@method('PUT')

					<div class="grid grid-cols-1 gap-4">
						<div>
							<label class="block text-sm font-medium text-gray-700">Nama Produk</label>
							<input type="text" name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
						</div>

						<div class="grid grid-cols-2 gap-4">
							<div>
								<label class="block text-sm font-medium text-gray-700">Harga</label>
								<input type="number" name="harga" value="{{ old('harga', $produk->harga) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" min="0" required>
							</div>
							<div>
								<label class="block text-sm font-medium text-gray-700">Stok</label>
								<input type="number" name="stok" value="{{ old('stok', $produk->stok) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" min="0" required>
							</div>
						</div>

						<div>
							<label class="block text-sm font-medium text-gray-700">Kategori</label>
							<select name="kategori" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
								<option value="">-- Pilih Kategori --</option>
								@foreach ($kategoris as $kategori)
									<option value="{{ $kategori->nama }}" {{ old('kategori', $produk->kategori) == $kategori->nama ? 'selected' : '' }}>{{ $kategori->nama }}</option>
								@endforeach
							</select>
						</div>

						<div class="flex justify-end gap-3 mt-4">
							<a href="{{ route('produk.index') }}" class="px-4 py-2 border rounded bg-white hover:bg-gray-50">Batal</a>
							<button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan Perubahan</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

@endsection

