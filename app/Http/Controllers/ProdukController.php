<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produks = Produk::all();
        $kategory = Kategory::all();
        return view('produk', compact('produks', 'kategory'));
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
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategories,id',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        if ($request->hasFile('icon')) {
            Storage::disk('public')->makeDirectory('produk', 0755, true);
            
            $file = $request->file('icon');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('produk', $filename, 'public');
            $validated['icon'] = '/storage/' . $path;
        }

        Produk::create($validated);
        return redirect()->route('produk')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $produk = Produk::findOrFail($id);
        return view('show.produk', compact('produk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $produk = Produk::findOrFail($id);
        $kategories = Kategory::all();
        return view('edit.produk', compact('produk', 'kategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategories,id',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        $produk = Produk::findOrFail($id);

        if ($request->hasFile('icon')) {
            if ($produk->icon && str_starts_with($produk->icon, '/storage/')) {
                $oldPath = str_replace('/storage/', '', $produk->icon);
                Storage::disk('public')->delete($oldPath);
            }

            Storage::disk('public')->makeDirectory('produk', 0755, true);
            
            $file = $request->file('icon');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('produk', $filename, 'public');
            $validated['icon'] = '/storage/' . $path;
        }

        $produk->update($validated);
        return redirect()->route('produk')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produk = Produk::findOrFail($id);
        
        if ($produk->icon && str_starts_with($produk->icon, '/storage/')) {
            $filePath = str_replace('/storage/', '', $produk->icon);
            Storage::disk('public')->delete($filePath);
        }

        $produk->delete();
        return redirect()->route('produk')->with('success', 'Produk berhasil dihapus.');
    }
}
