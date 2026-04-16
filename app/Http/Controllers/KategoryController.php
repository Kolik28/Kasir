<?php

namespace App\Http\Controllers;

use App\Models\Kategory;
use Illuminate\Http\Request;

class KategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoris = Kategory::all();
        return view('kategori', compact('kategoris'));
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
            'deskripsi' => 'nullable|string',
        ]);
        Kategory::create($validated);
        return redirect()->route('kategori')->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategory $kategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
    {
        $kategori = Kategory::findOrFail($id);
        return view('edit.kategori', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
{
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);
        $kategori = Kategory::findOrFail($id);
        $kategori->update($validated);

    return redirect()->route('kategori')->with('success', 'Kategori berhasil diperbarui.');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        $kategory = Kategory::findOrFail($id);
        $kategory->delete();
        return redirect()->route('kategori')->with('success', 'Kategori berhasil dihapus.');
    }
}
