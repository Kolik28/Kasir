<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategory;
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produks = Produk::with('kategory')->get();
        $kategoris = Kategory::all();
        
        return view('transaksi', [
            'produks' => $produks,
            'kategoris' => $kategoris
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
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.produk_id' => 'required|exists:produks,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.harga_satuan' => 'required|integer',
            'subtotal' => 'required|integer',
            'pajak' => 'required|integer',
            'diskon' => 'required|integer',
            'total' => 'required|integer',
            'metode_pembayaran' => 'required|in:tunai,qris,debit,kredit'
        ]);

        $transaksi = Transaksi::create([
            'user_id' => Auth::id(),
            'subtotal' => $validated['subtotal'],
            'pajak' => $validated['pajak'],
            'diskon' => $validated['diskon'],
            'total' => $validated['total'],
            'metode_pembayaran' => $validated['metode_pembayaran'],
            'status' => 'selesai'
        ]);

        foreach ($validated['items'] as $item) {
            TransaksiItem::create([
                'transaksi_id' => $transaksi->id,
                'produk_id' => $item['produk_id'],
                'qty' => $item['qty'],
                'harga_satuan' => $item['harga_satuan'],
                'subtotal' => $item['qty'] * $item['harga_satuan']
            ]);

            $produk = Produk::find($item['produk_id']);
            $produk->decrement('stok', $item['qty']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil disimpan',
            'transaksi_id' => $transaksi->id
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaksi = Transaksi::with('user', 'items.produk')->findOrFail($id);
        return view('show.transaksi-detail', [
            'transaksi' => $transaksi
        ]);
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

    public function history(Request $request)
    {
        $query = Transaksi::with('user');

        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }

        if ($request->filled('kasir')) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%' . request('kasir') . '%');
            });
        }

        if ($request->filled('dari_tanggal')) {
            $query->whereDate('created_at', '>=', $request->dari_tanggal);
        }
        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('created_at', '<=', $request->sampai_tanggal);
        }

        $transaksis = $query->latest()->paginate(15)->appends($request->query());
        
        return view('hstransaksi', [
            'transaksis' => $transaksis,
            'search' => $request->all()
        ]);
    }

    /**
     * Print receipt for a transaction
     */
    public function printReceipt(string $id)
    {
        $transaksi = Transaksi::with('user', 'items.produk')->findOrFail($id);
        return view('print.struk', [
            'transaksi' => $transaksi
        ]);
    }
}
