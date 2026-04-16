<?php

namespace App\Livewire;

use App\Models\Kategory;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Search Categories')]
class KategoriSearch extends Component
{
    public $search = '';
    public $categories = [];

    public function render()
    {
        $this->categories = Kategory::where('nama', 'like', '%' . $this->search . '%')
            ->orWhere('deskripsi', 'like', '%' . $this->search . '%')
            ->get();

        return view('livewire.kategori-search', [
            'categories' => $this->categories,
        ]);
    }

    public function deleteKategori($id)
    {
        $kategori = Kategory::find($id);
        if ($kategori) {
            $kategori->delete();
            $this->dispatch('kategori-deleted', id: $id);
        }
    }
}
