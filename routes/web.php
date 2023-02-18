<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    ProdukController,
    TransaksiController,
    BackgroundController,
    TransController
    };



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
    return view('welcome');
});

Route::get('/produkss', BackgroundController::class);

Auth::routes(['register' => false, 'login' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/halamanLogin', [AuthController::class, 'viewLogin'])->name('view.login');
Route::get('/halamanRegister', [AuthController::class, 'viewRegis'])->name('view.regis');
Route::post('/login', [AuthController::class, 'customLogin'])->name('custom.login');
Route::post('/register', [AuthController::class, 'customRegis'])->name('custom.regis');

Route::get('/produk-all', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/produk-create', [ProdukController::class, 'create'])->name('produk.create');
Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
Route::get('/produk-edit/{id?}', [ProdukController::class, 'edit'])->name('produk.edit');
Route::post('/produk-update/{id?}', [ProdukController::class, 'update'])->name('produk.update');

Route::get('/transaksi-all', [TransaksiController::class, 'index'])->name('trans.index');
Route::get('/transaksi-create', [TransaksiController::class, 'create'])->name('trans.create');
Route::post('/transaksi', [TransaksiController::class, 'store'])->name('trans.store');

Route::get('trans', [TransController::class, 'index'])->name('transaksi.index');
Route::get('trans/create', [TransController::class, 'create'])->name('transaksi.create');
Route::post('trans', [TransController::class, 'store'])->name('transaksi.store');
Route::get('trans/edit/{id}', [TransController::class, 'edit'])->name('transaksi.edit');
Route::post('trans/update/{id}', [TransController::class, 'update'])->name('transaksi.update');
Route::get('trans/delete/{id}', [TransController::class, 'delete'])->name('transaksi.delete');





