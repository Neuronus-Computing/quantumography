<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\ImageEnlargeController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/image-enlarger',[ImageEnlargeController::class,'imageEnlarge'])->name('image.enlarge.api');
Route::get('/image-enlarger-get-requests',[ImageEnlargeController::class,'getRquestDetails'])->name('image.enlarge.api.requests');