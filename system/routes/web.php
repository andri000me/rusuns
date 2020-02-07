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
    return view('landing');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('Home');

// Role & Permission
Route::group(['prefix' => '/role'], function()
{
  Route::get('/', 'RoleController@index')->name('Role');
  Route::get('/create', 'RoleController@create')->name('Role');
  Route::post('/store', 'RoleController@store')->name('Role.Simpan');
  Route::get('/edit/{id}', 'RoleController@edit')->name('Role');
  Route::post('/update', 'RoleController@update')->name('Role.Update');
  Route::get('/delete/{id}', 'RoleController@delete');
});

// Role & Permission
Route::group(['prefix' => '/permission'], function()
{
  Route::get('/', 'PermissionController@index')->name('Permission');
  Route::post('/create', 'PermissionController@create')->name('Permission');
  Route::post('/update', 'PermissionController@update')->name('Permission.Update');
  Route::get('/delete/{id}', 'PermissionController@delete');
});

Route::group(['prefix' => '/user_role'], function()
{
  Route::get('/', 'UserRole\UserRoleController@index')->name('UserRole');
  Route::post('/create', 'UserRole\UserRoleController@create')->name('UserRole');
  Route::post('/update', 'UserRole\UserRoleController@update')->name('UserRole.Update');
  Route::get('/delete/{id}', 'UserRole\UserRoleController@delete');
});
// User Role
Route::group(['prefix' => '/users'], function()
{
  Route::get('/', 'UserController@index')->name('User');
  Route::post('/create', 'UserController@create')->name('User');
  Route::post('/update', 'UserController@update')->name('User.Update');
  Route::get('/delete/{id}', 'UserController@delete');
});

// Menu Pengaturan
Route::group(['prefix' => '/info_website'], function()
{
  Route::get('/', 'InformasiController@index')->name('Informasi');
  Route::post('/update', 'InformasiController@update')->name('Informasi.Update');
});
 
// ==============================================================================>
// Menu Master
// ==============================================================================>
Route::group(['prefix' => '/rusun'], function()
{
  Route::get('/', 'Master\\RusunController@index')->name('Rusun');
  Route::post('/create', 'Master\\RusunController@create')->name('Rusun');
  Route::post('/update', 'Master\\RusunController@update')->name('Rusun.Update');
  Route::get('/delete/{id}', 'Master\\RusunController@delete');
});

