<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategory extends Model
{
    protected $fillable = ['nama', 'deskripsi'];

    public function produks()
    {
        return $this->hasMany(Produk::class);
    }
}
