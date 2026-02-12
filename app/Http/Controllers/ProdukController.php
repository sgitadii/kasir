<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SweetAlert2\Laravel\Swal;

class ProdukController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->query('search');

        $produks = Produk::when($search, function ($query, $search) {
            return $query->where('nama_produk', 'like', "%{$search}%")
                ->orWhere('kategori', 'like', "%{$search}%");
        })
            ->latest()
            ->paginate(10);

        return view('produk.index', compact('produks'));
    }


    public function create()
    {
        $kategoris = DB::table('kategoris')->orderBy('nama_kategori')->get();
        return view('produk.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255|unique:produks,nama_produk',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'kategori' => 'required|string|max:255',
        ], [
            'nama_produk.required' => 'Nama produk harus diisi',
            'nama_produk.unique' => 'Nama produk sudah ada',
            'harga.required' => 'Harga harus diisi',
            'harga.numeric' => 'Harga harus berupa angka',
            'harga.min' => 'Harga tidak boleh negatif',
            'stok.required' => 'Stok harus diisi',
            'stok.integer' => 'Stok harus berupa angka bulat',
            'stok.min' => 'Stok tidak boleh negatif',
            'kategori.required' => 'Kategori harus diisi',
        ]);

        $validated['kode_produk'] = 'PRO-0';
        $produks = Produk::create($validated);
        $produks->update([
            'kode_produk' => 'PRO-' . $produks->id,
        ]);

        Swal::success([
            'title' => 'Berhasil',
            'text' => 'Produk berhasil ditambahkan',

        ]);

        return redirect()->route('produk.index');
    }

    public function show(Produk $produk)
    {
        return view('produk.show', compact('produk'));
    }

    public function edit(Produk $produk)
    {
        $kategoris = DB::table('kategoris')->orderBy('nama')->get();
        return view('produk.edit', compact('produk', 'kategoris'));
    }

    public function update(Request $request, Produk $produk)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255|unique:produks,nama_produk,' . $produk->id,
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'kategori' => 'required|string|max:255',
        ], [
            'nama_produk.required' => 'Nama produk harus diisi',
            'nama_produk.unique' => 'Nama produk sudah ada',
            'harga.required' => 'Harga harus diisi',
            'harga.numeric' => 'Harga harus berupa angka',
            'harga.min' => 'Harga tidak boleh negatif',
            'stok.required' => 'Stok harus diisi',
            'stok.integer' => 'Stok harus berupa angka bulat',
            'stok.min' => 'Stok tidak boleh negatif',
            'kategori.required' => 'Kategori harus diisi',
        ]);

        $produk->update($validated);

        return redirect()->route('produk.index');
    }

    public function destroy(Produk $produk)
    {
        $produk->delete();
        Swal::success([
            'title' => 'Berhasil',
            'text' => 'Produk berhasil dihapus',
        ]);
        return redirect()->route('produk.index');
    }
}
