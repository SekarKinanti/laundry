<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

////////////PETUGAS

Route::post('register', 'PetugasController@register');
Route::post('login', 'PetugasController@login');
Route::put('/ubah_petugas/{id}','PetugasController@update');
Route::delete('/hapus_petugas/{id}','PetugasController@hapus');
Route::get('/tampil_petugas','PetugasController@tampil_petugas');
Route::get('/',function(){
    return Auth::user()->level;
});

/////////////////PELANGGAN

Route::post('/tambah_pelanggan', 'PelangganController@store')->middleware('jwt.verify');
Route::put('/ubah_pelanggan/{id}','PelangganController@update')->middleware('jwt.verify');
Route::delete('/hapus_pelanggan/{id}','PelangganController@hapus')->middleware('jwt.verify');
Route::get('/tampil_pelanggan','PelangganController@tampil_pelanggan')->middleware('jwt.verify');


///////////////////JENIS CUCI

Route::post('/tambah_jenis_cuci', 'JenisCuciController@store')->middleware('jwt.verify');
Route::put('/ubah_jenis_cuci/{id}','JenisCuciController@update')->middleware('jwt.verify');
Route::delete('/hapus_jenis_cuci/{id}','JenisCuciController@hapus')->middleware('jwt.verify');
Route::get('/tampil_jenis_cuci','JenisCuciController@tampil_jenis_cuci')->middleware('jwt.verify');

///////////////////TRANSAKSI

Route::post('/tambah_transaksi', 'TransaksiController@store')->middleware('jwt.verify');
Route::put('/ubah_transaksi/{id}','TransaksiController@update')->middleware('jwt.verify');
Route::delete('/hapus_transaksi/{id}','TransaksiController@hapus')->middleware('jwt.verify');
Route::get('/tampil_transaksi','TransaksiController@tampil')->middleware('jwt.verify');

///////////////////DETAIL TRANSAKSI

Route::post('/tambah_detailtrans', 'DetailTransaksiController@store')->middleware('jwt.verify');
Route::put('/ubah_detailtrans/{id}','DetailTransaksiController@update')->middleware('jwt.verify');
Route::delete('/hapus_detailtrans/{id}','DetailTransaksiController@hapus')->middleware('jwt.verify');
Route::get('/tampil_detailtrans/{tgl_transaksi}/{tgl_jadi}','DetailTransaksiController@tampil')->middleware('jwt.verify');