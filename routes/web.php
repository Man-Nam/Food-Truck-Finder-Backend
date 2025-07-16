<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\FoodTruckAdminController;

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

Route::get('/', function () {
    return view('admin.layouts.app');
});

// Admin Routes (explicitly defined to bypass potential Route::resource issues)
// You might want to add middleware for authentication/authorization later
Route::prefix('admin')->name('admin.')->group(function () {
    // Index - List all food trucks
    Route::get('food-trucks', [FoodTruckAdminController::class, 'index'])->name('food_trucks.index');

    // Create - Show form to create a new food truck
    Route::get('food-trucks/create', [FoodTruckAdminController::class, 'create'])->name('food_trucks.create');

    // Store - Handle form submission for new food truck
    Route::post('food-trucks', [FoodTruckAdminController::class, 'store'])->name('food_trucks.store');

    // Show - Display a specific food truck (optional for admin UI, but part of resource)
    Route::get('food-trucks/{foodTruck}', [FoodTruckAdminController::class, 'show'])->name('food_trucks.show');

    // Edit - Show form to edit an existing food truck
    Route::get('food-trucks/{foodTruck}/edit', [FoodTruckAdminController::class, 'edit'])->name('food_trucks.edit');

    // Update - Handle form submission for updating a food truck
    Route::put('food-trucks/{foodTruck}', [FoodTruckAdminController::class, 'update'])->name('food_trucks.update');
    Route::patch('food-trucks/{foodTruck}', [FoodTruckAdminController::class, 'update']); // PATCH is often used for partial updates

    // Destroy - Delete a food truck
    Route::delete('food-trucks/{foodTruck}', [FoodTruckAdminController::class, 'destroy'])->name('food_trucks.destroy');
});

