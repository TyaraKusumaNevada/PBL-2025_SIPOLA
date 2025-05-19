<?php

namespace App\Http\Controllers;

use App\Models\RoleModel;
use App\Models\AdminModel;
use App\Models\DospemModel;
use App\Models\MahasiswaModel;
use App\Models\ProgramStudiModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index() {
        $breadcrumb = (object) [
            'title' => 'Kelola Pengguna',
            'list'  => ['Home', 'Pengguna']
        ]; 

        $mahasiswas = MahasiswaModel::all();
        $dospems    = DospemModel::all();
        $admins     = AdminModel::all();

        return view('user.index', compact('breadcrumb', 'mahasiswas', 'dospems', 'admins'));
    }

    public function list(Request $request) {
        $mahasiswas = MahasiswaModel::with('role')->get()->map(function ($item) {
            return [
                'id_user' => $item->id_mahasiswa,
                'nomor_induk' => $item->nim,
                'nama' => $item->nama,
                'role_user' => 'mahasiswa', // lowercase agar konsisten
            ];
        });

        $dospems = DospemModel::with('role')->get()->map(function ($item) {
            return [
                'id_user' => $item->id_dosen,
                'nomor_induk' => $item->nidn,
                'nama' => $item->nama,
                'role_user' => 'dosen',
            ];
        });

        $admins = AdminModel::with('role')->get()->map(function ($item) {
            return [
                'id_user' => $item->id_admin,
                'nomor_induk' => '-',
                'nama' => $item->nama,
                'role_user' => 'admin',
            ];
        });

        // Gabungkan semua ke dalam satu collection
        $users = $mahasiswas->concat($dospems)->concat($admins);

        // Lanjutkan dengan DataTables
        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('aksi', function ($user) {
                $id = $user['id_user'] ?? 0;
                $role = $user['role_user'] ?? 'unknown';
                return '
                    <button onclick="modalAction(\''.url("/user/$id/$role/show_ajax").'\')" class="btn btn-info btn-sm">
                        <i class="bi bi-eye"></i><span class="ms-2">Detail</span>
                    </button>
                    <button onclick="modalAction(\''.url("/user/$id/$role/edit_ajax").'\')" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil-square"></i><span class="ms-2">Edit</span>
                    </button>
                    <button onclick="modalAction(\''.url("/user/$id/$role/delete_ajax").'\')" class="btn btn-danger btn-sm">
                        <i class="bi bi-trash"></i><span class="ms-2">Hapus</span>
                    </button>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }   

    public function show_ajax(string $id, string $role) {
        $user = null;

        if ($role === 'mahasiswa') {
            $user = MahasiswaModel::findOrFail($id);
        } elseif ($role === 'dosen') {
            $user = DospemModel::findOrFail($id);
        } elseif ($role === 'admin') {
            $user = AdminModel::findOrFail($id);
        } else {
            abort(404, 'Role tidak ditemukan');
        }

        // Kirim data user dan role ke view
        return view('user.show_ajax', compact('user', 'role'));
    }

    public function create_ajax() {
        $roles = RoleModel::all();
        $prodis = ProgramStudiModel::all();
        return view('user.create_ajax', compact('roles', 'prodis'));
    }

    public function store_ajax(Request $request) {
        if ($request->ajax() || $request->wantsJson()) {

            // Tentukan aturan validasi dinamis tergantung role
            $emailRule = match ((int)$request->id_role) {
                3 => 'unique:mahasiswa,email',
                2 => 'unique:dospem,email',
                1 => 'unique:admin,email',
                default => '',
            };

            $rules = [
                'id_role'    => 'required|exists:role,id_role',
                'nama'       => 'required|string|max:255',
                'email'      => ['required', 'email', $emailRule],
                'password'   => 'required|string|min:6',
                'nim_nidn'   => 'required_if:id_role,2|required_if:id_role,3',
                'id_prodi'   => 'required_if:id_role,3',
            ];

            $validator = Validator::make($request->all(), $rules);

            // Jika validasi gagal
            if ($validator->fails()) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Validasi gagal',
                    'msgField'  => $validator->errors(),
                ]);
            }

            // Proses insert berdasarkan role
            try {
                $role = RoleModel::findOrFail($request->id_role);

                $data = [
                    'id_role'  => $request->id_role,
                    'nama'     => $request->nama,
                    'email'    => $request->email,
                    'password' => Hash::make($request->password),
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
                        return response()->json([
                            'status' => false,
                            'message' => 'Role tidak valid'
                        ]);
                }

                return response()->json([
                    'status'  => true,
                    'message' => 'User berhasil ditambahkan',
                    'user'    => $user,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Terjadi kesalahan saat menyimpan data.',
                    'error'   => $e->getMessage(),
                ]);
            }
        }

        // fallback jika bukan ajax
        return redirect('/');
    }

    // public function edit_ajax(string $id) {
    //     $roles = RoleModel::all();
    //     $prodis = ProgramStudiModel::all();

    //     // Temukan user dari masing-masing model
    //     $user = MahasiswaModel::find($id)
    //         ?? DospemModel::find($id)
    //         ?? AdminModel::find($id);

    //     if (!$user) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'User tidak ditemukan.'
    //         ]);
    //     }

    //     return view('user.edit_ajax', compact('user', 'roles', 'prodis'));
    // }

    public function edit_ajax(string $id, string $role) {
        $roles = RoleModel::all();
        $prodis = ProgramStudiModel::all();
        $user = null;

        if ($role === 'mahasiswa') {
            $user = MahasiswaModel::find($id);
        } elseif ($role === 'dosen') {
            $user = DospemModel::find($id);
        } elseif ($role === 'admin') {
            $user = AdminModel::find($id);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Role tidak valid.'
            ]);
        }

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User tidak ditemukan.'
            ]);
        }

        return view('user.edit_ajax', compact('user', 'roles', 'prodis', 'role'));
    }


    // public function update_ajax(Request $request, string $id) {
    //     if ($request->ajax() || $request->wantsJson()) {

    //         // Validasi dinamis untuk email berdasarkan role
    //         $emailRule = match ((int)$request->id_role) {
    //             3 => 'unique:mahasiswa,email,' . $id,
    //             2 => 'unique:dospem,email,' . $id,
    //             1 => 'unique:admin,email,' . $id,
    //             default => '',
    //         };

    //         $rules = [
    //             'id_role'    => 'required|exists:role,id_role',
    //             'nama'       => 'required|string|max:255',
    //             'email'      => ['required', 'email', $emailRule],
    //             'nim_nidn'   => 'required_if:id_role,2|required_if:id_role,3',
    //             'id_prodi'   => 'required_if:id_role,3',
    //         ];

    //         $validator = Validator::make($request->all(), $rules);

    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Validasi gagal.',
    //                 'msgField' => $validator->errors()
    //             ]);
    //         }

    //         try {
    //             $role = RoleModel::findOrFail($request->id_role);
    //             $data = [
    //                 'id_role' => $request->id_role,
    //                 'nama'    => $request->nama,
    //                 'email'   => $request->email,
    //             ];

    //             switch ($role->role_kode) {
    //                 case 'MHS':
    //                     $data['nim'] = $request->nim_nidn;
    //                     $data['id_prodi'] = $request->id_prodi;
    //                     $user = MahasiswaModel::findOrFail($id);
    //                     $user->update($data);
    //                     break;
    //                 case 'DSN':
    //                     $data['nidn'] = $request->nim_nidn;
    //                     $user = DospemModel::findOrFail($id);
    //                     $user->update($data);
    //                     break;
    //                 case 'ADM':
    //                     $user = AdminModel::findOrFail($id);
    //                     $user->update($data);
    //                     break;
    //                 default:
    //                     return response()->json([
    //                         'status' => false,
    //                         'message' => 'Role tidak valid.'
    //                     ]);
    //             }

    //             return response()->json([
    //                 'status' => true,
    //                 'message' => 'User berhasil diupdate.'
    //             ]);
    //         } catch (\Exception $e) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Terjadi kesalahan saat mengupdate data.',
    //                 'error'   => $e->getMessage(),
    //             ]);
    //         }
    //     }

    //     return redirect('/');
    // }

    public function update_ajax(Request $request, string $id, string $role) {
        // Validasi
        $validator = Validator::make($request->all(), [
            'id_role' => 'required|exists:role,id_role',
            'nama' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique($role === 'mahasiswa' ? 'mahasiswa' : ($role === 'dosen' ? 'dospem' : 'admin'), 'email')->ignore($id, $role === 'mahasiswa' ? 'id_mahasiswa' : ($role === 'dosen' ? 'id_dosen' : 'id_admin')),
            ],
            'nim_nidn' => $role !== 'admin' ? ['required', 'string', 'max:50'] : ['nullable'],
            'id_prodi' => $role === 'mahasiswa' ? ['required', 'exists:prodi,id_prodi'] : ['nullable'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }

        // Persiapan data update
        $data = [
            'id_role' => $request->id_role,
            'nama' => $request->nama,
            'email' => $request->email,
        ];

        if ($role === 'mahasiswa') {
            $data['nim'] = $request->nim_nidn;
            $data['id_prodi'] = $request->id_prodi;
            $user = MahasiswaModel::find($id);
        } elseif ($role === 'dosen') {
            $data['nidn'] = $request->nim_nidn;
            $user = DospemModel::find($id);
        } elseif ($role === 'admin') {
            $user = AdminModel::find($id);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Role tidak valid.'
            ]);
        }

        // Proses update
        if ($user) {
            try {
                $user->update($data);
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate.'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan saat mengupdate data.',
                    'error' => $e->getMessage()
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan.'
            ]);
        }
    }

    public function confirm_ajax(string $id, string $role) {
        $user = null;

        if ($role === 'mahasiswa') {
            $user = MahasiswaModel::find($id);
        } elseif ($role === 'dosen') {
            $user = DospemModel::find($id);
        } elseif ($role === 'admin') {
            $user = AdminModel::find($id);
        } else {
            abort(404, 'Role tidak ditemukan');
        }

        return view('user.confirm_ajax', compact('user', 'role'));
    }

    public function delete_ajax(Request $request, string $id, string $role) {
        if ($request->ajax() || $request->wantsJson()) {
            $user = null;

            if ($role === 'mahasiswa') {
                $user = MahasiswaModel::find($id);
            } elseif ($role === 'dosen') {
                $user = DospemModel::find($id);
            } elseif ($role === 'admin') {
                $user = AdminModel::find($id);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Role tidak valid',
                ]);
            }

            if ($user) {
                $user->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                ]);
            }
        }

        return redirect('/');
    }
}