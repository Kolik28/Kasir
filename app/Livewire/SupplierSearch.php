<?php

namespace App\Livewire;

use App\Models\Supplier;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Search Suppliers')]
class SupplierSearch extends Component
{
    public $search = '';
    public $suppliers = [];

    public function render()
    {
        $this->suppliers = Supplier::where('nama', 'like', '%' . $this->search . '%')
            ->orWhere('alamat', 'like', '%' . $this->search . '%')
            ->orWhere('telepon', 'like', '%' . $this->search . '%')
            ->get();

        return view('livewire.supplier-search', [
            'suppliers' => $this->suppliers,
        ]);
    }

    public function deleteSupplier($id)
    {
        $supplier = Supplier::find($id);
        if ($supplier) {
            $supplier->delete();
            $this->dispatch('supplier-deleted', id: $id);
        }
    }
}
