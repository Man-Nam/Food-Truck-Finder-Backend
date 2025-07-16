<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodTruck extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'description',
        'latitude',
        'longitude',
        'last_reported_at',
        'reported_by_user_id',
        'marker_icon_url',
    ];

    protected $casts = [
        'last_reported_at' => 'datetime',
    ];

    public function reportedBy()
    {
        return $this->belongsTo(User::class, 'reported_by_user_id');
    }
}