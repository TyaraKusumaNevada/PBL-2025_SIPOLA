<?php

namespace App\Http\Controllers;

use App\Models\TambahLombaModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DospemLombaController extends Controller
{
    public function index() {
        $breadcrumb = (object) [
            'title' => 'Daftar Lomba Disetujui',
            'list'  => ['Home', 'Lomba']
        ];

        // Ambil lomba yang masih aktif
        $lomba = TambahLombaModel::where('status_verifikasi', 'Disetujui')
            ->where('tanggal_selesai', '>=', now())
            ->orderBy('tanggal_mulai', 'desc')
            ->get();

        return view('lombaDospem.index', [
            'breadcrumb' => $breadcrumb,
            'lombas' => $lomba
        ]);
    }

    public function show_info($id) {
        $lomba = TambahLombaModel::find($id);

        return view('lombaDospem.show_info', ['lomba' => $lomba]);
    }

    public function create_ajax() {
        return view('lombaDospem.create_ajax');
    }

    public function store_ajax(Request $request) {
        if ($request->ajax() || $request->wantsJson()) {
            // Validasi input
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
                    'status'   => false,
                    'message'  => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            // Upload pamflet dengan nama acak
            $file = $request->file('pamflet_lomba');
            $extension = $file->getClientOriginalExtension();
            $randomName = Str::uuid()->toString() . '.' . $extension;
            $filePath = $file->storeAs('pamflet_lomba', $randomName, 'public');

            // Default status = Pending
            $status = 'Pending';
            $userId = null;

            // Cek user login dan role
            if (auth()->check()) {
                $user = auth()->user();
                $userId = $user->id;

                // Jika role adalah admin (id_role == 1), langsung disetujui
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
                'status'        => true,
                'message'       => 'Data lomba berhasil disimpan.',
                'data'          => $tambahLomba,
                'reloadHistori' => true
            ]);
        }

        // Jika bukan AJAX, redirect ke halaman utama
        return redirect('/histori');
    }

    public function histori() {
        $breadcrumb = (object) [
            'title' => 'Histori Info Lomba',
            'list'  => ['Home', 'Lomba']
        ];

        // Ambil user yang sedang login
        $userId = auth()->id();

        // Ambil data lomba yang dibuat oleh user tersebut
        $lomba = TambahLombaModel::where('user_id', $userId)->get();

        return view('lombaDospem.histori', ['breadcrumb' => $breadcrumb, 'lomba' => $lomba]);
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
                'pamflet_lomba',
                'status_verifikasi'
            );

        return DataTables::of($lombas)
            ->addIndexColumn()
            ->addColumn('tanggal_mulai', fn ($row) => date('d M Y', strtotime($row->tanggal_mulai)))
            ->addColumn('tanggal_selesai', fn ($row) => date('d M Y', strtotime($row->tanggal_selesai)))
            ->addColumn('pamflet_lomba', function ($row) {
                if ($row->pamflet_lomba) {
                    $url = asset('storage/pamflet_lomba/' . $row->pamflet_lomba);
                    return '<img src="' . $url . '" width="60" style="cursor:pointer;" onclick="showPamfletModal(\'' . $url . '\')">';
                }
                return '<span class="text-muted">Tidak ada</span>';
            })
            ->addColumn('aksi', function ($lomba) {
                $btn  = '<button onclick="modalAction(\''.url('/lombaDospem/' . $lomba->id_tambahLomba . '/show_tambah').'\')" class="btn btn-info btn-sm">
                            <i class="bi bi-eye"></i><span class="ms-2">Detail</span>
                        </button>';
                return $btn;
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
            ->rawColumns(['aksi', 'pamflet_lomba', 'status_verifikasi'])
            ->make(true);
    }

    public function show_tambah($id) {
        $lomba = TambahLombaModel::find($id);

        return view('lombaDospem.show_tambah', ['lomba' => $lomba]);
    }
}