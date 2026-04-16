<?php

namespace App\Observers;

use App\Models\Stokmasuk;

class StokMasukObserver
{
    /**
     * Handle the Stokmasuk "created" event.
     */
    public function created(Stokmasuk $stokmasuk): void
    {
        $produk = $stokmasuk->produk;
        $produk->stok += $stokmasuk->qty;
        $produk->save();
    }

    /**
     * Handle the Stokmasuk "updated" event.
     */
    public function updated(Stokmasuk $stokmasuk): void
    {
        //
    }

    /**
     * Handle the Stokmasuk "deleted" event.
     */
    public function deleted(Stokmasuk $stokmasuk): void
    {
        //
    }

    /**
     * Handle the Stokmasuk "restored" event.
     */
    public function restored(Stokmasuk $stokmasuk): void
    {
        //
    }

    /**
     * Handle the Stokmasuk "force deleted" event.
     */
    public function forceDeleted(Stokmasuk $stokmasuk): void
    {
        //
    }
}
