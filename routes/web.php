<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/index', [App\Http\Controllers\ProductController::class, 'index'])->name('index');
Route::get('/create', [App\Http\Controllers\ProductController::class, 'create'])->name('create');
Route::get('/store', [App\Http\Controllers\ProductController::class, 'store'])->name('store');
Route::get('/show', [App\Http\Controllers\ProductController::class, 'show'])->name('show');
Route::get('/edit', [App\Http\Controllers\ProductController::class, 'edit'])->name('edit');
Route::get('/update', [App\Http\Controllers\ProductController::class, 'update'])->name('update');
Route::get('/destroy', [App\Http\Controllers\ProductController::class, 'destroy'])->name('destroy');
Route::post('/destroy{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('destroy');

//Route::get('/regist',[App\Http\Controllers\ProductController::class, 'showRegistForm'])->name('regist')
//Route::post('/regist',[App\Http\Controllers\ProductController::class, 'registSubmit'])->name('submit');
//Route::get('/serch',[App\Http\Controllers\ProductController::class, 'serch'])->name('serch');