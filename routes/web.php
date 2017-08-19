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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware'=>'auth'],function(){
    Route::resource('pelanggan','PelangganController');
    ROute::get('pelanggan/{id}/detail','PelangganController@detail');
    Route::get('list-pelanggan','PelangganController@list');
    Route::resource('pemeriksaan','PemeriksaanController');
    Route::get('list-pemeriksaan','PemeriksaanController@list');
    Route::resource('pembayaran','PembayaranController');
    Route::get('list-pembayaran','PembayaranController@list');
    Route::resource('tindakan','TindakanController');
    Route::get('list-agenda-tindakan','TindakanController@list_agenda_tindakan');
    Route::resource('user','UserController');
    Route::resource('daya','DayaController');
    Route::resource('tarif','TarifController');
    Route::resource('pelanggaran','PelanggaranController');
    Route::get('daya-by-tarif/{id}','TarifController@daya');
    Route::get('get-id','PemeriksaanController@get_id_by_type');
    Route::get('top-pelanggan','HomeController@top_pelanggan');

    Route::group(['prefix'=>'report'],function(){
        Route::get('hasil-pemeriksaan','ReportController@hasil_pemeriksaan');
        Route::get('pembayaran','ReportController@pembayaran');
        Route::get('belum-terbayar','ReportController@belum_terbayar');
        Route::get('penyambungan-kembali','ReportController@penyambungan_kembali');
        Route::post('preview-pemeriksaan','ReportController@preview_pemeriksaan');
        Route::post('preview-pembayaran','ReportController@preview_pembayaran');
        Route::post('preview-belum-bayar','ReportController@preview_belum_bayar');
        Route::post('preview-penyambungan-kembali','ReportController@preview_penyambungan_kembali');
    });
});
