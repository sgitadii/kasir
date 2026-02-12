<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Customer;
use App\Models\Produk;
use PDF;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    /**
     * Display a listing of transaksi
     */
    public function index(Request $request) // Tambahkan parameter Request
{
    // Ambil kata kunci pencarian dari input 'search'
    $search = $request->query('search');

    // Query dasar dengan eager loading
    $query = Transaksi::with(['customer', 'produk']);

    // Jika ada kata kunci pencarian, lakukan filter
    if ($search) {
        $query->where(function($q) use ($search) {
            // Cari berdasarkan nama customer
            $q->whereHas('customer', function($customerQuery) use ($search) {
                $customerQuery->where('nama', 'like', "%{$search}%");
            })
            // ATAU cari berdasarkan nama produk
            ->orWhereHas('produk', function($produkQuery) use ($search) {
                $produkQuery->where('nama_produk', 'like', "%{$search}%");
            });
        });
    }

    // Eksekusi query dengan pagination (disarankan) atau get()
    // Saya sarankan gunakan paginate agar tampilan tetap rapi jika data banyak
    $transaksis = $query->latest()->paginate(10)->withQueryString();

    // Hitung statistik (tetap global, tidak terpengaruh search agar data real toko tetap akurat)
    $todayTotal = Transaksi::whereDate('created_at', Carbon::today())->sum('total_harga');
    $now = Carbon::now();
    $monthTotal = Transaksi::whereYear('created_at', $now->year)
        ->whereMonth('created_at', $now->month)
        ->sum('total_harga');

    return view('transaksi.index', compact('transaksis', 'todayTotal', 'monthTotal'));
}

    /**
     * Show the form for creating a new transaksi
     */
    public function create()
    {
        $customers = Customer::all();
        $produks = Produk::all();
        return view('transaksi.create', compact('customers', 'produks'));
    }

    /**
     * Store a newly created transaksi in storage
     */
    public function store(Request $request, Transaksi $transaksi)
{
    $validated = $request->validate([
        'nama_pelanggan'    => 'required|string|max:255',
        'alamat_pelanggan'  => 'nullable|string|max:500',
        'telepon_pelanggan' => 'nullable|string|max:20',
        'nama_produk_id'    => 'required|exists:produks,id',
        'jumlah'            => 'required|integer|min:1',
        'uang_customer'     => 'required|integer|min:0',
    ], [
        'nama_pelanggan.required'  => 'Nama pelanggan harus diisi',
        'nama_produk_id.required'  => 'Pilih produk terlebih dahulu',
        'nama_produk_id.exists'    => 'Produk tidak ditemukan',
        'jumlah.required'          => 'Jumlah harus diisi',
        'jumlah.integer'           => 'Jumlah harus berupa angka',
        'jumlah.min'               => 'Jumlah minimal 1',
        'uang_customer.required'   => 'Uang customer harus diisi',
        'uang_customer.integer'    => 'Uang harus berupa angka',
        'uang_customer.min'        => 'Uang tidak boleh negatif',
    ]);

    $produk = Produk::findOrFail($validated['nama_produk_id']);

    // Validasi stok
    if ($produk->stok < $validated['jumlah']) {
        return back()
            ->withInput()
            ->withErrors(['jumlah' => 'Stok tidak mencukupi. Stok tersedia: ' . $produk->stok]);
    }

    $totalHarga    = $produk->harga * $validated['jumlah'];
    $uangKembalian = $validated['uang_customer'] - $totalHarga;

    // Validasi uang cukup
    if ($uangKembalian < 0) {
        return back()
            ->withInput()
            ->withErrors(['uang_customer' => 'Uang customer kurang dari total harga (Rp ' . number_format($totalHarga, 0, ',', '.') . ')']);
    }

    // Cari atau buat customer
    $customer = Customer::firstOrCreate(
        ['nama' => $validated['nama_pelanggan']],
        [
            'alamat'  => $validated['alamat_pelanggan'] ?? '',
            'telepon' => $validated['telepon_pelanggan'] ?? '',
        ]
    );

    $customer->update([
        'alamat'  => $validated['alamat_pelanggan'] ?? $customer->alamat,
        'telepon' => $validated['telepon_pelanggan'] ?? $customer->telepon,
    ]);

    // Simpan transaksi
    $transaksi = Transaksi::create([
        'kode_transaksi' => 'TRX-0',
        'nama_id'        => $customer->id,
        'nama_produk_id' => $validated['nama_produk_id'],
        'jumlah'         => $validated['jumlah'],
        'total_harga'    => $totalHarga,
        'uang_customer'  => $validated['uang_customer'],
        'uang_kembalian' => $uangKembalian,
    ]);

    // Update kode transaksi setelah ID tersedia
    $transaksi->update(['kode_transaksi' => 'TRX-' . $transaksi->id]);

    // Kurangi stok otomatis
    $produk->decrement('stok', $validated['jumlah']);

    return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan');
}
    /**
     * Display the specified transaksi
     */
    public function show(Transaksi $transaksi)
    {
        return view('transaksi.show', compact('transaksi'));
    }

    /**
     * Show the form for editing the specified transaksi
     */
    public function edit(Transaksi $transaksi)
    {
        $customers = Customer::all();
        $produks = Produk::all();
        return view('transaksi.edit', compact('transaksi', 'customers', 'produks'));
    }

    /**
     * Update the specified transaksi in storage
     */
    public function update(Request $request, Transaksi $transaksi)
{
    $validated = $request->validate([
        'nama_pelanggan'    => 'required|string|max:255',
        'alamat_pelanggan'  => 'nullable|string|max:500',
        'telepon_pelanggan' => 'nullable|string|max:20',
        'nama_produk_id'    => 'required|exists:produks,id',
        'jumlah'            => 'required|integer|min:1',
        'uang_customer'     => 'required|integer|min:0',
    ], [
        'nama_pelanggan.required'  => 'Nama pelanggan harus diisi',
        'nama_produk_id.required'  => 'Pilih produk terlebih dahulu',
        'nama_produk_id.exists'    => 'Produk tidak ditemukan',
        'jumlah.required'          => 'Jumlah harus diisi',
        'jumlah.integer'           => 'Jumlah harus berupa angka',
        'jumlah.min'               => 'Jumlah minimal 1',
        'uang_customer.required'   => 'Uang customer harus diisi',
        'uang_customer.integer'    => 'Uang harus berupa angka',
        'uang_customer.min'        => 'Uang tidak boleh negatif',
    ]);

    $produk = Produk::findOrFail($validated['nama_produk_id']);

    // Validasi stok
    if ($produk->stok < $validated['jumlah']) {
        return back()
            ->withInput()
            ->withErrors(['jumlah' => 'Stok tidak mencukupi. Stok tersedia: ' . $produk->stok]);
    }

    $totalHarga    = $produk->harga * $validated['jumlah'];
    $uangKembalian = $validated['uang_customer'] - $totalHarga;

    // Validasi uang cukup
    if ($uangKembalian < 0) {
        return back()
            ->withInput()
            ->withErrors(['uang_customer' => 'Uang customer kurang dari total harga (Rp ' . number_format($totalHarga, 0, ',', '.') . ')']);
    }

    // Cari atau buat customer
    $customer = Customer::firstOrCreate(
        ['nama' => $validated['nama_pelanggan']],
        [
            'alamat'  => $validated['alamat_pelanggan'] ?? '',
            'telepon' => $validated['telepon_pelanggan'] ?? '',
        ]
    );

    $customer->update([
        'alamat'  => $validated['alamat_pelanggan'] ?? $customer->alamat,
        'telepon' => $validated['telepon_pelanggan'] ?? $customer->telepon,
    ]);

    // Simpan transaksi
    $transaksi = Transaksi::create([
        'kode_transaksi' => 'TRX-0',
        'nama_id'        => $customer->id,
        'nama_produk_id' => $validated['nama_produk_id'],
        'jumlah'         => $validated['jumlah'],
        'total_harga'    => $totalHarga,
        'uang_customer'  => $validated['uang_customer'],
        'uang_kembalian' => $uangKembalian,
    ]);

    // Update kode transaksi setelah ID tersedia
    $transaksi->update(['kode_transaksi' => 'TRX-' . $transaksi->id]);

    // Kurangi stok otomatis
    $produk->decrement('stok', $validated['jumlah']);

    return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan');
}

    /**
     * Remove the specified transaksi from storage
     */
    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus');
    }

    /**
     * Download invoice/struk transaksi sebagai PDF
     */
    public function export(Request $request)
    {
        $transaksis = Transaksi::with(['customer', 'produk'])->latest()->get();

        $filename = 'transaksi-' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($transaksis) {
            $out = fopen('php://output', 'w');
            // Add BOM for Excel compatibility
            fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header row
            fputcsv($out, ['No', 'Kode', 'Tanggal', 'Nama Pelanggan', 'Produk', 'Jumlah', 'Harga Satuan', 'Total Harga', 'Uang Customer', 'Uang Kembalian']);

            foreach ($transaksis as $idx => $t) {
                fputcsv($out, [
                    $idx + 1,
                    $t->kode_transaksi,
                    $t->created_at ? $t->created_at->format('Y-m-d H:i:s') : '',
                    $t->customer->nama ?? '',
                    $t->produk->nama_produk ?? '',
                    $t->jumlah,
                    $t->produk->harga ?? '',
                    $t->total_harga,
                    $t->uang_customer ?? '',
                    $t->uang_kembalian ?? '',
                ]);
            }

            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function downloadInvoice(Transaksi $transaksi)
    {
        // Load relasi customer dan produk
        $transaksi->load(['customer', 'produk']);
        
        // Generate PDF dari view
        $pdf = PDF::loadView('transaksi.invoice', compact('transaksi'));
        
        // Konfigurasi ukuran kertas untuk struk (80mm thermal printer)
        $pdf->setPaper([0, 0, 226.77, 1000], 'portrait'); // 80mm width in points
        
        // Download PDF dengan nama file yang sesuai
        $filename = 'Invoice-' . str_pad($transaksi->id, 6, '0', STR_PAD_LEFT) . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * View invoice transaksi
     */
    public function viewInvoice(Transaksi $transaksi)
    {
        $transaksi->load(['customer', 'produk']);
        return view('transaksi.show-invoice', compact('transaksi'));
    }
}
