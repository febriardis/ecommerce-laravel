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

use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    Session::flash('welcome', 'welcomee');
    return view('welcome')->with('welcome', 'welcomee');
});

Route::get('/products', 'Product\ProductController@index')->name('products');

Route::get('/search', 'Product\ProductController@search')->name('search');

Route::get('/products/{filter}', 'Product\ProductController@indexcat')->name('products');
Route::get('/products terbaru', 'Product\ProductController@indexterbaru')->name('products');
Route::get('/products terlaris', 'Product\ProductController@indexterlaris')->name('products');
Route::get('/product/{id}', 'Product\ProductController@detail')->name('product');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/cek_kabupaten', 'HomeController@cekKabupaten')->name('cek_kabupaten');
Route::get('/cek_ongkir', 'HomeController@cekOngkir')->name('cek_ongkir');
Route::get('/cek_city', 'HomeController@cekCity')->name('cek_city');

Route::get('/panduan', function () {
    return view('panduan');
});
Route::get('/kontak', function () {
    return view('kontak');
});

Route::get('/admin/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('/admin/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');

Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function()
{
    Route::get('/', 'Admin\AdminController@index')->name('admin');
    Route::get('/settings account', 'Admin\AdminController@setting')->name('admin.setting');
    Route::put('/settings account/{id}', 'Admin\AdminController@update')->name('admin.update');
    Route::get('/dashboard', 'Admin\AdminController@index')->name('admin.home');
    Route::get('/tabel kategori', 'Category\CategoryController@index')->name('category.index');
    Route::post('/category', 'Category\CategoryController@create')->name('category.create');
    Route::put('/category/{id}', 'Category\CategoryController@update')->name('category.update');
    Route::delete('/category/{id}', 'Category\CategoryController@delete')->name('category.delete');

    Route::get('/tabel barang', 'Product\ProductController@indexadmin')->name('product.index');
    Route::get('/tambah barang', 'Product\ProductController@new')->name('product.new');
    Route::post('/product', 'Product\ProductController@create')->name('product.create');
    Route::get('/edit barang/{id}', 'Product\ProductController@edit')->name('product.edit');
    Route::post('/product update/{id}', 'Product\ProductController@update')->name('product.update');
    Route::delete('/product/{id}', 'Product\ProductController@delete')->name('product.delete');

    Route::get('/tabel pesanan/{status}', 'Admin\AdminController@order')->name('admin.order');
    Route::put('/batal pesanan/{code}', 'Pesanan\PesananController@cancelPesanan')->name('pesanan.batal');
    Route::put('/tolak pesanan/{code}', 'Pesanan\PesananController@tolakBukti')->name('pesanan.tolak');
    Route::put('/verif pesanan/{code}', 'Pesanan\PesananController@verifBukti')->name('pesanan.verif');
    Route::put('/dikirim pesanan/{code}', 'Pesanan\PesananController@dikirimPesanan')->name('pesanan.dikirim');
    Route::put('/terkirim pesanan/{code}', 'Pesanan\PesananController@terkirimPesanan')->name('pesanan.terkirim');
    Route::get('/invoice pesanan/{code}', 'Pesanan\PesananController@invoicePesanan')->name('pesanan.invoice');
    
    Route::get('/tabel pelanggan', 'Admin\AdminController@pelanggan')->name('admin.pelanggan');
    Route::delete('/pelanggan/{id}', 'Admin\AdminController@deletePelanggan')->name('admin.hapususer');
    Route::get('/tabel penilaian', 'Admin\AdminController@penilaian')->name('admin.penilaian');
    Route::get('/tabel penjualan', 'Admin\AdminController@penjualan')->name('admin.penjualan');
    
    Route::get('/tabel rekening', 'Rekening\RekeningController@index')->name('rekening.index');
    Route::post('/rekening', 'Rekening\RekeningController@create')->name('rekening.create');
    Route::put('/rekening/{id}', 'Rekening\RekeningController@update')->name('rekening.update');
    Route::delete('/rekening/{id}', 'Rekening\RekeningController@delete')->name('rekening.delete');
});

Route::group(['middleware' => ['verified']], function () {
    Route::get('/account settings', function(){
        return view('auth.settings');
    })->name('akun.setting');

    Route::put('/account settings/{id}', 'User\UserController@update')->name('user.update');

    Route::get('/carts', 'Cart\CartController@index')->name('carts');
    Route::post('/cart', 'Cart\CartController@create')->name('cart.create');
    Route::put('/cart', 'Cart\CartController@update')->name('cart.update');
    Route::delete('/cart/{id}', 'Cart\CartController@delete')->name('cart.delete');

    Route::get('/checkout', 'Order\OrderController@index')->name('order');
    Route::post('/checkout', 'Order\OrderController@create')->name('order.create');

    Route::post('/address', 'Address\AddressController@create')->name('address.create');
    Route::get('/edit address/{id}', 'Address\AddressController@edit')->name('address.edit');
    Route::put('/address/{id}', 'Address\AddressController@update')->name('address.update');
    Route::delete('/address delete/{id}', 'Address\AddressController@delete')->name('address.delete');

    Route::get('/pembayaran/{code}', 'Order\OrderController@pembayaran')->name('pembayaran');
    Route::post('/buy now', 'Cart\CartController@buyNow')->name('cart.buyNow');
    Route::get('/transaction/{code}', 'Transaction\TransactionController@index')->name('transaction');
    Route::post('/transaction/{code}', 'Transaction\TransactionController@create')->name('transaction.create');

    Route::get('/belanjaanku', 'Belanjaan\BelanjaanController@index')->name('belanjaanku');
    Route::put('/cancel pesanan/{code}', 'Pesanan\PesananController@cancelPesanan')->name('pesanan.cancel');
    Route::put('/pesanan diterima/{code}', 'Pesanan\PesananController@terkirimPesanan')->name('pesanan.diterima');

    Route::post('/rating', 'Product\RatingController@create')->name('rating.create');
    Route::put('/rating/{id}', 'Product\RatingController@update')->name('rating.update');
});


// ===============================ROUTE ADMIN====================================


// Route::prefix('admin')->group(function(){
//     Route::get('tabel pesanan', function(){
//         return view('views_admin.pesanan_tabel');
//     });

//     Route::get('tabel pelanggan', function(){
//         return view('views_admin.pelanggan_tabel');
//     });

//     Route::get('tabel penjualan', function(){
//         return view('views_admin.penjualan_tabel');
//     });

//     Route::get('tabel penilaian', function(){
//         return view('views_admin.penilaian_tabel');
//     });

//     // Route::get('/tabel kategori', 'Category\CategoryController@index')->name('category.index');
//     // Route::post('/category', 'Category\CategoryController@create')->name('category.create');
//     // Route::put('/category/{id}', 'Category\CategoryController@update')->name('category.update');
//     // Route::delete('/category/{id}', 'Category\CategoryController@delete')->name('category.delete');

//     Route::get('tabel barang', 'Product\ProductController@indexadmin')->name('product.index');
//     Route::get('/tambah barang', 'Product\ProductController@new')->name('product.new');
//     Route::post('/product', 'Product\ProductController@create')->name('product.create');
//     Route::delete('/product/{id}', 'Product\ProductController@delete')->name('product.delete');

//     Route::get('edit barang', function(){
//         return view('views_admin.barang_edit');
//     });

// });