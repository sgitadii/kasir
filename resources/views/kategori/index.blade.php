@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
	<div class="mb-6">
		<h2 class="text-2xl font-bold text-gray-800">Kategori Produk</h2>
		<p class="text-gray-600 mt-1">Lihat dan tambahkan kategori produk</p>
	</div>

	@if ($errors->any())
		<div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg">
			<ul class="list-disc list-inside">
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	@if (session('success'))
		<div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">
			{{ session('success') }}
		</div>
	@endif

	<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
		<form action="{{ route('kategori.store') }}" method="POST" class="flex gap-3">
			@csrf
			<input type="text" name="nama_kategori" placeholder="Nama kategori" value="{{ old('nama_kategori') }}"
				class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
			<button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700">Tambah</button>
		</form>
	</div>

	<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
		<h3 class="text-lg font-semibold text-gray-700 mb-4">Daftar Kategori</h3>
		@if($kategoris->count() > 0)
			<div class="overflow-x-auto">
				<table class="min-w-full divide-y divide-gray-200">
					<thead class="bg-gray-50">
						<tr>
							<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
							<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kategori</th>
							<th scope="col" class="px-6 py-3"></th>
						</tr>
					</thead>
					<tbody class="bg-white divide-y divide-gray-200">
						@foreach($kategoris as $kategori)
							<tr class="hover:bg-gray-50">
								<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $loop->iteration }}</td>
								<td class="px-6 py-4 text-sm text-gray-700">{{ $kategori->nama_kategori }}</td>
								<td class="px-6 py-4 text-right text-sm text-gray-500">
									<div class="flex items-center justify-end gap-2">
										<a href="{{ route('kategori.edit', $kategori->id) }}" class="text-amber-500 hover:text-amber-700 font-medium text-sm">Edit</a>
										<form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
											@csrf
											@method('DELETE')
											<button type="submit" class="text-red-500 hover:text-red-700 font-medium text-sm">Hapus</button>
										</form>
									</div>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		@else
			<div class="text-center text-gray-600 py-8">Belum ada kategori</div>
		@endif
	</div>
</div>
@endsection
