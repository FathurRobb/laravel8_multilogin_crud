<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\GudangController;
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
// Route::resource('/', LandingController::class);
// Route::get('clubs', [LandingController::class, 'clubs'])->name('landing.clubs');
// Route::get('players', [LandingController::class, 'players'])->name('landing.players');
// Route::get('managers', [LandingController::class, 'managers'])->name('landing.managers');
// Route::get('stadiums', [LandingController::class, 'stadiums'])->name('landing.stadiums');

Route::get('login', 'App\Http\Controllers\AuthController@index')->name('login');
Route::post('proses_login', 'App\Http\Controllers\AuthController@proses_login')->name('proses_login');
Route::get('logout', 'App\Http\Controllers\AuthController@logout')->name('logout');

Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['cek_login:admin']], function () {
        Route::resource('admin', AdminController::class);
        // Route::resource('admin', AdminController::class);
    });
    Route::group(['middleware' => ['cek_login:kasir']], function () {
        Route::resource('kasir', KasirController::class);
    });
    Route::group(['middleware' => ['cek_login:gudang']], function () {
        Route::get('/gudang', [GudangController::class]);
    });
});