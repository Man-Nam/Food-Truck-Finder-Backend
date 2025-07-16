// app/Services/GooglePlacesService.php
<?php

namespace App\Services;

use Google\Client;
use Google\Service\Places;
use Illuminate\Support\Str;

class GooglePlacesService
{
    protected $client;
    protected $places;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setDeveloperKey(config('services.google.api_key'));
        $this->places = new Places($this->client);
    }

    public function searchFoodTrucks($latitude, $longitude, $radius = 5000)
    {
        try {
            $response = $this->places->places->nearbySearch([
                'location' => "$latitude,$longitude",
                'radius' => $radius,
                'type' => 'food',
                'keyword' => 'food truck'
            ]);

            return $this->formatResults($response->getResults());
        } catch (\Exception $e) {
            \Log::error('Google Places API Error: ' . $e->getMessage());
            return [];
        }
    }

    protected function formatResults($places)
    {
        return collect($places)->map(function ($place) {
            return [
                'google_place_id' => $place->place_id,
                'name' => $place->name,
                'type' => $this->determineFoodType($place),
                'location_description' => $place->vicinity ?? '',
                'latitude' => $place->geometry->location->lat,
                'longitude' => $place->geometry->location->lng,
                'reported_by' => 'Google Places API',
                'reported_at' => now(),
            ];
        })->toArray();
    }

    protected function determineFoodType($place)
    {
        $name = Str::lower($place->name);
        $types = $place->types ?? [];
        
        if (in_array('mexican_restaurant', $types)) return 'Mexican';
        if (in_array('asian_restaurant', $types)) return 'Asian';
        if (in_array('american_restaurant', $types)) return 'American';
        if (in_array('ice_cream_shop', $types)) return 'Dessert';
        
        if (Str::contains($name, ['taco', 'burrito', 'quesadilla'])) return 'Mexican';
        if (Str::contains($name, ['burger', 'hot dog', 'fries'])) return 'American';
        if (Str::contains($name, ['sushi', 'ramen', 'pho'])) return 'Asian';
        if (Str::contains($name, ['ice cream', 'gelato', 'dessert'])) return 'Dessert';
        
        return 'Other';
    }
}