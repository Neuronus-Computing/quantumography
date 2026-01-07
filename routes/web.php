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
Route::get('/phpinfo',function(){
    echo phpinfo();
});
Route::get('/login', function () {
    return redirect('/quantumography/login');
})->name('login');
Route::get('/register', function () {
    return redirect('/quantumography/register');
})->name('register');

Route::get('/', function () {
    return redirect()->route('index');
})->name('home');
