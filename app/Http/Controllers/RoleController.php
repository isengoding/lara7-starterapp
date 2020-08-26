<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::latest()->paginate(10);
        // dd($roles->permission()->get());
        return view('roles.index', compact('roles'));
    }

    /**
     * Display a listing searching items.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // menangkap data pencarian
		$keyword = $request->keyword;
        
        // mengambil data dari table product sesuai pencarian data
        $roles = Role::where('name','like',"%".$keyword."%")
                            ->latest()                
                            ->paginate(100);
        // mengirim data product ke view index
        return view('roles.index')->with('roles', $roles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
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
            'role' => 'required|string|max:50'
        ]);
        //select role berdasarkan namanya
        $role = Role::create(['name' => $request->input('role')]);
        
        //fungsi syncPermission akan menghapus semua permissio yg dimiliki role tersebut
        //kemudian di-assign kembali sehingga tidak terjadi duplicate data
        $role->syncPermissions($request->permissions);

        session()->flash('success', "Data Berhasil Disimpan");

        return redirect(route('roles.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        
        if($role->name == 'admin'){
            session()->flash('error', "Data Role : $role->name Tidak Bisa diedit");

            return redirect(route('roles.index'));
        }

        $permissions = Permission::all();
        return view('roles.edit', [
            'permissions' => $permissions,
            'role' => $role,
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $this->validate($request, [
            'role' => 'required|string|max:50'
        ]);

        $role = Role::findOrFail($id);

        if($role->name == 'admin'){
            session()->flash('error', "Data Role : $role->name Tidak Bisa diedit");

            return redirect(route('roles.index'));
        }

        $role->name = $request->input('role');

        $role->update();

        // $role->update($request->input('role'));

        $role->syncPermissions($request->permissions);

        session()->flash('success', "Data Berhasil Dibuah");

        return redirect(route('roles.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        if($role->name == 'admin'){
            session()->flash('error', "Data Role : $role->name Tidak Bisa dihapus");

            return redirect(route('roles.index'));
        }

        $role->delete();

        session()->flash('success', "Data Role : $role->name Berhasil Dihapus");

        return redirect(route('roles.index'));
    }
}
