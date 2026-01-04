<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilePassController;
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
Route::prefix('/file-pass')->name('file.pass.')->group(function(){
    Route::get('/',[FilePassController::class,'index'])->name('index');
    Route::post('/save',[FilePassController::class,'store'])->name('store');
    Route::get('/checkout',[FilePassController::class,'checkout'])->name('checkout');
    Route::get('/success/{orderNumber}',[FilePassController::class,'success'])->name('success');
    Route::get('{ordernumber}/show', [FilePassController::class, 'show'])->name('show');
    Route::get('/get-file/{ordernumber}', [FilePassController::class, 'getFiles'])->name('get.file');
    Route::get('/get-uploaded-files', [FilePassController::class, 'getUploadedFiles'])->name('get.uploaded.files');
    Route::post('/verify-password', [FilePassController::class, 'verifyPassword'])->name('verify.password');
    Route::post('/temp-upload', [FilePassController::class, 'storeFile'])->name('store.file');
    Route::post('/temp-file-remove', [FilePassController::class, 'removeFile'])->name('remove.file');
    Route::post('/process-payment', [FilePassController::class, 'processPayment'])->name('process.payment');
});
Route::get('file/{shortCode}', function ($shortCode) {
    return redirect()->to('/file-pass/'.base64_decode($shortCode).'/show');
});