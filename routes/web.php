<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\VangographyPlanController;

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

Route::get('/image-enlarger', [ImageController::class, 'index'])->name('image.index')->middleware('checkvpn');
Route::post('/image-enlarger', [ImageController::class, 'imageEnlarge'])->name('image.enlarge');
Route::get('/get-image-stats', [ImageController::class, 'checkAllowedRequests'])->name('image.stats');
Route::get('/vpn-warning', [ImageController::class, 'vpnWarning'])->name('vpn.warning');
Route::get('/image-enlarger/api-documentation', [ImageController::class, 'apiDocumentation'])->name('image.api.documentation');
Route::get('/phpinfo',function(){
    echo phpinfo();
});
Route::get('/image-enlarger/plans', [PlanController::class , 'index'])->name('plan.index');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::post('/user/profile', [UserController::class, 'updateProfile'])->name('user.profile.update');
    Route::get('/plan-buy/{priceId}', [PaymentController::class, 'checkout'])->name('buy.plan');
    Route::get('/payment/success', [PaymentController::class, 'successPayment'])->name('payment.success');
    Route::get('/payment/cancel', [PaymentController::class, 'cancelPayment'])->name('payment.cancel');
    Route::get('/payment/details', [PaymentController::class, 'paymentDetails'])->name('payment.success.show');
    Route::get('/subscription/cencel', [PaymentController::class, 'cancelSubscription'])->name('cancel.subscription');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/image-enlarger/api-keys', [ImageController::class, 'apiKey'])->name('image.api.key');
    Route::get('/image-enlarger/api-key-generate', [ImageController::class, 'generateKeys'])->name('image.api.key.generate');
    Route::get('/dashboard/payment-history', [DashboardController::class, 'paymentHistory'])->name('dashboard.payment.history');
    Route::group(['middleware' => 'adminCheck'], function () {
        Route::get('/dashboard/settings', [SettingController::class, 'index'])->name('dashboard.settings.index');
        Route::get('/dashboard/settings/create', [SettingController::class, 'create'])->name('dashboard.settings.create');
        Route::post('/dashboard/settings/store', [SettingController::class, 'store'])->name('dashboard.settings.store');
        Route::get('/dashboard/settings/{setting}/edit', [SettingController::class ,'edit'])->name('dashboard.settings.edit');
        Route::put('/dashboard/settings/{setting}', [SettingController::class ,'update'])->name('dashboard.settings.update');
        Route::delete('/dashboard/settings/{setting}', [SettingController::class ,'destroy'])->name('dashboard.settings.destroy');
        Route::get('/dashboard/user/list', [DashboardController::class, 'users'])->name('dashboard.user.list');

        Route::get('/dashboard/vangonography/plans', [VangographyPlanController::class, 'index'])->name('dashboard.vangography.plan.index');
        Route::get('/dashboard/vangonography/plans/create', [VangographyPlanController::class, 'create'])->name('dashboard.vangography.plan.create');
        Route::post('/dashboard/vangonography/plans/store', [VangographyPlanController::class, 'store'])->name('dashboard.vangography.plan.store');
        Route::get('/dashboard/vangonography/plans/{vangographyPlan}/edit', [VangographyPlanController::class ,'edit'])->name('dashboard.vangography.plan.edit');
        Route::put('/dashboard/vangonography/plans/{vangographyPlan}', [VangographyPlanController::class ,'update'])->name('dashboard.vangography.plan.update');
        Route::delete('/dashboard/vangonography/plans/{vangographyPlan}', [VangographyPlanController::class ,'destroy'])->name('dashboard.vangography.plan.destroy');
    });
});
Auth::routes();

Route::get('/home', function () {
    return redirect()->route('index');
})->name('home');
