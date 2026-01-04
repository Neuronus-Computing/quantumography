<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TextPassController;
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
Route::prefix('/txt-pass')->name('txt.pass.')->group(function () {
    Route::get('/', [TextPassController::class, 'index'])->name('index');
    Route::get('/txt-create', [TextPassController::class, 'create'])->name('create');
    Route::get('/txt-success/{id}', [TextPassController::class, 'success'])->name('success');
    Route::get('/txt-delete/{id}', [TextPassController::class, 'destroy'])->name('delete');
    Route::get('{textPass}/show', [TextPassController::class, 'show'])->name('show');
    Route::post('/txt-save', [TextPassController::class, 'store'])->name('store');
    Route::post('/verify-password', [TextPassController::class, 'verifyPassword'])->name('verify.password');
    Route::get('/get-text-pass/{id}', [TextPassController::class, 'getText'])->name('get.text');
});
Route::get('{shortCode}/txt', function ($shortCode) {
    return redirect()->to('/txt-pass/'.base64_decode($shortCode).'/show');
});
