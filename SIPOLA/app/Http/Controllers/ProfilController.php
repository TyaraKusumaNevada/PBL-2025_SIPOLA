<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Models\MahasiswaModel;
use App\Models\DospemModel;
use App\Models\AdminModel;
use App\Models\User;

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

        switch ($user->id_role) {
            case 1: // Admin
                $admin = AdminModel::where('id_admin', $user->id)->first();
                return view('profil.indexAdmin', compact('user', 'admin', 'fotoPath'));

            case 2: // Dosen
                $dosen = DospemModel::with(['prodi', 'angkatan'])
                    ->where('id_dosen', $user->id)
                    ->first();
                return view('profil.indexDosen', compact('user', 'dosen', 'fotoPath'));

            case 3: // Mahasiswa
                $mahasiswa = MahasiswaModel::with(['prodi', 'angkatan'])
                    ->where('id_mahasiswa', $user->id)
                    ->first();
                return view('profil.index', compact('user', 'mahasiswa', 'fotoPath'));

            default:
                abort(403, 'Role tidak dikenali.');
        }
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

            if (!in_array($type, ['keahlian', 'minat', 'pengalaman'])) {
                return response()->json(['error' => 'Kolom tidak valid.'], 400);
            }

            if ($action === 'add') {
                $existing = $user->$type ? explode(';', $user->$type) : [];
                $existing = array_filter(array_map('trim', $existing));
                $existing[] = trim($value);
                $user->$type = implode(';', $existing);
            } else {
                $items = explode(';', $value);
                $items = array_filter(array_map('trim', $items));
                $user->$type = implode(';', $items);
            }

            $user->save();

            $updatedItems = $user->$type ? explode(';', $user->$type) : [];
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

            $items = $user->$type ? explode(';', $user->$type) : [];
            $items = array_values(array_filter(array_map('trim', $items)));

            if (!isset($items[$indexToDelete])) {
                return response()->json([
                    'error' => 'Item tidak ditemukan.'
                ], 404);
            }

            unset($items[$indexToDelete]);
            $items = array_values($items);

            $user->$type = empty($items) ? null : implode(';', $items);
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
        $mahasiswa = MahasiswaModel::where('id_mahasiswa', $user->id)->first();

        $request->validate([
            'nama' => ['nullable', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'min:4', 'max:20', Rule::unique('users')->ignore($user->id)],
            'foto_profil' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        try {
            if ($request->filled('nama') && $mahasiswa) {
                $mahasiswa->nama = $request->nama;
                $mahasiswa->save();
            }

            if ($request->filled('username')) {
                $user->username = $request->username;
            }

            if ($request->hasFile('foto_profil')) {
                $foto = $request->file('foto_profil');
                $fileName = 'user_' . $user->id . '.jpg';
                $destinationPath = public_path('storage/foto_profil');

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $oldPath = $destinationPath . '/' . $fileName;
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }

                $foto->move($destinationPath, $fileName);
            }

            $user->save();

            $fotoPath = asset('storage/foto_profil/user_' . $user->id . '.jpg');

            return response()->json([
                'success' => true,
                'user' => $user,
                'nama' => $mahasiswa ? $mahasiswa->nama : null,
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
