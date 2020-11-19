<?php

namespace App\Imports;

use App\Produk;
use App\Kategori;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
// use Maatwebsite\Excel\Concerns\WithBatchInserts;
// use Maatwebsite\Excel\Concerns\WithLimit;


class ProdukImport implements ToModel, WithHeadingRow
{
    // private $rows = 0;
    // public $limit = 12;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // ++$this->rows;
        // dd($row);
        // dd($row);
        $kategori = Kategori::where('nama_kategori', '=', $row['kategori'])->get()->first();
        
        if(empty($kategori)){
            
            $kategori = Kategori::create([
                'nama_kategori' => $row['kategori']
            ]);
            // dd($kategori);
        }        

        $produk = new Produk([
            'nama_produk' => $row['nama_produk'],
            'stok' => $row['stok'],
            'kategori_id' => $kategori->id,
            'harga_beli' => $row['harga_beli'],
            'harga_jual' => $row['harga_jual'],
            'deskripsi' => $row['deskripsi'],
            'gambar' => 'produk_default.jpg',
        ]);

        return $produk;
    }

    // public function limit(): int
    // {
    //     return $this->limit;
    // }

}
