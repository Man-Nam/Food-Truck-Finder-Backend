<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FoodTruckController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/foodtrucks', [FoodTruckController::class, 'index']);
Route::post('/foodtrucks/report', [FoodTruckController::class, 'report']);
Route::post('/foodtrucks/{foodTruck}/upload-marker', [FoodTruckController::class, 'uploadMarkerIcon']);

// You might want to protect reporting with authentication later.
// Route::middleware('auth:sanctum')->post('/foodtrucks/report', [FoodTruckController::class, 'report']);