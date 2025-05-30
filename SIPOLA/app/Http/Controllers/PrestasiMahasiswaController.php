<?php

namespace App\Http\Controllers;

use App\Models\PrestasiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class PrestasiMahasiswaController extends Controller
{
    public function index() {
        $breadcrumb = (object) [
            'title' => 'Histori Prestasi Anda',
            'list'  => ['Home', 'Prestasi']
        ]; 

        $prestasi = PrestasiModel::all();

        return view('prestasi.histori', ['breadcrumb' => $breadcrumb, 'prestasi' => $prestasi]
        );
    }

    public function list(Request $request) {
        Log::info('User login:', ['user' => auth()->user()]);
        $user = auth()->user();
        $idMahasiswa = $user->mahasiswa ? $user->mahasiswa->id_mahasiswa : null;

        $prestasis = PrestasiModel::where('id_mahasiswa', $idMahasiswa)
            ->select('id_prestasi', 'nama_prestasi', 'kategori_prestasi', 'tingkat_prestasi', 'juara', 'penyelenggara', 'tanggal', 'status');

        return DataTables::of($prestasis)
            ->addIndexColumn()
            ->editColumn('tanggal', function ($data) {
                return \Carbon\Carbon::parse($data->tanggal)->format('d-m-Y');
            })
            ->editColumn('status', function ($data) {
                switch ($data->status) {
                    case 'pending':
                        return '<span class="badge bg-warning">Pending</span>';
                    case 'divalidasi':
                        return '<span class="badge bg-success">Divalidasi</span>';
                    case 'ditolak':
                        return '<span class="badge bg-danger">Ditolak</span>';
                    default:
                        return $data->status;
                }
            })
            ->addColumn('aksi', function ($prestasi) {
                $btn  = '<button onclick="modalAction(\''.url('/prestasi/' . $prestasi->id_prestasi . '/show_ajax').'\')" class="btn btn-outline-info btn-sm">
                            <i class="bi bi-eye"></i><span class="ms-2">Detail</span>
                        </button> ';
                $btn .= '<button onclick="modalAction(\''.url('/prestasi/' . $prestasi->id_prestasi . '/edit_ajax').'\')" class="btn btn-outline-warning btn-sm">
                            <i class="bi bi-pencil-square"></i><span class="ms-2">Edit</span>
                        </button> ';
                        
                return $btn;
            })
            ->rawColumns(['status', 'aksi'])
            ->make(true);
    }

    public function create_ajax() {
        return view('prestasi.create_ajax');
    }

    public function store_ajax(Request $request) {
        if ($request->ajax() || $request->wantsJson()) {
            $mahasiswa = Auth::user()->mahasiswa;
            if (!$mahasiswa) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data mahasiswa tidak ditemukan untuk user ini.',
                ]);
            }

            // Validasi
            $rules = [
                'nama_prestasi'     => 'required|string|max:255',
                'kategori_prestasi' => 'required|in:akademik,non-akademik',
                'tingkat_prestasi'  => 'required|in:politeknik,kota,nasional,internasional',
                'juara'             => 'required|string|max:100',
                'penyelenggara'     => 'required|string|max:255',
                'tanggal'           => 'required|date',
                'bukti_file'        => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            // === Upload dengan nama acak ===
            $file = $request->file('bukti_file');
            $extension = $file->getClientOriginalExtension();
            $randomName = Str::uuid()->toString() . '.' . $extension;
            $filePath = $file->storeAs('buktiPrestasi', $randomName, 'public');

            // Simpan ke database
            $prestasi = PrestasiModel::create([
                'id_mahasiswa'      => $mahasiswa->id_mahasiswa,
                'nama_prestasi'     => $request->nama_prestasi,
                'kategori_prestasi' => $request->kategori_prestasi,
                'tingkat_prestasi'  => $request->tingkat_prestasi,
                'juara'             => $request->juara,
                'penyelenggara'     => $request->penyelenggara,
                'tanggal'           => $request->tanggal,
                'bukti_file'        => $filePath, 
                'status'            => 'pending',
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Data prestasi berhasil disimpan',
                'data' => $prestasi,
            ]);
        }

        return redirect('/');
    }
}