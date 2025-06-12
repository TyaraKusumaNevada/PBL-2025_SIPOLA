<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TambahLombaModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AdminLombaController extends Controller
{
    public function index() {
        $breadcrumb = (object) [
            'title' => 'Kelola Lomba',
            'list'  => ['Home', 'Lomba']
        ];

        // Ambil user yang sedang login
        $userId = auth()->id();

        // Ambil data lomba yang dibuat oleh user tersebut
        $lomba = TambahLombaModel::where('user_id', $userId)->get();

        return view('lomba.index', ['breadcrumb' => $breadcrumb, 'lomba' => $lomba]);
    }

    public function list(Request $request) {
        $user = auth()->user();

        $lombas = TambahLombaModel::query()
            ->where('user_id', $user->id) // filter by user login
            ->select(
            'id_tambahLomba',
            'nama_lomba',
            'kategori_lomba',
            'tingkat_lomba',
            'penyelenggara_lomba',
            'deskripsi',
            'tanggal_mulai',
            'tanggal_selesai',
            'link_pendaftaran',
            'pamflet_lomba'
        );

        return DataTables::of($lombas)
            ->addIndexColumn()
            ->addColumn('tanggal_mulai', function ($row) {
                return date('d M Y', strtotime($row->tanggal_mulai));
            })
            ->addColumn('tanggal_selesai', function ($row) {
                return date('d M Y', strtotime($row->tanggal_selesai));
            })
            ->addColumn('pamflet_lomba', function ($row) {
                if ($row->pamflet_lomba) {
                    return '<img src="' . asset('storage/pamflet_lomba/' . $row->pamflet_lomba) . '" width="60">';
                }
                return '<span class="text-muted">Tidak ada</span>';
            })
            ->addColumn('aksi', function ($lomba) {

                $btn  = '<button onclick="modalAction(\''.url('/lomba/' . $lomba->id_tambahLomba . '/show_ajax').'\')" class="btn btn-info btn-sm">
                            <i class="bi bi-eye"></i><span class="ms-2">Detail</span>
                        </button> ';
                $btn .= '<button onclick="modalAction(\''.url('/lomba/' . $lomba->id_tambahLomba . '/edit_ajax').'\')" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i><span class="ms-2">Edit</span>
                        </button> ';
                $btn .= '<button onclick="modalAction(\''.url('/lomba/' . $lomba->id_tambahLomba . '/delete_ajax').'\')" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i><span class="ms-2">Hapus</span>
                        </button>';
                        
                return $btn;
            })
            ->addColumn('pamflet_lomba', function ($row) {
                if ($row->pamflet_lomba) {
                    $url = asset('storage/pamflet_lomba/' . $row->pamflet_lomba);
                    return '<img src="' . $url . '" width="60" style="cursor:pointer;" onclick="showPamfletModal(\'' . $url . '\')">';
                }
                return '<span class="text-muted">Tidak ada</span>';
            })


            ->rawColumns(['aksi', 'pamflet_lomba']) // ⬅️ tambahkan pamflet_lomba
            ->make(true);
    }


    public function create_ajax() {
        return view('lomba.create_ajax');
    }

    public function store_ajax(Request $request) {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_lomba'          => 'required|string|max:100',     //cegah injection
                'kategori_lomba'      => 'required|in:akademik,non-akademik',
                'tingkat_lomba'       => 'required|in:politeknik,kota,provinsi,nasional,internasional',
                'penyelenggara_lomba' => 'required|string|max:100',     //cegah injection
                'deskripsi'           => 'required|string|max:100',    //cegah injection
                'tanggal_mulai'       => 'required|date',
                'tanggal_selesai'     => 'required|date|after_or_equal:tanggal_mulai',
                'link_pendaftaran'    => 'nullable|url|max:100',
                'pamflet_lomba'       => 'required|file|mimes:jpg,jpeg,png|max:5120',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

             // === Upload dengan nama acak ===
            $file = $request->file('pamflet_lomba');
            $extension = $file->getClientOriginalExtension();
            $randomName = Str::uuid()->toString() . '.' . $extension;
            $filePath = $file->storeAs('pamflet_lomba', $randomName, 'public');

            $status = 'Pending'; // default status
            $userId = null;

            if (auth()->check()) {
                $user = auth()->user();
                $userId = $user->id;

                // Misal id_role 1 adalah admin
                if ($user->id_role == 1) {
                    $status = 'Disetujui';
                }
            }

            // Simpan ke database
            $tambahLomba = TambahLombaModel::create([
                'nama_lomba'          => $request->nama_lomba,
                'kategori_lomba'      => $request->kategori_lomba,
                'tingkat_lomba'       => $request->tingkat_lomba,
                'penyelenggara_lomba' => $request->penyelenggara_lomba,
                'deskripsi'           => $request->deskripsi,
                'tanggal_mulai'       => $request->tanggal_mulai,
                'tanggal_selesai'     => $request->tanggal_selesai,
                'link_pendaftaran'    => $request->link_pendaftaran,
                'pamflet_lomba'       => $filePath,
                'status_verifikasi'   => $status,
                'user_id'             => $userId,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Data lomba berhasil disimpan',
                'data' => $tambahLomba,
                'reloadHistori' => true
            ]);
        }

        return redirect('/');
    }

    public function show_ajax($id) {
        $lomba = TambahLombaModel::find($id);

        return view('lomba.show_ajax', ['lomba' => $lomba]);
    }

    public function edit_ajax($id) {
        $lomba = TambahLombaModel::find($id);

        return view('lomba.edit_ajax', ['lomba' => $lomba]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_lomba'          => 'required|string|max:100',     //cegah injection
                'kategori_lomba'      => 'required|in:akademik,non-akademik',
                'tingkat_lomba'       => 'required|in:politeknik,kota,provinsi,nasional,internasional',
                'penyelenggara_lomba' => 'required|string|max:100',     //cegah injection
                'deskripsi'           => 'required|string|max:100',    //cegah injection
                'tanggal_mulai'       => 'required|date',
                'tanggal_selesai'     => 'required|date|after_or_equal:tanggal_mulai',
                'link_pendaftaran'    => 'nullable|url|max:100',
                'pamflet_lomba'       => 'required|file|mimes:jpg,jpeg,png|max:5120',
                // 'status_verifikasi'  => 'required|in:Pending,Disetujui,Ditolak'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $lomba = TambahLombaModel::find($id);
            if (!$lomba) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data lomba tidak ditemukan'
                ]);
            }
                
            // Update data
            $data = $request->only([
                'nama_lomba',
                'kategori_lomba',
                'tingkat_lomba',
                'penyelenggara_lomba',
                'deskripsi', 
                'tanggal_mulai',
                'tanggal_selesai',
                'link_pendaftaran',
            ]);

            if ($request->hasFile('pamflet_lomba')) {
                // Hapus file lama jika ada
                if ($lomba->pamflet_lomba && Storage::disk('public')->exists($lomba->pamflet_lomba)) {
                    Storage::disk('public')->delete($lomba->pamflet_lomba);
                }

                $file = $request->file('pamflet_lomba');
                $extension = $file->getClientOriginalExtension();
                $randomName = Str::uuid()->toString() . '.' . $extension;
                $filePath = $file->storeAs('pamflet_lomba', $randomName, 'public');
                $data['pamflet_lomba'] = $filePath;
            }

            Log::info('Data yang akan diupdate:', $data);
            Log::info('Menghapus file lama: ' . $lomba->pamflet_lomba);
            $lomba->update($data);

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diperbarui'
            ]);
        }

        return redirect('/');
    }

    public function confirm_ajax(string $id) {
        $lomba = TambahLombaModel::find($id);

        return view('lomba.confirm_ajax', ['lomba' => $lomba]);
    }

    public function delete_ajax(Request $request, $id) {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $lomba = TambahLombaModel::find($id);
            if ($lomba) {
                // hapus file pamflet jika ada
                if ($lomba->pamflet_lomba && Storage::disk('public')->exists($lomba->pamflet_lomba)) {
                    Storage::disk('public')->delete($lomba->pamflet_lomba);
                }

                // hapus data lomba
                $lomba->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }

        return redirect('/');
    }

    public function indexVerifikasi() {
        $breadcrumb = (object) [
            'title' => 'Verifikasi Lomba',
            'list'  => ['Home', 'Verifikasi Lomba']
        ];

        $verifikasiLomba = TambahLombaModel::all();

        return view('lomba.verifikasi.index', ['breadcrumb' => $breadcrumb, 'verifikasiLomba' => $verifikasiLomba]);
    }

    public function listVerifikasi(Request $request) {
        $verifikasis = TambahLombaModel::select('id_tambahLomba', 'nama_lomba', 'penyelenggara_lomba', 'kategori_lomba', 'tingkat_lomba', 'status_verifikasi', 'user_id')
            ->with('user')
            ->whereHas('user', function ($query) {
                $query->whereIn('id_role', [2, 3]);
            });

        return DataTables::of($verifikasis)
            ->addIndexColumn()
            ->addColumn('name', function ($row) {
                return $row->user->name ?? '-';
            })
            ->editColumn('status_verifikasi', function ($data) {
                switch ($data->status_verifikasi) {
                    case 'Pending':
                        return '<span class="badge bg-warning">Pending</span>';
                    case 'Disetujui':
                        return '<span class="badge bg-success">Disetujui</span>';
                    case 'Ditolak':
                        return '<span class="badge bg-danger">Ditolak</span>';
                    default:
                        return $data->status_verifikasi;
                }
            })
            ->addColumn('aksi', function ($verifikasi) {
                $btn  = '<button onclick="modalAction(\''.url('/lomba/verifikasi/' . $verifikasi->id_tambahLomba . '/showVerifikasi').'\')" class="btn btn-outline-info btn-sm mb-2">
                            <i class="bi bi-eye"></i><span class="ms-2">Detail</span>
                        </button> ';

                $btn .= '<button onclick="modalAction(\''.url('/lomba/verifikasi/' . $verifikasi->id_tambahLomba . '/editVerifikasi').'\')" class="btn btn-outline-warning btn-sm mb-2">
                            <i class="bi bi-pencil-square"></i><span class="ms-2">Edit</span>
                        </button> ';
                    
                $btn .= '<button onclick="modalAction(\''.url('/lomba/verifikasi/' . $verifikasi->id_tambahLomba . '/deleteVerifikasi').'\')" class="btn btn-outline-danger btn-sm mb-2">
                            <i class="bi bi-trash"></i><span class="ms-2">Hapus</span>
                        </button>';

                switch ($verifikasi->status_verifikasi) {
                    case 'Disetujui':
                        $btn .= '<button onclick="modalAction(\''.url('/lomba/verifikasi/' . $verifikasi->id_tambahLomba . '/ubahStatus').'\')" class="btn btn-outline-success btn-sm mb-2">
                                    <i class="bi bi-pencil-square"></i><span class="ms-2">Lihat Status</span>
                                </button>';
                        break;

                    case 'Ditolak':
                        $btn .= '<button onclick="modalAction(\''.url('/lomba/verifikasi/' . $verifikasi->id_tambahLomba . '/ubahStatus').'\')" class="btn btn-outline-success btn-sm mb-2">
                                    <i class="bi bi-pencil-square"></i><span class="ms-2">Ubah Status</span>
                                </button>';
                        break;

                    default: // misalnya 'pending' atau status lain
                        $btn .= '<button onclick="modalAction(\''.url('/lomba/verifikasi/' . $verifikasi->id_tambahLomba . '/ubahStatus').'\')" class="btn btn-outline-success btn-sm mb-2">
                                    <i class="bi bi-pencil-square"></i><span class="ms-2">Verifikasi</span>
                                </button>';
                        break;
                }
                return $btn;
            })
            ->rawColumns(['status_verifikasi', 'aksi'])
            ->make(true);
    }

    public function ubahStatus($id) {
        $lomba = TambahLombaModel::findOrFail($id);
        return view('lomba.verifikasi.ubahStatus', compact('lomba'));
    }

    public function simpanStatus(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            // Aturan validasi
            $rules = [
                'status_verifikasi' => 'required|in:Pending,Disetujui,Ditolak'
            ];

            // Proses validasi manual
            $validator = Validator::make($request->all(), $rules);

            // Jika validasi gagal
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            // Proses update data
            $lomba = TambahLombaModel::find($id);
            if ($lomba) {
                $lomba->status_verifikasi = $request->status_verifikasi;
                $lomba->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Status lomba berhasil diperbarui.'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan.'
                ]);
            }
        }

        // Redirect jika bukan AJAX
        return redirect('/');
    }

    public function showVerifikasi($id) {
        $lomba = TambahLombaModel::find($id);

        return view('lomba.verifikasi.show', ['lomba' => $lomba]);
    }

    public function editVerifikasi($id) {
        $lomba = TambahLombaModel::find($id);

        return view('lomba.verifikasi.edit', ['lomba' => $lomba]);
    }

    public function updateVerifikasi(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_lomba'          => 'required|string|max:100',     //cegah injection
                'kategori_lomba'      => 'required|in:akademik,non-akademik',
                'tingkat_lomba'       => 'required|in:politeknik,kota,provinsi,nasional,internasional',
                'penyelenggara_lomba' => 'required|string|max:100',     //cegah injection
                'deskripsi'           => 'required|string|max:100',    //cegah injection
                'tanggal_mulai'       => 'required|date',
                'tanggal_selesai'     => 'required|date|after_or_equal:tanggal_mulai',
                'link_pendaftaran'    => 'nullable|url|max:100',
                'pamflet_lomba'       => 'required|file|mimes:jpg,jpeg,png|max:5120',
                // 'status_verifikasi'  => 'required|in:Pending,Disetujui,Ditolak'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $lomba = TambahLombaModel::find($id);
            if (!$lomba) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data lomba tidak ditemukan'
                ]);
            }
                
            // Update data
            $data = $request->only([
                'nama_lomba',
                'kategori_lomba',
                'tingkat_lomba',
                'penyelenggara_lomba',
                'deskripsi', 
                'tanggal_mulai',
                'tanggal_selesai',
                'link_pendaftaran',
            ]);

            if ($request->hasFile('pamflet_lomba')) {
                // Hapus file lama jika ada
                if ($lomba->pamflet_lomba && Storage::disk('public')->exists($lomba->pamflet_lomba)) {
                    Storage::disk('public')->delete($lomba->pamflet_lomba);
                }

                $file = $request->file('pamflet_lomba');
                $extension = $file->getClientOriginalExtension();
                $randomName = Str::uuid()->toString() . '.' . $extension;
                $filePath = $file->storeAs('pamflet_lomba', $randomName, 'public');
                $data['pamflet_lomba'] = $filePath;
            }

            Log::info('Data yang akan diupdate:', $data);
            Log::info('Menghapus file lama: ' . $lomba->pamflet_lomba);
            $lomba->update($data);

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diperbarui'
            ]);
        }

        return redirect('/');
    }

    public function confirmVerifikasi(string $id) {
        $lomba = TambahLombaModel::find($id);

        return view('lomba.verifikasi.confirm', ['lomba' => $lomba]);
    }

    public function deleteVerifikasi(Request $request, $id) {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $lomba = TambahLombaModel::find($id);
            if ($lomba) {
                // hapus file pamflet jika ada
                if ($lomba->pamflet_lomba && Storage::disk('public')->exists($lomba->pamflet_lomba)) {
                    Storage::disk('public')->delete($lomba->pamflet_lomba);
                }

                // hapus data lomba
                $lomba->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }

        return redirect('/');
    }
}