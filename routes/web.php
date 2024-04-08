<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers;

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

Route::get('/', [Controllers\WebController::class, 'index']);
Route::get('/collect', [Controllers\WebController::class, 'collect']);
Route::post('/save-settings', [Controllers\WebController::class, 'saveSettings'])->name('save-settings');
Route::match(['get', 'post'],'/calculate', [Controllers\WebController::class, 'calculate'])->name('calculate');
Route::get('/coins/list', [Controllers\WebController::class, 'list'])->name('coins-list');
Route::post('/market-ticker', [Controllers\WebController::class, 'marketTicker'])->name('market-ticker');

Route::get('/symbols', [Controllers\WebController::class, 'symbols'])->name('get-symbols');

Route::get('/get/data', [Controllers\WebController::class, 'getData'])->name('get-raw-data');

Auth::routes();
Route::get('/home', [Controllers\HomeController::class, 'index'])->name('home');
