<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produks = Produk::all();
        $namaproduk = $produks->pluck('nama');
        $stok = $produks->pluck('stok');
        
        $totalProduk = Produk::count();
        $totalStok = Produk::sum('stok');
        
        $transaksiHariIni = Transaksi::whereDate('created_at', today())->count();
        $pendapatanHariIni = Transaksi::whereDate('created_at', today())->sum('total') ?? 0;
        
        $produkStokRendah = Produk::where('stok', '<', 10)->count();
        
        $transaksiTerbaru = Transaksi::with('user', 'items.produk')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        $produkTerlaris = Produk::withSum('transaksiItems', 'qty')
            ->orderBy('transaksi_items_sum_qty', 'desc')
            ->take(5)
            ->get();
        
        return view('dashboard', compact(
            'namaproduk', 
            'stok', 
            'totalProduk', 
            'totalStok', 
            'transaksiHariIni', 
            'pendapatanHariIni',
            'produkStokRendah',
            'transaksiTerbaru',
            'produkTerlaris'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
