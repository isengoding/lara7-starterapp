<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
    return redirect(route('login'));
});

Auth::routes(['register' => false]);

Route::group(['middleware' => 'auth'], function(){
    
    //settings
    Route::group(['middleware' => ['role:admin']], function() {
        Route::resource('setting', 'SettingController');        
    });

    
    
    Route::group(['middleware' => ['permission:manajemen users|manajemen roles']], function() {
        Route::get('/roles/search','RoleController@search')->name('roles.search');
        Route::resource('users', 'UserController');
        Route::resource('roles', 'RoleController');
        // Route::resource('setting', 'SettingController');        
    });

    // Produk
    Route::group(['middleware' => ['permission:manajemen produk']], function() {
        Route::get('/produk/search','ProdukController@search')->name('produk.search');
        Route::get('/produk/pdf','ProdukController@reportPdf')->name('produk.pdf');
        Route::get('/produk/export/', 'ProdukController@export')->name('produk.export');
        Route::post('/produk/import/', 'ProdukController@import')->name('produk.import');
        Route::resource('produk', 'ProdukController');        
    });

    // Kategori
    Route::group(['middleware' => ['permission:manajemen kategori']], function() {         
        Route::resource('kategori', 'KategoriController');         
    });
    
    //profile
    Route::resource('/profile', 'ProfileController');

    Route::get('/home', 'HomeController@index')->name('home');
});

