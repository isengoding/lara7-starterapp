<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $guarded = [];

    protected $table = 'kategori';

    public function produk()
    {
        return $this->hasMany(Produk::class);
    }
}
