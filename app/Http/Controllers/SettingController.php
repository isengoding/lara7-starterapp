<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Setting::get()->first();
        return view('setting.index',['setting' => $setting]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'name' => 'required|string|max:100',
        //     'email' => 'required|email|unique:users',
        //     'password' => 'required|confirmed|min:6',
        //     'role' => 'required'
        // ]);

        return "tes";

        $logo = '';
        $favicon = '';

        if($request->hasFile('logo')){
            $logo = $request->logo->store('logo');
        }

        if($request->hasFile('favicon')){
            // $favicon = $request->favicon->store('favicon');
            $file = $request->favicon;
            dd($file);
            $file->storeAs('/uploads',$file->getClientOriginalName());
        }

        $setting = Setting::Update([
            'app_name' => $request->name,
            'logo' => $logo,
            'favicon' => $favicon,
            'footer_right' => $request->footer_right,
            'footer_left' => $request->footer_left,
        ]);

        return view('setting.index') ;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        $this->validate($request, [
            'app_name' => 'required|string|max:15',
            'footer_left' => 'required|string|max:100',
            'footer_right' => 'required|string|max:50',
            'logo' => 'nullable|image|mimes:jpg,png,jpeg|max:2000',
            'favicon' => 'nullable|mimes:ico|max:1000',            
        ]);

        $data = $request->only(['app_name', 'footer_left', 'footer_right']);

        if($request->hasFile('logo')){
            // $logo = $request->logo->store('logo');
            $logo = $this->uploadGambar($request->logo);

            if($setting->logo !== "logo_default.jpg"){
                File::delete('img/'.$setting->logo);
            }

            $data['logo'] = $logo;
        }

        if($request->hasFile('favicon')){
            $favicon = $this->uploadGambar($request->favicon);

            if($setting->favicon !== "favicon_default.ico"){
                File::delete('img/'.$setting->favicon);
            }

            $data['favicon'] = $favicon;
        }

        
        $setting->update($data);

        session()->flash('success', "Setting Updated!!");

        //redirect user
        return redirect(route('setting.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }

    /**
     * Upload gambar.
     *
     * @param  mixed  $request
     * @return string $gambar nama file
     */
    public function uploadGambar($gambar)
    {

        $gambar->move(public_path('img/'), $gambar->getClientOriginalName());

        return $gambar->getClientOriginalName();
    }
}
