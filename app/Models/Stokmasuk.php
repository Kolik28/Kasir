<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stokmasuk extends Model
{
    protected $fillable = ['produk_id', 'supplier_id', 'qty'];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
