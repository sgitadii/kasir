<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SweetAlert2\Laravel\Swal;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = DB::table('kategoris')->orderBy('nama_kategori')->get();
        return view('kategori.index', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori',
        ], [
            'nama_kategori.required' => 'Nama kategori harus diisi',
            'nama_kategori.unique' => 'Kategori sudah ada',
        ]);

        DB::table('kategoris')->insert([
            'nama_kategori' => $validated['nama_kategori'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Swal::success([
            'title' => 'Berhasil',
            'text' => 'Kategori berhasil ditambahkan',
        ]);
        return redirect()->route('kategori.index');
    }

    public function edit($id)
    {
        $kategori = DB::table('kategoris')->where('id', $id)->first();
        if (! $kategori) {
            return redirect()->route('kategori.index')->with('error', 'Kategori tidak ditemukan');
        }
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama,' . $id,
        ], [
            'nama_kategori.required' => 'Nama kategori harus diisi',
            'nama_kategori.unique' => 'Kategori sudah ada',
        ]);

        DB::table('kategoris')->where('id', $id)->update([
            'nama' => $validated['nama_kategori'],
            'updated_at' => now(),
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy($id)
    {
        DB::table('kategoris')->where('id', $id)->delete();
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus');
    }
}
