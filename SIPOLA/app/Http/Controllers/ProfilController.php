<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $fotoPath = asset('storage/foto_profil/user_' . $user->id . '.jpg');

        if (!file_exists(public_path('storage/foto_profil/user_' . $user->id . '.jpg'))) {
            $fotoPath = asset('storage/foto_profil/user_.jpg');
        }

        return view('profil.index', compact('user', 'fotoPath'));
    }

     public function indexAdmin()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $fotoPath = asset('storage/foto_profil/user_' . $user->id . '.jpg');

        if (!file_exists(public_path('storage/foto_profil/user_' . $user->id . '.jpg'))) {
            $fotoPath = asset('storage/foto_profil/user_.jpg');
        }

        return view('profil.indexAdmin', compact('user', 'fotoPath'));
    }

     public function indexDosen()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $fotoPath = asset('storage/foto_profil/user_' . $user->id . '.jpg');

        if (!file_exists(public_path('storage/foto_profil/user_' . $user->id . '.jpg'))) {
            $fotoPath = asset('storage/foto_profil/user_.jpg');
        }

        return view('profil.indexDosen', compact('user', 'fotoPath'));
    }

    public function updateUsername(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username' => ['required', 'string', 'min:4', 'max:20', Rule::unique('users')->ignore($user->id)],
        ]);

        try {
            $user->username = $request->username;
            $user->save();

            return response()->json([
                'success' => true,
                'username' => $user->username
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal memperbarui username.'
            ], 500);
        }
    }

    public function updateAcademicProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'type' => ['required', 'in:keahlian,sertifikasi,pengalaman'],
            'value' => ['required', 'string', 'max:255'],
        ]);

        try {
            $type = $request->type;
            $value = $request->value;

            // Tambahkan data baru ke field yang bersangkutan
            $fieldMap = [
                'keahlian' => 'bidang_keahlian',
                'sertifikasi' => 'sertifikasi',
                'pengalaman' => 'pengalaman',
            ];

            $field = $fieldMap[$type];
            $existing = explode(',', $user->$field);
            $existing[] = $value;
            $existing = array_filter(array_map('trim', $existing));

            $user->$field = implode(', ', $existing);
            $user->save();

            return response()->json([
                'success' => true,
                'message' => ucfirst($type) . ' berhasil ditambahkan.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal memperbarui data.'
            ], 500);
        }
    }


    public function updateProfile(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'nama' => ['nullable', 'string', 'max:255'],
        'username' => ['nullable', 'string', 'min:4', 'max:20', Rule::unique('users')->ignore($user->id)],
        'foto_profil' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
    ]);

    try {
        // Update nama jika ada
        if ($request->filled('nama')) {
            $user->name = $request->nama;
        }

        // Update username jika ada
        if ($request->filled('username')) {
            $user->username = $request->username;
        }

        // Update foto profil jika ada file dikirim
        if ($request->hasFile('foto_profil')) {
            $foto = $request->file('foto_profil');
            $fileName = 'user_' . $user->id . '.jpg';
            $destinationPath = public_path('storage/foto_profil');

            // Buat folder jika belum ada
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Hapus file lama jika ada
            $oldPath = $destinationPath . '/' . $fileName;
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }

            // Simpan file baru
            $foto->move($destinationPath, $fileName);
        }

        $user->save();

        $fotoPath = asset('storage/foto_profil/user_' . $user->id . '.jpg');

        return response()->json([
            'success' => true,
            'user' => $user,
            'fotoPath' => $fotoPath,
            'message' => 'Profil berhasil diperbarui.',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Gagal memperbarui profil.',
        ], 500);
    }
}



}

