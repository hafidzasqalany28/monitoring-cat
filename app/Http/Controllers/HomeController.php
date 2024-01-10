<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Location;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::count();

        // Fetch the last 5 locations with device status in descending order by id
        $locations = Location::latest('id')->take(5)->get();

        // Fetch the latest GPS log
        $latestLocation = Location::latest('id')->first();

        // Get GPS coordinates of the cat and home from the latest log or another database
        $catLocation = ['latitude' => $latestLocation->latitude, 'longitude' => $latestLocation->longitude];
        // musamus
        $homeLocation = ['latitude' => -8.5318352, 'longitude' => 140.4170948];

        // Calculate the distance between the cat and home
        $distance = $this->calculateDistance($catLocation, $homeLocation);

        // Set the distance threshold to determine if the cat is far from home
        $thresholdDistance = 100; // For example, in meters

        // Create a variable to store the status
        $isFarFromHome = $distance > $thresholdDistance;

        // Simulate dynamic device status
        $deviceStatus = [
            'status' => 'Online',
            'lastUpdate' => now()->format('Y-m-d h:i A'),
        ];

        $widget = [
            'users' => $users,
            'deviceStatus' => $deviceStatus,
            'locations' => $locations,
            'latestLocation' => $latestLocation,
            'isFarFromHome' => $isFarFromHome,
            'distance' => $distance,
        ];

        return view('home', compact('widget'));
    }

    /**
     * Calculate the distance between two coordinates.
     *
     * @param array $point1
     * @param array $point2
     * @return float
     */
    public function calculateDistance($point1, $point2)
    {
        $lat1 = $point1['latitude'];
        $lon1 = $point1['longitude'];
        $lat2 = $point2['latitude'];
        $lon2 = $point2['longitude'];

        // Implementation of distance calculation logic here

        // Haversine Formula
        $R = 6371000; // Radius of the Earth in meters
        $dlat = deg2rad($lat2 - $lat1);
        $dlon = deg2rad($lon2 - $lon1);

        $a = sin($dlat / 2) * sin($dlat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dlon / 2) * sin($dlon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = round($R * $c, 2); // Distance in meters, rounded to 2 decimal places

        return $distance;
    }
}
