<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Produk;
use App\Kategori;
use Faker\Generator as Faker;

$factory->define(Kategori::class, function (Faker $faker) {
    return [
        'nama_kategori' => $faker->sentence(1),
    ];
});

$factory->define(Produk::class, function (Faker $faker) {
    $harga = rand(10000, 100000);
    return [
        'nama_produk' => $faker->sentence(2),
        'stok' => rand(1,50),
        'harga_beli' => $harga,
        'harga_jual' => $harga + 2000,
        'gambar' => 'produk_default.jpg',
        'deskripsi' => $faker->text(),
    ];
});
