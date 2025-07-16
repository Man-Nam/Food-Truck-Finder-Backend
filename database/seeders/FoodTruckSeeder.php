<?php

// File: database/seeders/FoodTruckSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FoodTruck; // Import your FoodTruck model
use Illuminate\Support\Carbon; // For handling timestamps
use Faker\Factory as Faker; // For generating fake data

class FoodTruckSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Define some common food truck types
        $foodTruckTypes = [
            'Burger', 'Taco', 'Pizza', 'Coffee', 'Dessert', 'BBQ', 'Seafood',
            'Asian Fusion', 'Mediterranean', 'Sandwich', 'Hot Dog', 'Ice Cream'
        ];

        // --- IMPORTANT CHANGE HERE ---
        // Temporarily set markerIcons to only include null.
        // This forces Flutter to use its default orange markers,
        // helping to confirm if the issue is with the placehold.co URLs.
        $markerIcons = [
            null, // Only use default markers for now
        ];
        // --- END IMPORTANT CHANGE ---

        // Create 15 random food truck entries
        for ($i = 0; $i < 15; $i++) {
            FoodTruck::create([
                'name' => $faker->company . ' ' . $faker->randomElement(['Eats', 'Truck', 'Grill', 'Kitchen', 'Cart']),
                'type' => $faker->randomElement($foodTruckTypes),
                'description' => $faker->boolean(70) ? $faker->sentence(rand(5, 15)) : null, // 70% chance of having a description
                'latitude' => $faker->latitude(3.0, 3.2), // Random latitude around Kuala Lumpur/Shah Alam area
                'longitude' => $faker->longitude(101.5, 101.8), // Random longitude around Kuala Lumpur/Shah Alam area
                'last_reported_at' => Carbon::now()->subMinutes(rand(1, 1440)), // Reported within the last 24 hours
                'reported_by_user_id' => null, // For now, no specific user
                'marker_icon_url' => $faker->randomElement($markerIcons), // Will now always be null
            ]);
        }
    }
}
