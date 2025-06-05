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
            'type' => ['required', 'in:keahlian,minat,pengalaman'],
            'value' => ['required', 'string'],
            'action' => ['nullable', 'in:add,update'],
        ]);

        try {
            $type = $request->type;
            $value = $request->value;
            $action = $request->action ?? 'update';

            // Field mapping
            $fieldMap = [
                'keahlian' => 'keahlian',
                'minat' => 'minat',
                'pengalaman' => 'pengalaman',
            ];

            $field = $fieldMap[$type];

            if ($action === 'add') {
                // Tambah item baru
                $existing = $user->$field ? explode(';', $user->$field) : [];
                $existing = array_filter(array_map('trim', $existing));
                $existing[] = trim($value);
                
                $user->$field = implode(';', $existing);
            } else {
                // Update semua data (replace)
                $items = explode(';', $value);
                $items = array_filter(array_map('trim', $items));
                
                $user->$field = implode(';', $items);
            }

            $user->save();

            // Return updated items
            $updatedItems = $user->$field ? explode(';', $user->$field) : [];
            $updatedItems = array_filter(array_map('trim', $updatedItems));

            return response()->json([
                'success' => true,
                'message' => ucfirst($type) . ' berhasil diperbarui.',
                'items' => array_values($updatedItems)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal memperbarui data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteAcademicItem(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'type' => ['required', 'in:keahlian,minat,pengalaman'],
            'index' => ['required', 'integer', 'min:0'],
        ]);

        try {
            $type = $request->type;
            $indexToDelete = $request->index;

            // Field mapping
            $fieldMap = [
                'keahlian' => 'keahlian',
                'minat' => 'minat',
                'pengalaman' => 'pengalaman',
            ];

            $field = $fieldMap[$type];

            // Get current items
            $items = $user->$field ? explode(';', $user->$field) : [];
            $items = array_filter(array_map('trim', $items));

            // Re-index array to ensure consecutive indices
            $items = array_values($items);

            // Check if index exists
            if (!isset($items[$indexToDelete])) {
                return response()->json([
                    'error' => 'Item tidak ditemukan.'
                ], 404);
            }

            // Remove item at specified index
            unset($items[$indexToDelete]);
            $items = array_values($items); // Re-index array

            // Update database
            $user->$field = empty($items) ? null : implode(';', $items);
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Item berhasil dihapus.',
                'items' => $items
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal menghapus item: ' . $e->getMessage()
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
                'error' => 'Gagal memperbarui profil: ' . $e->getMessage(),
            ], 500);
        }
    }
}