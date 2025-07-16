<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FoodTruck;
use App\Models\User; // Assuming you might link to users
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FoodTruckAdminController extends Controller
{
    public function index()
    {
        $foodTrucks = FoodTruck::with('reportedBy')->orderBy('name')->paginate(10);
        return view('admin.food_trucks.index', compact('foodTrucks'));
    }

    public function create()
    {
        $users = User::all(); // For assigning a reporter
        return view('admin.food_trucks.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'reported_by_user_id' => 'nullable|exists:users,id',
            // No marker_icon_url directly here, handle it via a separate upload or admin UI for file upload
        ]);

        FoodTruck::create($request->all());

        return redirect()->route('admin.food_trucks.index')->with('success', 'Food truck added successfully!');
    }

    public function edit(FoodTruck $foodTruck)
    {
        $users = User::all();
        return view('admin.food_trucks.edit', compact('foodTruck', 'users'));
    }

    public function update(Request $request, FoodTruck $foodTruck)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'reported_by_user_id' => 'nullable|exists:users,id',
        ]);

        $foodTruck->update($request->all());

        return redirect()->route('admin.food_trucks.index')->with('success', 'Food truck updated successfully!');
    }

    public function destroy(FoodTruck $foodTruck)
    {
        if ($foodTruck->marker_icon_url) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $foodTruck->marker_icon_url));
        }
        $foodTruck->delete();
        return redirect()->route('admin.food_trucks.index')->with('success', 'Food truck deleted successfully!');
    }
}