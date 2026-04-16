<?php

namespace App\Livewire;

use App\Models\Produk;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Search Products')]
class ProdukSearch extends Component
{
    public $search = '';
    public $products = [];

    public function render()
    {
        $this->products = Produk::with('kategory')
            ->where(function ($query) {
                $query->where('nama', 'like', '%' . $this->search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $this->search . '%');
            })
            ->get();

        return view('livewire.produk-search', [
            'products' => $this->products
        ]);
    }

    public function deleteProduk($id)
    {
        $produk = Produk::find($id);
        if ($produk) {
            $produk->delete();
            $filePath = str_replace('/storage/', '', $produk->icon);
            Storage::disk('public')->delete($filePath);
            $this->dispatch('produk-deleted', id: $id);
        }
    }
}
