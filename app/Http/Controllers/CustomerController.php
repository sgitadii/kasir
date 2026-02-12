<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use SweetAlert2\Laravel\Swal;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $customers = Customer::when($search, function ($query, $search) {
            return $query->where('nama', 'like', "%{$search}%")
                ->orWhere('telepon', 'like', "%{$search}%");
        })
            ->latest()
            ->paginate(10); // Gunakan paginate agar tampilan rapi

        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
        ], [
            'nama.required' => 'Nama pelanggan harus diisi',
            'alamat.required' => 'Alamat harus diisi',
            'telepon.required' => 'Telepon harus diisi',
        ]);

        Customer::create($validated);
        Swal::success([
            'title' => 'Berhasil',
            'text' => 'Pelanggan berhasil ditambahkan',
        ]);

        return redirect()->route('customers.index');
    }

    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
        ], [
            'nama.required' => 'Nama pelanggan harus diisi',
            'alamat.required' => 'Alamat harus diisi',
            'telepon.required' => 'Telepon harus diisi',
        ]);

        $customer->update($validated);

        return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil diperbarui');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil dihapus');
    }
}
