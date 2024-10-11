<?php

use App\Http\Controllers\KategoriController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\AuthController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::pattern('id', '[0-9]+'); //artinya ketika ada parameter {id}, maka harus berupa angka 

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postLogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('register', [AuthController::class, 'register']);
Route::post('register', [AuthController::class, 'store']);

Route::middleware(['auth'])->group(function() { //artinya semua route di dalam group ini harus login dulu 
//memasukkan semua route yang perlu autentikasi di sini.
    Route::get('/', function () {
        return view('welcome');
    });
    
    Route::get('/', [WelcomeController::class, 'index']);
    
    Route::group(['prefix' => 'user'], function() {
        Route::get('/', [UserController::class, 'index']);          //menampilkan halaman awal user
        Route::post('/list', [UserController::class, 'list']);      //menampilkan data user dalam bentuk json untuk databales
        Route::get('/create', [UserController::class, 'create']);   //menampilkan halaman form tambah user 
        Route::post('/', [UserController::class, 'store']);         //menyimpan data user baru
        Route::get('/create_ajax', [UserController::class, 'create_ajax']);         //menampilkan  halaman form tambah user Ajax
        Route::post('/ajax', [UserController::class, 'store_ajax']);         //menyimpan data user baru Ajax
        Route::get('/{id}', [UserController::class, 'show']);       //menampilkan detail user
        Route::get('/{id}/edit', [UserController::class, 'edit']);  //menampilkan halaman form edit user  
        Route::put('/{id}', [UserController::class, 'update']);     //menyimpan perubahan data user 
        Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);     //menampilkan halaman form edit user Ajax
        Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);     //menyimpan perubahan data user Ajax
        Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);     // Untuk tampilkan form confirm delete user Ajax
        Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']);     // Untuk hapus data user ajax
        Route::delete('/{id}', [UserController::class, 'destroy']); //menghapus data user 
    
    });
    
    Route::middleware(['authorize:ADM,MNG'])->group(function () {
        Route::get('/supplier', [SupplierController::class, 'index']);          //menampilkan halaman awal untuk supplier
        Route::post('/supplier/list', [SupplierController::class, 'list']);      //menampilkan data supplier dalam bentuk json untuk databales
        Route::get('/supplier/create', [SupplierController::class, 'create']);   //menampilkan halaman form tambah supplier
        Route::post('/supplier', [SupplierController::class, 'store']);         //menyimpan data supplier baru
        Route::get('/supplier/create_ajax', [SupplierController::class, 'create_ajax']); // Menampilkan halaman form tambah supplier Ajax
        Route::post('/supplier/ajax', [SupplierController::class, 'store_ajax']);     // Menyimpan data supplier baru Ajax
        Route::get('/supplier/{id}', [SupplierController::class, 'show']);       //menampilkan detail supplier
        Route::get('/supplier/{id}/edit', [SupplierController::class, 'edit']);  //menampilkan halaman form edit supplier 
        Route::put('/supplier/{id}', [SupplierController::class, 'update']);     //menyimpan perubahan data supplier 
        Route::get('/supplier/{id}/show_ajax', [SupplierController::class, 'show_ajax']); // Menampilkan halaman detail supplier Ajax
        Route::get('/supplier/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']); // Menampilkan halaman form edit supplier Ajax
        Route::put('/supplier/{id}/update_ajax', [SupplierController::class, 'update_ajax']); // Menyimpan perubahan data supplier Ajax
        Route::get('/supplier/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']); // Untuk menampilkan form supplier delete kategori Ajax
        Route::delete('/supplier/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']); // Untuk menghapus data supplier  Ajax
        Route::delete('/supplier/{id}', [SupplierController::class, 'destroy']); //menghapus data supplier 
    
    });
    
    Route::middleware(['authorize:ADM,CST,STF,KSR'])->group(function () {
        Route::get('/kategori', [KategoriController::class, 'index']);          //menampilkan halaman awal kategori
        Route::post('/kategori/list', [KategoriController::class, 'list']);      //menampilkan data kategori dalam bentuk json untuk databales
        Route::get('/kategori/create', [KategoriController::class, 'create']);   //menampilkan halaman form tambah kategori 
        Route::post('/kategori', [KategoriController::class, 'store']);         //menyimpan data kategori baru
        Route::get('/kategori/create_ajax', [KategoriController::class, 'create_ajax']);  //Menampilkan halaman form tambah kategori ajax
        Route::post('/kategori/ajax', [KategoriController::class, 'store_ajax']);         //menyimpan data kategori baru Ajax
        Route::get('/kategori/{id}', [KategoriController::class, 'show']);       //menampilkan detail kategori
        Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit']);  //menampilkan halaman form edit kategori  
        Route::put('/kategori/{id}', [KategoriController::class, 'update']);     //menyimpan perubahan data kategori 
        Route::get('/kategori/{id}/show_ajax', [KategoriController::class, 'show_ajax']); // Menampilkan halaman detail kategori
        Route::get('/kategori/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']); // Menampilkan halaman form edit kategori Ajax
        Route::put('/kategori/{id}/update_ajax', [KategoriController::class, 'update_ajax']); // Menyimpan perubahan data kategori Ajax
        Route::get('/kategori/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']); // Untuk menampilkan form konfirmasi delete kategori Ajax
        Route::delete('/kategori/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']); // Untuk menghapus data kategori  Ajax
        Route::delete('/kategori/{id}', [KategoriController::class, 'destroy']); //menghapus data kategori 
    
    });
    
    Route::middleware(['authorize:ADM,MNG,STF,KSR'])->group(function () {
        Route::get('/barang', [BarangController::class, 'index']);          //menampilkan halaman awal barang
        Route::post('/barang/list', [BarangController::class, 'list']);      //menampilkan data barang dalam bentuk json untuk databales
        Route::get('/barang/create', [BarangController::class, 'create']);   //menampilkan halaman form tambah barang
        Route::post('/barang', [BarangController::class, 'store']);         //menyimpan data barang baru
        Route::get('/barang/create_ajax', [BarangController::class, 'create_ajax']); // Menampilkan halaman form tambah barang Ajax
        Route::post('/barang/ajax', [BarangController::class, 'store_ajax']);     // Menyimpan data barang baru Ajax
        Route::get('/barang/{id}', [BarangController::class, 'show']);       //menampilkan detail barang
        Route::get('/barang/{id}/edit', [BarangController::class, 'edit']);  //menampilkan halaman form edit barang 
        Route::put('/barang/{id}', [BarangController::class, 'update']);     //menyimpan perubahan data barang 
        Route::get('/barang/{id}/show_ajax', [BarangController::class, 'show_ajax']); // Menampilkan halaman detail supplier Ajax
        Route::get('/barang/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); // Menampilkan halaman form edit barang Ajax
        Route::put('/barang/{id}/update_ajax', [BarangController::class, 'update_ajax']); // Menyimpan perubahan data barang Ajax
        Route::get('/barang/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); // Untuk menampilkan form barang delete barang Ajax
        Route::delete('/barang/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // Untuk menghapus data barang  Ajax
        Route::delete('/barang/{id}', [BarangController::class, 'destroy']); //menghapus data barang 
    
    });
    
    // Route::middleware(['authorize:ADM'])->group(function () {
    //     Route::get('/', [LevelController::class, 'index']);         // menampilkan halaman awal level
    //     Route::post('/list', [LevelController::class, 'list']);     // menampilkan data level dalam bentuk json untuk datatables
    //     Route::get('/create', [LevelController::class, 'create']);  // menampilkan halaman form tambah level
    //     Route::post('/', [LevelController::class, 'store']);        // menyimpan data level baru
    //     Route::get('/create_ajax', [LevelController::class, 'create_ajax']); // Menampilkan halaman form tambah user Ajax
    //     Route::post('/ajax', [LevelController::class, 'store_ajax']);     // Menyimpan data user baru Ajax
    //     Route::get('/{id}', [LevelController::class, 'show']);      // menampilkan detail level
    //     Route::get('/{id}/edit', [LevelController::class, 'edit']); // menampilkan halaman form edit level
    //     Route::put('/{id}', [LevelController::class, 'update']);    // menyimpan perubahan data level
    //     Route::get('/{id}/show_ajax', [LevelController::class, 'show_ajax']); // Menampilkan halaman detail level
    //     Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']); // Menampilkan halaman form edit level Ajax
    //     Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']); // Menyimpan perubahan data level Ajax
    //     Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']); // Untuk menampilkan form konfirmasi delete level Ajax
    //     Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']); // Untuk menghapus data level Ajax
    //     Route::delete('/{id}', [LevelController::class, 'destroy']); // menghapus data level
    // });

    Route::middleware(['authorize:ADM'])->group(function () {
        Route::get('/level', [LevelController::class, 'index']);         // menampilkan halaman awal level
        Route::post('/level/list', [LevelController::class, 'list']);     // menampilkan data level dalam bentuk json untuk datatables
        Route::get('/level/create', [LevelController::class, 'create']);  // menampilkan halaman form tambah level
        Route::post('/level', [LevelController::class, 'store']);        // menyimpan data level baru
        Route::get('/level/create_ajax', [LevelController::class, 'create_ajax']); // Menampilkan halaman form tambah user Ajax
        Route::post('/level/ajax', [LevelController::class, 'store_ajax']);     // Menyimpan data user baru Ajax
        Route::get('/level/{id}', [LevelController::class, 'show']);      // menampilkan detail level
        Route::get('/level/{id}/edit', [LevelController::class, 'edit']); // menampilkan halaman form edit level
        Route::put('/level/{id}', [LevelController::class, 'update']);    // menyimpan perubahan data level
        Route::get('/level/{id}/show_ajax', [LevelController::class, 'show_ajax']); // Menampilkan halaman detail level
        Route::get('/level/{id}/edit_ajax', [LevelController::class, 'edit_ajax']); // Menampilkan halaman form edit level Ajax
        Route::put('/level/{id}/update_ajax', [LevelController::class, 'update_ajax']); // Menyimpan perubahan data level Ajax
        Route::get('/level/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']); // Untuk menampilkan form konfirmasi delete level Ajax
        Route::delete('/level/{id}/delete_ajax', [LevelController::class, 'delete_ajax']); // Untuk menghapus data level Ajax
        Route::delete('/level/{id}', [LevelController::class, 'destroy']); // menghapus data level
    });
});

