<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FuzzyController;

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

// Route untuk Fuzzy Controller (Halaman Utama)
Route::get('/', [FuzzyController::class, 'index'])->name('fuzzy.index');
Route::post('/', [FuzzyController::class, 'calculate'])->name('fuzzy.calculate');
