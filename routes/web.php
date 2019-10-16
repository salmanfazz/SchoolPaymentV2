<?php

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

Route::get('/login', function () {
    return view('login');
});

//Login Register
Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');

//Dashboard
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

//Siswa
Route::get('/siswa', 'SiswaController@index')->name('siswa');
Route::post('/siswa/add', 'SiswaController@store');
Route::patch('/siswa/update', 'SiswaController@update');
Route::delete('/siswa/{nim}', 'SiswaController@destroy');
Route::get('/siswa/action', 'SiswaController@action')->name('siswa.action');


//Tagihan
Route::get('/tagihan', 'TagihanController@index')->name('tagihan');
Route::get('/tagihan/create', 'TagihanController@create');
Route::post('/tagihan', 'TagihanController@store');
Route::get('/tagihan/{no_tagihan}/edit', 'TagihanController@edit');
Route::patch('/tagihan/{no_tagihan}', 'TagihanController@update');
Route::delete('/tagihan/{no_tagihan}', 'TagihanController@destroy');
Route::get('/tagihan/action', 'TagihanController@action')->name('tagihan.action');

//Data Tagihan
Route::post('/tagihan/add', 'TagihanController@storeData');
Route::patch('/data-tagihan/update', 'TagihanController@updateData');
Route::delete('/data-tagihan/{nilai}', 'TagihanController@destroyData');

//Pembayaran
Route::get('/pembayaran', 'PembayaranController@index')->name('pembayaran');
Route::get('/pembayaran/create', 'PembayaranController@create');
Route::post('/pembayaran', 'PembayaranController@store');
Route::get('/pembayaran/{nim}/edit', 'PembayaranController@edit');
Route::patch('/pembayaran/{nim}', 'PembayaranController@update');
Route::delete('/pembayaran/{nim}', 'PembayaranController@destroy');
Route::get('/pembayaran/action', 'PembayaranController@action')->name('pembayaran.action');

//Data Pembayaran
Route::post('/pembayaran/add', 'PembayaranController@storeData');