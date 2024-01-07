<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function store(Request $request)
    {
        // Validate and process the incoming GPS data
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Save to the database using the Location model
        Location::create(['latitude' => $request->input('latitude'), 'longitude' => $request->input('longitude')]);

        return response()->json(['message' => 'Location data received and saved successfully']);
    }
}
