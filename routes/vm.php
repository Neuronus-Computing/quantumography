<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VmController;
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
Route::get('/', [VmController::class, 'index'])->name('vm.index');
Route::get('/virtual-machienes', [VmController::class, 'index'])->name('v.index');
Route::get('/opertaing-systems', [VmController::class, 'os'])->name('vm.os');
Route::post('/virtual-machienes', [VmController::class, 'buy'])->name('vm.buy');  
Route::get('/virtual-machienes-checkout', [VmController::class, 'checkout'])->name('vm.checkout');   
Route::post('/process-payment', [VmController::class, 'processPayment'])->name('vm.process.payment');
Route::get('payment-success/{payment?}', [VmController::class, 'paymentSuccess'])->name('vm.payment.success');
