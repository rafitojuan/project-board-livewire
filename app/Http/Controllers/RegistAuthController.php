<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistAuthController extends Controller
{
    // public function __invoke(Request $request){
    //     return view('auth.register');
    // }
    public function index()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        try {
            // Validate all inputs first
            $request->validate([
                'password' => 'required|min:6',
                'email' => 'required|email|unique:users',
                'name' => 'required|string|max:255',
                'avatar' => 'required|image|mimes:jpg,jpeg,png|max:1024',
            ]);

            // Handle file upload after validation passes
            $avatarName = '';
            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
                $avatarPath = public_path('/images/');

                // Ensure directory exists
                if (!file_exists($avatarPath)) {
                    mkdir($avatarPath, 0777, true);
                }

                $avatar->move($avatarPath, $avatarName);
            }

            // Create user after successful file upload
            User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'dob' => date('Y-m-d', strtotime($request['dob'])),
                'avatar' => "/images/" . $avatarName,
                'role_id' => 7,
                'division_id' => null,
            ]);

            return redirect()->back()->with('success', 'Registrasi berhasil! Silakan login.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Registrasi gagal! Silakan coba lagi.' . $e->getMessage())->withInput();
        }
    }
}
