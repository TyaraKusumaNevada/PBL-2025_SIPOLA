<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MahasiswaModel;
use App\Models\DospemModel;
use App\Models\AdminModel;
use App\Models\Dosen;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Show the login form
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            
            $validator = Validator::make($request->all(), [
                'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'messages' => $validator->errors(),
            ]);
        }

        // First, check if the identifier (NIM/NIP/NIDN) exists in any of our tables
        $userFound = false;
        $userType = null;
        $userData = null;

        // Check in mahasiswa table for NIM
        $mahasiswa = MahasiswaModel::where('nim', $request->username)->first();
        
        if ($mahasiswa) {
            $userFound = true;
            $userType = 'mahasiswa';
            $userData = $mahasiswa;
        } else {
            // Check in dosen table for NIP/NIDN
            $dosen = DospemModel::where('nidn', $request->username)->first();
            
            if ($dosen) {
                $userFound = true;
                $userType = 'dosen';
                $userData = $dosen;
            } else {
                // Check in admin table
                $admin = AdminModel::where('nama', $request->username)->first();
                
                if ($admin) {
                    $userFound = true;
                    $userType = 'admin';
                    $userData = $admin;
                }
            }
        }

        // If user identifier found in one of our tables
        if ($userFound && $userData) {
            // Verify password - depends on where you store the password
            $passwordField = 'password'; // Default password field name

            // Attempt to log the user in
            // Here we're finding or creating a user in the users table based on data from specialized tables
            $user = User::where('username', $request->username)->first();

            if (!$user) {
                // User doesn't exist in users table yet, create based on corresponding specialized table
                $name = $userType === 'student' ? $userData->nama : ($userType === 'dosen' ? $userData->nama : $userData->nama);
                
                $user = User::create([
                    'name' => $name,
                    'username' => $request->username,
                    'email' => $userData->email ?? null,
                    'password' => $userData->$passwordField, // Copy password hash from corresponding table
                    'role' => $userType
                ]);
            }

            // Now check password - using the password from the specialized table
            if (Hash::check($request->password, $userData->$passwordField)) {
                // Login successful
                Auth::login($user);
                $request->session()->regenerate();
                
                // Redirect based on user role
                
                $redirectTo = url('/');
                
                // Send response for the client-side alert (successful login)
                return response()->json([
                    'status' => true,
                    'role' => $userType,
                    'message' => 'Login berhasil sebagai ' . ucfirst($userType),
                    'redirect' => $redirectTo,
                ]);
                
            }
        }

        // Either user not found or password incorrect
        return response()->json([
            'status' => false,
            'messages' => [
                'password' => ['NIM/NIP/NIDN atau password tidak valid!']
            ],
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Error di '.$e
        ]);
    }
    }

    /**
     * Handle logout request
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}