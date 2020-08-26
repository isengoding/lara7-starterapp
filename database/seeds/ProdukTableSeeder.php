<?php

use Illuminate\Database\Seeder;

class ProdukTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create 4 kategori
        factory(App\Kategori::class, 4)->create()->each(function ($kategori) {

            $produk = factory(App\Produk::class, 10)->make();
            $kategori->produk()->saveMany($produk);
            
        });
    }
}
