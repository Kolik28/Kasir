<?php

namespace App\Livewire;

use App\Models\Stokmasuk;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Search Stock In')]
class StokmasukSearch extends Component
{
    public $search = '';
    public $stokmasuk = [];

    public function render()
    {
        $this->stokmasuk = Stokmasuk::with(['produk', 'supplier'])
            ->whereHas('produk', function ($query) {
                $query->where('nama', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('supplier', function ($query) {
                $query->where('nama', 'like', '%' . $this->search . '%');
            })
            ->get();

        return view('livewire.stokmasuk-search', [
            'stokmasuk' => $this->stokmasuk,
        ]);
    }

    public function deleteStokmasuk($id)
    {
       //
    }
}
