<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MahasiswaModel;
use App\Models\ProgramStudiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SiginController extends Controller
{
    public function showRegistrationForm()
    {
        // Ambil semua program studi untuk dropdown
        $prodi = ProgramStudiModel::all();  
        return view('auth.signin', compact('prodi'));
    }

    public function register(Request $request)
    {
        // Validasi data
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:mahasiswa,nim|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
            'id_prodi' => 'required|exists:program_studi,id_prodi',
            'bidang_keahlian' => 'nullable|string|max:255',
            'minat' => 'nullable|string',
        ], [
            'nama.required' => 'Nama lengkap tidak boleh kosong',
            'nim.required' => 'NIM tidak boleh kosong',
            'nim.unique' => 'NIM sudah terdaftar',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password harus memiliki minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'password_confirmation.required' => 'Konfirmasi password diperlukan',
            'id_prodi.required' => 'Program studi harus dipilih',
            'id_prodi.exists' => 'Program studi tidak valid',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            Log::error('Validation failed: ' . json_encode($validator->errors()));
            return response()->json([
                'status' => false,
                'messages' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Membuat user dengan username = nim
            $user = User::create([
                'name' => $request->nama,
                'username' => $request->nim,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Membuat data mahasiswa
            $mahasiswa = MahasiswaModel::create([
                'user_id' => $user->id,
                'nama' => $request->nama,
                'nim' => $request->nim,
                'id_prodi' => $request->id_prodi,
                'bidang_keahlian' => $request->bidang_keahlian,
                'minat' => $request->minat,
                'id_role' => 3, // Sesuaikan dengan ID role untuk mahasiswa
                'password' => Hash::make($request->password), // Menyimpan password di tabel mahasiswa
                'email' => $request->email, // Menyimpan email di tabel mahasiswa
            ]);

            // Menetapkan role mahasiswa ke user
            DB::commit();

            return response()->json([
                'status' => true,
                'redirect' => '/login',
                'message' => 'Registrasi berhasil! Silakan login.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Registration error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'messages' => ['general' => ['Terjadi kesalahan dalam proses registrasi. Silakan coba lagi.']]
            ], 500);
        }
    }
}
