<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProduk = Produk::count();

        $today = Carbon::today();
        $transaksiHariIni = Transaksi::whereDate('created_at', $today)->count();

        $now = Carbon::now();
        $transaksiBulanIni = Transaksi::whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->count();

        return view('dashboard.index', compact('totalProduk', 'transaksiHariIni', 'transaksiBulanIni'));
    }
}
