<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User; // Pastikan sudah import model User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     */
    public function login(Request $request)
    {
        // Validasi input untuk nidn dan password
        $credentials = $request->validate([
            'nidn' => 'required', // Menggunakan nidn sebagai username
            'password' => 'required',
        ]);

        // Cek apakah ada user dengan nidn yang sesuai
        $user = User::where('nidn', $request->nidn)->first();

        // Jika user ditemukan dan password cocok
        if ($user && Hash::check($request->password, $user->password)) {
            // Lakukan proses login
            Auth::login($user);
            $request->session()->regenerate();

            // Redirect berdasarkan peran (role) pengguna
            switch ($user->role) {
                case 'admin':
                    return redirect()->intended('admin/dashboard');
                case 'dosen':
                    return redirect()->intended('dosen/dashboard');
                case 'mahasiswa':
                    return redirect()->intended('mahasiswa/dashboard');
                default:
                    return redirect()->intended('dashboard');
            }
        }

        // Jika nidn atau password salah, lemparkan exception
        throw ValidationException::withMessages([
            'nidn' => [trans('auth.failed')],
        ]);
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
