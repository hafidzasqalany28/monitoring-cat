<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Mendapatkan informasi profil user
        $user = Auth::user();

        // Mengambil informasi jumlah users dari model User
        $userCount = User::count();

        // Mengambil informasi lokasi dari model Location
        $locations = Location::count();

        // Inisialisasi variabel $widget
        $widget = [
            'deviceStatus' => [
                'status' => 'Online', // Berikan nilai default
                'lastUpdate' => now()->format('Y-m-d h:i A'),
            ],
            'users' => $userCount,
            'locations' => $locations,
        ];

        return view('profile', compact('user', 'widget'));
    }

    public function update(Request $request)
    {
        // Validasi input form
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::user()->id,
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|max:12|required_with:current_password',
            'password_confirmation' => 'nullable|min:8|max:12|required_with:new_password|same:new_password'
        ]);

        // Mengambil user yang sedang login
        $user = User::findOrFail(Auth::user()->id);

        // Mengisi data yang diubah dari form
        $user->name = $request->input('name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');

        // Mengubah password jika password lama benar
        if (!is_null($request->input('current_password'))) {
            if (Hash::check($request->input('current_password'), $user->password)) {
                $user->password = Hash::make($request->input('new_password'));
            } else {
                return redirect()->back()->withInput()->withErrors(['current_password' => 'The current password is incorrect.']);
            }
        }

        // Menyimpan perubahan
        $user->save();

        // Mengarahkan kembali ke halaman profil dengan pesan sukses
        return redirect()->route('profile')->withSuccess('Profile updated successfully.');
    }
}
