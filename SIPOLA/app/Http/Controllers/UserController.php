<?php

namespace App\Http\Controllers;

use App\Models\RoleModel;
use App\Models\User;
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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
                'nomor_telepon' => $item->nomor_telepon,
                'role_user' => 'mahasiswa', // lowercase agar konsisten
            ];
        });

        $dospems = DospemModel::with('role')->get()->map(function ($item) {
            return [
                'id_user' => $item->id_dosen,
                'nomor_induk' => $item->nidn,
                'nama' => $item->nama,
                'nomor_telepon' => $item->nomor_telepon,
                'role_user' => 'dosen',
            ];
        });

        $admins = AdminModel::with('role')->get()->map(function ($item) {
            return [
                'id_user' => $item->id_admin,
                'nomor_induk' => '-',
                'nama' => $item->nama,
                'nomor_telepon' => $item->nomor_telepon,
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
                    $urlShow = url("/user/$id/$role/show_ajax");
                    $urlEdit = url("/user/$id/$role/edit_ajax");
                    $urlDelete = url("/user/$id/$role/delete_ajax");
                    // $urlReset = url("/user/{$id}/reset_ajax"); // route reset password
                    $urlReset = url("/user/{$id}/{$role}/reset_ajax");
                return '
                    <button onclick="modalAction(\'' . $urlShow . '\')" class="btn btn-info btn-sm">
                        <i class="bi bi-eye"></i><span class="ms-2">Detail</span>
                    </button>
                    <button onclick="modalAction(\''. $urlEdit .'\')" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil-square"></i><span class="ms-2">Edit</span>
                    </button>
                    <button onclick="modalAction(\''. $urlDelete .'\')" class="btn btn-danger btn-sm">
                        <i class="bi bi-trash"></i><span class="ms-2">Hapus</span>
                    </button>
                    <button onclick="resetPassword(\'' . $urlReset . '\')" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-counterclockwise"></i><span class="ms-2">Reset</span>
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
                'nomor_telepon'  => 'required|string|max:20',
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
                    'nomor_telepon'    => $request->nomor_telepon,
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
            'id_prodi' => $role === 'mahasiswa' ? ['required', 'exists:program_studi,id_prodi'] : ['nullable'],
            'nomor_telepon' => ['nullable', 'string', 'max:20'], // ✅ Validasi nomor telepon
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
            'nomor_telepon' => $request->nomor_telepon, // ✅ Tambahkan nomor telepon
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

    public function resetPassword_ajax(Request $request, $id, $role) {
        if (($request->ajax() || $request->wantsJson()) && auth()->user()->role === 'admin') {
            Log::info("Proses reset password dimulai untuk role '$role' dengan ID lokal: $id oleh admin ID: " . auth()->id());

            $userId = null;
            $data = null;

            try {
                if ($role === 'mahasiswa') {
                    $data = DB::table('mahasiswa')->where('id_mahasiswa', $id)->first();
                    if (!$data) {
                        Log::warning("Data mahasiswa dengan ID $id tidak ditemukan.");
                        return response()->json([
                            'status' => false,
                            'message' => 'Data mahasiswa tidak ditemukan.',
                        ]);
                    }
                    $userId = $data->user_id ?? null;

                } elseif ($role === 'dosen') {
                    $data = DB::table('dospem')->where('id_dosen', $id)->first();
                    if (!$data) {
                        Log::warning("Data dosen dengan ID $id tidak ditemukan.");
                        return response()->json([
                            'status' => false,
                            'message' => 'Data dosen tidak ditemukan.',
                        ]);
                    }

                    // Ambil user berdasarkan nidn == username
                    $user = DB::table('users')->where('username', $data->nidn)->first();
                    if (!$user) {
                        Log::warning("User tidak ditemukan berdasarkan nidn {$data->nidn}.");
                        return response()->json([
                            'status' => false,
                            'message' => 'User tidak ditemukan berdasarkan NIDN.',
                        ]);
                    }

                    $userId = $user->id;

                } elseif ($role === 'admin') {
                    $data = DB::table('admin')->where('id_admin', $id)->first();
                    if (!$data) {
                        Log::warning("Data admin dengan ID $id tidak ditemukan.");
                        return response()->json([
                            'status' => false,
                            'message' => 'Data admin tidak ditemukan.',
                        ]);
                    }
                    $userId = $data->user_id ?? null;

                } else {
                    Log::warning("Role tidak valid: $role");
                    return response()->json([
                        'status' => false,
                        'message' => 'Role tidak valid.',
                    ]);
                }

                if (!$userId) {
                    Log::warning("User ID tidak ditemukan untuk role $role dengan ID lokal $id.");
                    return response()->json([
                        'status' => false,
                        'message' => 'User ID tidak ditemukan.',
                    ]);
                }

                DB::table('users')->where('id', $userId)->update([
                    'password' => Hash::make('sipola123'),
                ]);
                Log::info("Password user (users.id = $userId) berhasil diupdate.");

                // Update password di tabel lokal juga
                if ($role === 'mahasiswa') {
                    DB::table('mahasiswa')->where('id_mahasiswa', $id)->update([
                        'password' => Hash::make('sipola123'),
                    ]);
                    Log::info("Password mahasiswa (id_mahasiswa = $id) berhasil diupdate.");
                } elseif ($role === 'dosen') {
                    DB::table('dospem')->where('id_dosen', $id)->update([
                        'password' => Hash::make('sipola123'),
                    ]);
                    Log::info("Password dosen (id_dosen = $id) berhasil diupdate.");
                } elseif ($role === 'admin') {
                    DB::table('admin')->where('id_admin', $id)->update([
                        'password' => Hash::make('sipola123'),
                    ]);
                    Log::info("Password admin (id_admin = $id) berhasil diupdate.");
                }

                Log::info("Reset password berhasil untuk user ID: $userId oleh admin ID: " . auth()->id());

                return response()->json([
                    'status' => true,
                    'message' => 'Password berhasil direset ke "sipola123".',
                ]);

            } catch (\Exception $e) {
                Log::error("Terjadi kesalahan saat reset password untuk $role ID: $id. Pesan: " . $e->getMessage());
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan saat reset password.',
                ], 500);
            }
        }

        Log::warning("Akses reset password ditolak. Request tidak berasal dari admin atau bukan AJAX.");
        return response()->json([
            'status' => false,
            'message' => 'Unauthorized.',
        ], 403);
    }
}