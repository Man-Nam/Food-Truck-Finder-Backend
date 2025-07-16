<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FoodTruck;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage; // Added for the destroy method

class FoodTruckAdminController extends Controller
{
    public function index()
    {
        $foodTrucks = FoodTruck::with('reportedBy')->orderBy('name')->paginate(10);
        return view('admin.food_trucks.index', compact('foodTrucks'));
    }

    public function create()
    {
        $users = User::all();
        return view('admin.food_trucks.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'reported_by_user_id' => 'nullable|exists:users,id',
        ]);

        // Automatically set last_reported_at to now when created via admin
        $validatedData['last_reported_at'] = now();

        FoodTruck::create($validatedData);

        return redirect()->route('admin.food_trucks.index')->with('success', 'Food truck added successfully!');
    }

    public function edit(FoodTruck $foodTruck)
    {
        $users = User::all();
        return view('admin.food_trucks.edit', compact('foodTruck', 'users'));
    }

    public function update(Request $request, FoodTruck $foodTruck)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'reported_by_user_id' => 'nullable|exists:users,id',
        ]);

        // Automatically update last_reported_at to now when modified via admin
        $validatedData['last_reported_at'] = now();

        $foodTruck->update($validatedData);

        return redirect()->route('admin.food_trucks.index')->with('success', 'Food truck updated successfully!');
    }

    public function destroy(FoodTruck $foodTruck)
    {
        if ($foodTruck->marker_icon_url) {
            // Ensure the path is correct for Storage::disk('public')->delete
            // It expects paths relative to the public disk's root (usually storage/app/public)
            // If marker_icon_url is like http://localhost:8000/storage/icons/icon.png
            // then str_replace('/storage/', '', $foodTruck->marker_icon_url) will give icons/icon.png
            // This assumes your public disk is configured to point to storage/app/public
            Storage::disk('public')->delete(str_replace('/storage/', '', parse_url($foodTruck->marker_icon_url, PHP_URL_PATH)));
        }
        $foodTruck->delete();
        return redirect()->route('admin.food_trucks.index')->with('success', 'Food truck deleted successfully!');
    }
}
