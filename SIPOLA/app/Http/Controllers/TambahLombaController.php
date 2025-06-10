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

class TambahLombaController extends Controller
{
    public function index() {
        $breadcrumb = (object) [
            'title' => 'Kelola Lomba',
            'list'  => ['Home', 'Lomba']
        ];

        $lomba = TambahLombaModel::all();

        return view('lomba.index', ['breadcrumb' => $breadcrumb, 'lomba' => $lomba]);
    }

    public function list(Request $request) {
    $lombas = TambahLombaModel::select(
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
                'nama_lomba'         => 'required|string',
                'kategori_lomba'     => 'required|in:akademik,non-akademik',
                'tingkat_lomba'      => 'required|in:politeknik,kota,provinsi,nasional,internasional',
                'penyelenggara_lomba'=> 'required|string',
                'deskripsi'          => 'required|string',
                'tanggal_mulai'      => 'required|date',
                'tanggal_selesai'    => 'required|date|after_or_equal:tanggal_mulai',
                'link_pendaftaran'   => 'required|url|max:255',
                'pamflet_lomba'      => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
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
                'nama_lomba'         => 'required|string',
                'kategori_lomba'     => 'required|in:akademik,non-akademik',
                'tingkat_lomba'      => 'required|in:politeknik,kota,provinsi,nasional,internasional',
                'penyelenggara_lomba'=> 'required|string',
                'deskripsi'          => 'required|string',
                'tanggal_mulai'      => 'required|date',
                'tanggal_selesai'    => 'required|date|after_or_equal:tanggal_mulai',
                'link_pendaftaran'   => 'required|url|max:255', 
                'pamflet_lomba'      => 'nullable|image|max:2048',
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
}