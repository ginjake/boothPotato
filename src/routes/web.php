<?php
use App\Http\Controllers\TwitterLoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\Auth\LoginController;
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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login/twitter', [TwitterLoginController::class, 'redirectToProvider'])->name('twitter.login');
Route::get('/login/twitter/callback',[TwitterLoginController::class, 'handleProviderCallback']);

Route::group(['prefix'=>'gift'], function () {
    Route::get('create', [GiftController::class, 'create'])->name('gift.create');
    Route::post('store', [GiftController::class, 'store'])->name('gift.store');
    Route::get('edit/{id}', [GiftController::class, 'edit'])->name('gift.edit');
    Route::post('update', [GiftController::class, 'update'])->name('gift.update');
    Route::get('destroy/{id}', [GiftController::class, 'destroy'])->name('gift.destroy');

  });

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
