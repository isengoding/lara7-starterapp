<?php

namespace App\Http\Controllers;

use PDF;
use App\Produk;
use App\Kategori;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exports\ProdukExport;
use App\Imports\ProdukImport;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Produk\StoreProdukRequest;
use App\Http\Requests\Produk\UpdateProdukRequest;

class ProdukController extends Controller
{
    public $keyword = '';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $produk = Produk::latest()->with('kategori');

        if (!empty($request->keyword)) {
            $this->keyword = $request->keyword;
            
            $produk = $produk->where('nama_produk','like',"%".$this->keyword."%");

            $produk = $produk->orWhereHas('kategori', function ($query) {
                $query->where('nama_kategori', 'like', "%".$this->keyword."%");
            });
            
        }
        
        return view('produk.index')->with('produk', $produk->paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategori = Kategori::all();
        // dd(request()->session()->get('_previous')['url']);
        
        return view('produk.create')->with('kategori', $kategori);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProdukRequest $request)
    {
        $gambar = '';
        if($request->hasFile('gambar')){
            $gambar = $this->uploadGambar($request);
        }else{
            $gambar = "produk_default.jpg";
        }
        // $image = $request->cover->store('cover');

        Produk::create([
            'nama_produk' => $request->nama_produk,
            'kategori_id' => $request->kategori_id,
            'stok' => $request->stok,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambar
        ]);

        session()->flash('success', 'Data Produk Berhasil Ditambahkan');

        return redirect(route('produk.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function show(Produk $produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function edit(Produk $produk)
    {
        $kategori = Kategori::all();
        // dd(request()->session()->get('_previous')['url']);
        
        return view('produk.edit')
                ->with('produk', $produk)
                ->with('kategori', $kategori);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProdukRequest $request, Produk $produk)
    {
        $data = $request->only([
            'nama_produk', 
            'kategori_id', 
            'harga_beli', 
            'harga_jual', 
            'stok', 
            'deskripsi',
        ]);

        if($request->hasFile('gambar')){
            $gambar = $this->uploadGambar($request);

            if($produk->gambar !== "produk_default.jpg"){
                File::delete('img/gambar/'.$produk->gambar);
            }

            $data['gambar'] = $gambar;
        }

        
        $produk->update($data);

        session()->flash('success', "Data Produk : $produk->nama_produk  Berhasil Di ubah");

        //redirect user
        return redirect(route('produk.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produk $produk)
    {
        if($produk->gambar !== "produk_default.jpg"){
            File::delete('img/gambar/'.$produk->gambar);
        }
        
        $produk->delete();

        session()->flash('success', "Data Produk : $produk->nama_produk Berhasil Dihapus");

        return redirect(route('produk.index'));
    }


    /**
     * Cetak data ke PDF.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return PDF
     */
    public function reportPdf(Request $request)
    {
        
        $produk = Produk::all();
        
        $pdf = PDF::setOptions([
            'dpi' => 150, 
            'defaultFont' => 'sans-serif',  
            ])
            ->loadView('produk.report.pdf', [
                'produk' => $produk,
            ]);

        return $pdf->stream();
        
    }


    /**
     * Export data ke Excel.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return excel
     */
    public function export() 
    {
        return (new ProdukExport())->download('laporan-produk.xlsx');
        // return Excel::download(new ProdukExport, 'produk.xlsx');
    }

    /**
     * Import data dari excel ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request) 
    {
        $this->validate($request, [
            'import_produk' => 'required|nullable|mimes:xls,xlsx|max:10'
        ]);

        $file = request()->file('import_produk');
                
        Excel::import(new ProdukImport, request()->file('import_produk'));
        
        session()->flash('success', "Data Produk Berhasil di import");

        //redirect user
        return redirect(route('produk.index'));
    }

    /**
     * Upload gambar produk.
     *
     * @param  mixed  $request
     * @return string $gambar nama file produk
     */
    public function uploadGambar($request)
    {
        $namaFile = Str::slug($request->nama_produk);
        $ext = explode('/', $request->gambar->getClientMimeType())[1];
        $uniq = uniqid();
        $gambar = "$namaFile-$uniq.$ext";
        $request->gambar->move(public_path('img/gambar'), $gambar);

        return $gambar;
    }


}
