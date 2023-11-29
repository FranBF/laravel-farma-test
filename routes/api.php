<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PointsAddedController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\PointsController;
use App\Http\Controllers\Api\PointsRedeemedController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/add-points/{pharm_id}/{client_id}/{points}', [PointsAddedController::class, 'store']);
Route::get('/get-date-points/{pharmacy_id}/{date}', [PointsController::class, 'getPointsByDate']);
Route::get('/get-client-points/{pharmacy_id}/{client_id}', [PointsController::class, 'returnPharmPointsToClientToApi']);
Route::get('/get-all-client-points/{client_id}', [PointsController::class, 'getAllClientPoints']);
Route::get('/redeem/{customer_id}/{pharm_id}/{pointsToRedeem}', [PointsRedeemedcontroller::class, 'store']);
