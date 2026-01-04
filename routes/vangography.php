<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EncryptedFileController;
use App\Http\Controllers\VangographyController;
use App\Http\Controllers\VangographyPaymentController;
use App\Http\Controllers\Auth\QuantomLoginController;
use App\Http\Controllers\Auth\QuantomRegisterController;
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

Route::get('/vangonography', [VangographyController::class,'index'])->name('vangography.index');
Route::get('/vangonography/encode', [VangographyController::class,'encodeIndex'])->name('vangography.encode');
Route::get('/vangonography/decode', [VangographyController::class,'decodeIndex'])->name('vangography.decode');
Route::post('/vangonography_encode', [VangographyController::class,'encode'])->name('lsb_encode3channels');
Route::post('/vangonography_decode', [VangographyController::class,'decode'])->name('lsb_decode3channels');
Route::post('/upload-file', [VangographyController::class,'uploadFile'])->name('uploadfile');
Route::get('/vangonography/checkout', [VangographyPaymentController::class,'checkout'])->name('vangography.checkout');
Route::post('/vangonography/process-payment', [VangographyPaymentController::class,'processPayment'])->name('vangography.process.payment');
Route::get('/vangonography/pricing', [VangographyPaymentController::class,'pricing'])->name('vangography.pricing');
Route::get('/vangonography/encryption/download/{id}', [VangographyPaymentController::class,'success'])->name('vangography.payment.success.unauthorized');
Route::middleware(['auth.seed'])->group(function () {
    Route::get('/user/encrypted-files', [EncryptedFileController::class,'index'])->name('user.encrypted.file.index');
    Route::get('/vangonography/file/delete/{encryptedFile}', [EncryptedFileController::class,'destroy'])->name('user.file.destroy');
    Route::get('/vangonography/file/download/{encryptedFile}', [EncryptedFileController::class,'download'])->name('user.file.download');
    Route::get('/vangonography/encryption/success/{id}', [VangographyPaymentController::class,'success'])->name('vangography.payment.success');
    Route::post('/logout', [QuantomLoginController::class, 'logout'])->name('quantom.logout');
});
Route::get('/vangonography/important-note', [QuantomLoginController::class,'importantNote'])->name('vangography.note');
Route::get('/vangonography/login',[QuantomLoginController::class,'showLoginForm'])->name('quantom.login');
Route::post('/vangonography/login',[QuantomLoginController::class,'login'])->name('quantom.user.login');
Route::post('/vangonography/login-or-register',[QuantomLoginController::class,'loginOrRegister'])->name('quantom.user.login.register');
Route::get('/vangonography/get-user-by-token',[QuantomLoginController::class,'getUserByToken'])->name('quantom.user.get');
Route::get('/vangonography/register',[QuantomRegisterController::class,'showRegistrationForm'])->name('quantom.register');
Route::post('/vangonography/register',[QuantomRegisterController::class,'register'])->name('quantom.user.register');