Route::group(['prefix' => '/bulan'], function()
{
  Route::get('/', 'BulanController@index')->name('Bulan');
  Route::post('/create', 'BulanController@create')->name('Bulan');
  Route::post('/update', 'BulanController@update')->name('Bulan.Update');
  Route::get('/delete/{id}', 'BulanController@delete');
});
Route::group(['prefix' => '/tahun'], function()
{
  Route::get('/', 'TahunController@index')->name('Tahun');
  Route::post('/create', 'TahunController@create')->name('Tahun');
  Route::post('/update', 'TahunController@update')->name('Tahun.Update');
  Route::get('/delete/{id}', 'TahunController@delete');
});
Route::group(['prefix' => '/tipe_sewa'], function()
{
  Route::get('/', 'TipeSewaController@index')->name('TipeSewa');
  Route::post('/create', 'TipeSewaController@create')->name('TipeSewa');
  Route::post('/update', 'TipeSewaController@update')->name('TipeSewa.Update');
  Route::get('/delete/{id}', 'TipeSewaController@delete');
});
Route::group(['prefix' => '/unit_sewa'], function()
{
  Route::get('/', 'UnitSewaController@index')->name('UnitSewa');
  Route::post('/create', 'UnitSewaController@create')->name('UnitSewa');
  Route::post('/update', 'UnitSewaController@update')->name('UnitSewa.Update');
  Route::get('/delete/{id}', 'UnitSewaController@delete');
  Route::get('/getKode', 'UnitSewaController@getKode');
});
// ==============================================================================>
// Menu Tramsaksi
// ==============================================================================>
Route::group(['prefix' => '/penyewa'], function()
{
  Route::get('/', 'PenyewaController@index')->name('Penyewa');
  Route::post('/create', 'PenyewaController@create')->name('Penyewa');
  Route::post('/tambah_keluarga', 'PenyewaController@tambah_keluarga')->name('Penyewa');
  Route::post('/update', 'PenyewaController@update')->name('Penyewa.Updates');
  Route::post('/edit_keluarga', 'PenyewaController@edit_keluarga')->name('Penyewa.Update');
  Route::get('/delete/{id}', 'PenyewaController@delete');
  Route::get('/hapus_keluarga/{id}', 'PenyewaController@hapus_keluarga');
});
Route::group(['prefix' => '/cekin'], function()
{
  Route::get('/', 'CekInController@index')->name('CheckIn');
  Route::post('/create', 'CekInController@create')->name('CheckIn');
  Route::post('/tambah_keluarga', 'CekInController@tambah_keluarga')->name('CheckIn');
  Route::post('/update', 'CekInController@update')->name('CheckIn.Update');
  Route::post('/edit_keluarga', 'CekInController@edit_keluarga')->name('CheckIn.Update');
  Route::get('/delete/{id}', 'CekInController@delete');
  Route::get('/hapus_keluarga/{id}', 'CekInController@hapus_keluarga');
  Route::get('/getTipe', 'CekInController@tipe_sewa')->name('CheckIn');
});
Route::group(['prefix' => '/pembayaran'], function()
{
  Route::get('/', 'Transaksi\PembayaranController@index')->name('Pembayaran');
  Route::post('/create', 'Transaksi\PembayaranController@create')->name('Pembayaran.Add');
  Route::get('/tambah/{Bulan_Id}/{Tahun_Id}', 'Transaksi\PembayaranController@tambah')->name('Pembayaran');
  Route::post('/tambah_keluarga', 'Transaksi\PembayaranController@tambah_keluarga')->name('Pembayaran');
  Route::post('/update', 'Transaksi\PembayaranController@update')->name('Pembayaran.Update');
  Route::post('/edit_keluarga', 'Transaksi\PembayaranController@edit_keluarga')->name('Pembayaran.Update');
  Route::get('/delete/{id}', 'Transaksi\PembayaranController@delete');
  Route::get('/hapus_keluarga/{id}', 'Transaksi\PembayaranController@hapus_keluarga');
  Route::get('/getTipe', 'Transaksi\PembayaranController@tipe_sewa')->name('Pembayaran');
});
Route::group(['prefix' => '/tagihan'], function()
{
  Route::get('/', 'Transaksi\TagihanController@index')->name('Tagihan');
  // tagihan Listrik
  Route::get('/stand_listrik', 'Transaksi\TagihanController@stand_listrik')->name('Tagihan');
  Route::post('/stand_listrik_create', 'Transaksi\TagihanController@stand_listrik_create')->name('Stand_Listrik.Create');
  Route::post('/stand_listrik_edit', 'Transaksi\TagihanController@stand_listrik_update')->name('Stand_Listrik.Update');
  Route::get('/getMeter', 'Transaksi\TagihanController@getMeter')->name('Tagihan');
  Route::get('/hitung_listrik', 'Transaksi\TagihanController@cek_listrik')->name('Tagihan');
  Route::post('/hitung_listrik_create', 'Transaksi\TagihanController@hit_listrik')->name('Tagihan');
  // Tagihan Air
  Route::get('/stand_air', 'Transaksi\TagihanController@stand_air')->name('Tagihan');
  Route::post('/stand_air_create', 'Transaksi\TagihanController@stand_air_create')->name('Stand_Air.Create');
  Route::get('/hitung_air', 'Transaksi\TagihanController@cek_air')->name('Tagihan');
  Route::post('/hitung_air_create', 'Transaksi\TagihanController@hit_air')->name('Tagihan');
  Route::post('/stand_air_edit', 'Transaksi\TagihanController@stand_air_update')->name('Stand_Air.Update');
  // Sewa Bulanan
  Route::get('/sewa_bulan', 'Transaksi\TagihanController@sewa_bulan')->name('Tagihan');
  Route::post('/hitung_sewa_bulan', 'Transaksi\TagihanController@hitung_sewa_bulan')->name('Tagihan.Save_Sewa_Bulan');
});

Route::group(['prefix' => '/checkout'], function()
{
  Route::get('/', 'Transaksi\CekOutController@index')->name('CheckOut');
  Route::post('/proses', 'Transaksi\CekOutController@create')->name('CheckOut.Add');
  Route::post('/update', 'CekInController@update')->name('CheckIn.Update');
  Route::post('/edit_keluarga', 'CekInController@edit_keluarga')->name('CheckIn.Update');
  Route::get('/delete/{id}', 'CekInController@delete');
  Route::get('/hapus_keluarga/{id}', 'CekInController@hapus_keluarga');
  Route::get('/getTipe', 'CekInController@tipe_sewa')->name('CheckIn');
});

Route::group(['prefix' => '/cashflow'], function()
{
  Route::get('/', 'Transaksi\CashFlowController@index')->name('CashFlow');
  Route::post('/proses', 'Transaksi\CekOutController@create')->name('CheckOut.Add');
  Route::post('/update', 'CekInController@update')->name('CheckIn.Update');
  Route::post('/edit_keluarga', 'CekInController@edit_keluarga')->name('CheckIn.Update');
  Route::get('/delete/{id}', 'CekInController@delete');
  Route::get('/hapus_keluarga/{id}', 'CekInController@hapus_keluarga');
  Route::get('/getTipe', 'CekInController@tipe_sewa')->name('CheckIn');
});