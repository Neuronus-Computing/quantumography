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

Route::get('/', [VangographyController::class,'index'])->name('index');
Route::get('/quantumography/encode', [VangographyController::class,'encodeIndex'])->name('quantumography.encode');
Route::get('/quantumography/decode', [VangographyController::class,'decodeIndex'])->name('quantumography.decode');
Route::post('/quantumography_encode', [VangographyController::class,'encode'])->name('lsb_encode3channels');
Route::post('/quantumography_decode', [VangographyController::class,'decode'])->name('lsb_decode3channels');
Route::post('/upload-file', [VangographyController::class,'uploadFile'])->name('uploadfile');
Route::get('/quantumography/checkout', [VangographyPaymentController::class,'checkout'])->name('quantumography.checkout');
Route::post('/quantumography/process-payment', [VangographyPaymentController::class,'processPayment'])->name('quantumography.process.payment');
Route::get('/quantumography/pricing', [VangographyPaymentController::class,'pricing'])->name('quantumography.pricing');
Route::get('/quantumography/encryption/download/{id}', [VangographyPaymentController::class,'success'])->name('quantumography.payment.success.unauthorized');
Route::middleware(['auth.seed'])->group(function () {
    Route::get('/user/encrypted-files', [EncryptedFileController::class,'index'])->name('user.encrypted.file.index');
    Route::get('/quantumography/file/delete/{encryptedFile}', [EncryptedFileController::class,'destroy'])->name('user.file.destroy');
    Route::get('/quantumography/file/download/{encryptedFile}', [EncryptedFileController::class,'download'])->name('user.file.download');
    Route::get('/quantumography/encryption/success/{id}', [VangographyPaymentController::class,'success'])->name('quantumography.payment.success');
    Route::post('/logout', [QuantomLoginController::class, 'logout'])->name('quantom.logout');
});
Route::get('/quantumography/important-note', [QuantomLoginController::class,'importantNote'])->name('quantumography.note');
Route::get('/quantumography/login',[QuantomLoginController::class,'showLoginForm'])->name('quantom.login');
Route::post('/quantumography/login',[QuantomLoginController::class,'login'])->name('quantom.user.login');
Route::post('/quantumography/login-or-register',[QuantomLoginController::class,'loginOrRegister'])->name('quantom.user.login.register');
Route::get('/quantumography/get-user-by-token',[QuantomLoginController::class,'getUserByToken'])->name('quantom.user.get');
Route::get('/quantumography/register',[QuantomRegisterController::class,'showRegistrationForm'])->name('quantom.register');
Route::post('/quantumography/register',[QuantomRegisterController::class,'register'])->name('quantom.user.register');
