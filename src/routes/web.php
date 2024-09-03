<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\UserPageController;

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

Route::group(['middleware' => ['verified', 'auth']], function () {
    Route::get('/', [IndexController::class, 'index']);
    Route::post('/timestamp', [IndexController::class, 'timestamp']);
    Route::get('/attendance', [AttendanceController::class, 'attendance']);
    Route::post('/attendance', [AttendanceController::class, 'attendance']);
    Route::get('/userpage', [UserPageController::class, 'userpage']);
    Route::post('/userpage', [UserPageController::class, 'userpage']);
});

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
