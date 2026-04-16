<?php

namespace App\Http\Controllers;

use App\Models\Stokmasuk;
use App\Models\Supplier;
use App\Models\Produk;
use Illuminate\Http\Request;

class StokmasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stokmasuk = Stokmasuk::with(['produk', 'supplier'])->get();
        $suppliers = Supplier::all();
        $produks = Produk::all();
        return view('stokmasuk', compact('stokmasuk', 'suppliers', 'produks'));
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
            'produk_id' => 'required|exists:produks,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'qty' => 'required|integer',
        ]);
        Stokmasuk::create($validated);
        return redirect()->route('stokmasuk')->with('success', 'Stok masuk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Stokmasuk $stokmasuk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stokmasuk $stokmasuk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        //
    }
}
