<?php

namespace App\Http\Controllers;

use App\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $kategori = Kategori::latest();

        if (!empty($request->keyword)) {
            $kategori = $kategori->where('nama_kategori','like',"%".$request->keyword."%");
        }
        
        return view('kategori.index')->with('kategori', $kategori->paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {           
        return view('kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_kategori' => 'required|string|max:100'
        ]);

        $kategori = Kategori::create(['nama_kategori' => $request->nama_kategori]);

        session()->flash('success', "Data Berhasil Disimpan");

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function show(Kategori $kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function edit(Kategori $kategori)
    {
        return view('kategori.edit')->with('kategori', $kategori);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kategori $kategori)
    {
        $this->validate($request, [
            'nama_kategori' => 'required|string|max:100'
        ]);

        $kategori->nama_kategori = $request->nama_kategori;

        $kategori->update();

        session()->flash('success', "Data Berhasil Diupdate");

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kategori $kategori)
    {
        if($kategori->produk->count() > 0){
            session()->flash('error', "Kategori : $kategori->nama_kategori tidak bisa dihapus karena Total Produk Lebih Dari 0");
        }else{
            $kategori->delete();
            session()->flash('success', "Kategori : $kategori->nama_kategori Berhasil Dihapus");
        }

        return redirect(route('kategori.index'));
    }
}
