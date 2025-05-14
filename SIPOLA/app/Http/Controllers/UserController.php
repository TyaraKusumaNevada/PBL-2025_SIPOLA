<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Models\DospemModel;
use App\Models\MahasiswaModel;
use App\Models\ProgramStudiModel;
use App\Models\RoleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $mahasiswa = MahasiswaModel::all();
        $dospem = DospemModel::all();
        $admin = AdminModel::all();

        return view('user.index', compact('mahasiswa', 'dospem', 'admin'));
    }


    public function list()
    {
        $mahasiswa = MahasiswaModel::with('role')
            ->get()
            ->map(function ($mhs, $index) {
                return [
                    'no' => $index + 1,
                    'id' => $mhs->id_mahasiswa,
                    'nim_nidn' => $mhs->nim,
                    'nama' => $mhs->nama,
                    'role_user' => $mhs->role->role_nama ?? 'Mahasiswa',
                    'kategori' => 'mahasiswa',
                ];
            });

        $dosen = DospemModel::with('role')
            ->get()
            ->map(function ($dsn, $index) use ($mahasiswa) {
                return [
                    'no' => $mahasiswa->count() + $index + 1,
                    'id' => $dsn->id_dosen,
                    'nim_nidn' => $dsn->nidn,
                    'nama' => $dsn->nama,
                    'role_user' => $dsn->role->role_nama ?? 'Dosen',
                    'kategori' => 'dosen',
                ];
            });

        $admin = AdminModel::with('role')
            ->get()
            ->map(function ($adm, $index) use ($mahasiswa, $dosen) {
                return [
                    'no' => $mahasiswa->count() + $dosen->count() + $index + 1,
                    'id' => $adm->id_admin,
                    'nim_nidn' => '-', // Admin tidak punya NIM/NIDN
                    'nama' => $adm->nama,
                    'role_user' => $adm->role->role_nama ?? 'Admin',
                    'kategori' => 'admin',
                ];
            });

        $data = $mahasiswa->concat($dosen)->concat($admin)->values();

        return response()->json(['data' => $data]);
    }

    public function show_ajax($id, $kategori)
    {

        if ($kategori === 'mahasiswa') {
            $user = MahasiswaModel::findOrFail($id);
            return response()->json([
                'id' => $user->id_mahasiswa,
                'nama' => $user->nama,
                'email' => $user->email,
                'nim_nidn' => $user->nim
            ]);
        } elseif ($kategori === 'dosen') {
            $user = DospemModel::findOrFail($id);
            return response()->json([
                'id' => $user->id_dosen,
                'nama' => $user->nama,
                'email' => $user->email,
                'nim_nidn' => $user->nidn
            ]);
        } elseif ($kategori === 'admin') {
            $user = AdminModel::findOrFail($id);
            return response()->json([
                'id' => $user->id_admin,
                'nama' => $user->nama,
                'email' => $user->email,
                'nim_nidn' => '-'
            ]);
        }
    }

    public function create_ajax()
    {
        $roles = RoleModel::all();
        $prodis = ProgramStudiModel::all(); // ambil semua prodi

        return view('user.create_ajax', compact('roles', 'prodis'));
    }


    public function store_ajax(Request $request)
    {
        $emailRule = match ($request->id_role) {
            3 => 'unique:mahasiswa,email', // id_role 3 = Mahasiswa
            2 => 'unique:dospem,email',    // id_role 2 = Dosen
            1 => 'unique:admin,email',     // id_role 1 = Admin
            default => '',
        };

        $request->validate([
            'id_role' => 'required|exists:role,id_role',
            'nama' => 'required|string|max:255',
            'email' => ['required', 'email', $emailRule],
            'password' => 'required|string|min:6',
            'nim_nidn' => 'nullable|string',
            'id_prodi' => 'required_if:id_role,3',
        ]);

        $role = RoleModel::find($request->id_role);
        if (!$role) return response()->json(['error' => 'Role tidak ditemukan'], 404);

        $data = [
            'id_role' => $request->id_role,
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'id_prodi' => $request->id_prodi,
        ];


        switch ($role->role_kode) {
            case 'MHS':
                $data['nim'] = $request->nim_nidn;
                $data['id_prodi'] = $request->id_prodi;
                $user = MahasiswaModel::create($data);
                break;
            case 'DSN':
                $data['nidn'] = $request->nim_nidn;
                $user = DospemModel::create($data);
                break;
            case 'ADM':
                $user = AdminModel::create($data);
                break;
            default:
                return response()->json(['error' => 'Role tidak valid'], 400);
        }

        return response()->json(['success' => 'User berhasil ditambahkan', 'user' => $user]);
    }

    public function edit($id, $role)
    {
        switch ($role) {
            case 'mahasiswa':
                $user = MahasiswaModel::find($id);
                break;
            case 'dosen':
                $user = DospemModel::find($id);
                break;
            case 'admin':
                $user = AdminModel::find($id);
                break;
            default:
                return response()->json(['error' => 'Role tidak valid'], 400);
        }

        if (!$user) return response()->json(['error' => 'User tidak ditemukan'], 404);

        return response()->json($user);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'kategori' => 'required|in:mahasiswa,dosen,admin',
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'nim_nidn' => 'nullable|string'
        ]);

        $kategori = $request->kategori;

        if ($kategori === 'mahasiswa') {
            $user = MahasiswaModel::findOrFail($request->id);
            $user->nama = $request->nama;
            $user->email = $request->email;
            $user->nim = $request->nim_nidn;
            $user->save();
        } elseif ($kategori === 'dosen') {
            $user = DospemModel::findOrFail($request->id);
            $user->nama = $request->nama;
            $user->email = $request->email;
            $user->nidn = $request->nim_nidn;
            $user->save();
        } elseif ($kategori === 'admin') {
            $user = AdminModel::findOrFail($request->id);
            $user->nama = $request->nama;
            $user->email = $request->email;
            $user->save();
        }

        return response()->json(['message' => 'Berhasil diupdate']);
    }

    public function destroy($id, $kategori)
    {
        if ($kategori === 'mahasiswa') {
            MahasiswaModel::destroy($id);
        } elseif ($kategori === 'dosen') {
            DospemModel::destroy($id);
        } elseif ($kategori === 'admin') {
            AdminModel::destroy($id);
        }

        return response()->json(['message' => 'Berhasil dihapus']);
    }
}
