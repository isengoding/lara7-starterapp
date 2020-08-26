<?php

namespace App\Http\Requests\Produk;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProdukRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nama_produk' => 'required|string|max:100',
            'kategori_id' => 'required|exists:kategori,id',
            'harga_beli' => 'required|integer|min:1',
            'harga_jual' => 'required|integer|min:1',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable',
            'gambar' => 'nullable|image|mimes:jpg,png,jpeg|max:2000'
        ];
    }
}
