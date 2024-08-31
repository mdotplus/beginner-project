<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;

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

Route::middleware('auth')->group(function () {
    Route::get('/', [IndexController::class, 'index']);
    Route::post('/timestamp', [IndexController::class, 'timestamp']);
    Route::get('/attendance', [IndexController::class, 'attendance']);
    Route::post('/attendance', [IndexController::class, 'attendance']);
});
