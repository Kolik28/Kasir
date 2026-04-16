<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : Carbon::now()->startOfMonth();
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : Carbon::now();
        
        $transaksi = Transaksi::with('items.produk', 'user')
            ->whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $stats = Transaksi::whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()])
            ->selectRaw('
                COUNT(*) as total_transaksi,
                SUM(total) as total_penjualan,
                AVG(total) as rata_rata_penjualan,
                MIN(total) as penjualan_terendah,
                MAX(total) as penjualan_tertinggi
            ')
            ->first();

        $metodeStats = Transaksi::whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()])
            ->groupBy('metode_pembayaran')
            ->selectRaw('metode_pembayaran, COUNT(*) as jumlah, SUM(total) as total')
            ->get();

        $harian = Transaksi::whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()])
            ->selectRaw('DATE(created_at) as tanggal, COUNT(*) as jumlah_transaksi, SUM(total) as total_penjualan')
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('laporan', [
            'transaksi' => $transaksi,
            'stats' => $stats,
            'metodeStats' => $metodeStats,
            'harian' => $harian,
            'startDate' => $startDate->format('Y-m-d'),
            'endDate' => $endDate->format('Y-m-d'),
        ]);
    }

    /**
     * Print laporan
     */
    public function print(Request $request)
    {
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : Carbon::now()->startOfMonth();
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : Carbon::now();
        
        $transaksi = Transaksi::with('items.produk', 'user')
            ->whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()])
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = Transaksi::whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()])
            ->selectRaw('
                COUNT(*) as total_transaksi,
                SUM(total) as total_penjualan,
                AVG(total) as rata_rata_penjualan
            ')
            ->first();

        return view('print.laporan-print', [
            'transaksi' => $transaksi,
            'stats' => $stats,
            'startDate' => $startDate->format('d-m-Y'),
            'endDate' => $endDate->format('d-m-Y'),
        ]);
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
