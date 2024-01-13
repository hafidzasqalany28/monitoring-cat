<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function receiveLocation(Request $request)
    {
        // Validasi data yang diterima dari alat
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
            // tambahkan validasi sesuai kebutuhan
        ]);

        // Simpan data ke dalam tabel locations
        Location::create([
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            // tambahkan kolom lain sesuai kebutuhan
        ]);

        return response()->json(['message' => 'Location data received successfully']);
    }
}
