<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CabangController;

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

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);

    Route::get('/cabang', [CabangController::class, 'index'])->name('cabang.index');
    Route::get('/cabang/vcreate', [CabangController::class, 'create'])->name('cabang.create');
    Route::post('/cabang/create', [CabangController::class, 'store'])->name('cabang.store');
    Route::get('/cabang/vedit/{id}', [CabangController::class, 'edit'])->name('cabang.edit');
    Route::post('/cabang/edit/{id}', [CabangController::class, 'update'])->name('cabang.update');
    Route::get('/cabang/delete/{id}', [CabangController::class, 'destroy'])->name('cabang.destroy');
});


  