<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/*
|--------------------------------------------------------------------------
| Shipment APIs
|--------------------------------------------------------------------------
 */
Route::post('/shipment/calculate', [App\Http\Controllers\Front\PaymentController::class, 'calculateShipmentPrices'])->name('calculateShipmentPrices');
Route::post('/shipment/get-shipment-methods', [App\Http\Controllers\Front\PaymentController::class, 'getShipmentMethods'])->name('getShipmentMethods');


//order files upload api
Route::get('/product/{id}', [\App\Http\Controllers\Api\ProductController::class, 'getProductDetails'])
    ->middleware('verify.api.token');
Route::post('/file-preview/', [\App\Http\Controllers\Api\UploadController::class, 'filePreview'])
    ->middleware('verify.api.token');