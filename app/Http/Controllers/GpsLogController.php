<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class GpsLogController extends Controller
{
    public function index()
    {
        $gpsLogs = Location::orderBy('id', 'desc')->get();
        return view('gps-log', compact('gpsLogs'));
    }
}
