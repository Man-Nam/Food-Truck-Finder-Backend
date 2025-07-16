<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FoodTruck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class FoodTruckController extends Controller
{
    /**
     * Get all food truck locations.
     */
    public function index()
    {
        $foodTrucks = FoodTruck::with('reportedBy')->get();

        // Transform the data to match the Flutter app's expected format
        $formattedFoodTrucks = $foodTrucks->map(function ($truck) {
            return [
                'id' => $truck->id,
                'name' => $truck->name,
                'type' => $truck->type,
                'description' => $truck->description,
                'latitude' => (float) $truck->latitude, // Ensure float type
                'longitude' => (float) $truck->longitude, // Ensure float type
                'last_reported_at' => $truck->last_reported_at->toIso8601String(), // ISO 8601 for Flutter's DateTime.parse
                'reported_by' => $truck->reportedBy ? ['name' => $truck->reportedBy->name] : ['name' => 'Anonymous'],
                'marker_icon_url' => $truck->marker_icon_url, // Include this if you have it
            ];
        });

        return response()->json($formattedFoodTrucks);
    }

    /**
     * Report a new food truck location or update an existing one.
     */
    public function report(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'description' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id', // Optional: if users can be anonymous or authenticated
            'food_truck_id' => 'nullable|exists:food_trucks,id', // For updating existing
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        if (isset($data['food_truck_id'])) {
            // Update existing food truck
            $foodTruck = FoodTruck::find($data['food_truck_id']);
            if (!$foodTruck) {
                return response()->json(['message' => 'Food truck not found.'], 404);
            }
            $foodTruck->update([
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'last_reported_at' => Carbon::now(),
                'reported_by_user_id' => $data['user_id'] ?? null, // Or use auth()->id() if user is authenticated
            ]);
            $message = 'Food truck location updated successfully.';
        } else {
            // Create new food truck entry
            $foodTruck = FoodTruck::create([
                'name' => $data['name'],
                'type' => $data['type'],
                'description' => $data['description'] ?? null,
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'last_reported_at' => Carbon::now(),
                'reported_by_user_id' => $data['user_id'] ?? null, // Or use auth()->id() if user is authenticated
            ]);
            $message = 'Food truck reported successfully.';
        }

        return response()->json(['message' => $message, 'food_truck' => $foodTruck->load('reportedBy')], 201);
    }

    /**
     * Upload custom marker icon.
     * This endpoint could be used by the admin UI or food truck owners.
     */
    public function uploadMarkerIcon(Request $request, FoodTruck $foodTruck)
    {
        $request->validate([
            'marker_icon' => 'required|image|mimes:png,jpg,jpeg|max:2048', // Max 2MB
        ]);

        if ($foodTruck->marker_icon_url) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $foodTruck->marker_icon_url));
        }

        $path = $request->file('marker_icon')->store('food_truck_markers', 'public');
        $foodTruck->marker_icon_url = Storage::url($path);
        $foodTruck->save();

        return response()->json(['message' => 'Marker icon uploaded successfully.', 'url' => $foodTruck->marker_icon_url]);
    }
}