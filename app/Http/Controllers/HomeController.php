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

        // Simulate dynamic device status
        $deviceStatus = [
            'status' => 'Online',
            'lastUpdate' => now()->format('Y-m-d h:i A'),
        ];

        $widget = [
            'users' => $users,
            'deviceStatus' => $deviceStatus,
            'locations' => $locations,
        ];

        return view('home', compact('widget'));
    }
}
