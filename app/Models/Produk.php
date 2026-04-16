<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $fillable = ['nama', 'kategori_id', 'harga', 'stok', 'icon', 'deskripsi'];

    public function kategory()
    {
        return $this->belongsTo(Kategory::class, 'kategori_id');
    }

    public function transaksiItems()
    {
        return $this->hasMany(TransaksiItem::class);
    }
}
