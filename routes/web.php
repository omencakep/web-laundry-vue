<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\authController;
use App\Http\Controllers\outletController;
use App\Http\Controllers\paketController;
use App\Http\Controllers\memberController;
use App\Http\Controllers\transaksiController;
use App\Http\Controllers\detailController;
use App\Http\Controllers\dashboardController;


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

// Route::get('/', function (){
//     return view('home');
// });
Route::get('/{any}', [HomeController::class,'index'])->where('any','.*');