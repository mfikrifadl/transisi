<?php

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

Route::get('/php_dasar/soal_1', 'PhpDasarController@soal_1');
Route::get('/php_dasar/soal_2', 'PhpDasarController@soal_2');
Route::get('/php_dasar/soal_3', 'PhpDasarController@soal_3');
Route::get('/php_dasar/soal_5', 'PhpDasarController@soal_5');
Route::get('/php_dasar/soal_6', 'PhpDasarController@soal_6');

Auth::routes(['except' => ['register']]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
