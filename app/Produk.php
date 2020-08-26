<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $guarded = [];

    protected $table = 'produk';

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

}
