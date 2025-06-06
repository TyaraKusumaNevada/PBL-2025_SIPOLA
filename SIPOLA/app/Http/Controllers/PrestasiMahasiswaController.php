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
// use Barryvdh\DomPDF\Facade\Pdf;

class PrestasiMahasiswaController extends Controller
{
    public function index() {
        $user = auth()->user();
        $idMahasiswa = $user->mahasiswa ? $user->mahasiswa->id_mahasiswa : null;

        $jumlahPrestasi = PrestasiModel::where('id_mahasiswa', $idMahasiswa)->count();

        $breadcrumb = (object)[
            'title' => $jumlahPrestasi == 0 ? 'Belum Ada Prestasi' : 'Histori Prestasi Anda',
            'list'  => ['Home', 'Prestasi']
        ];

        $verifikasiStatus = PrestasiModel::where('id_mahasiswa', $idMahasiswa)
            ->select('status')->distinct()->pluck('status');

        return view('prestasi.main', compact('breadcrumb', 'jumlahPrestasi', 'verifikasiStatus'));
    }

    public function list(Request $request) {
        Log::info('User login:', ['user' => auth()->user()]);
        $user = auth()->user();
        $idMahasiswa = $user->mahasiswa ? $user->mahasiswa->id_mahasiswa : null;

        $prestasis = PrestasiModel::where('id_mahasiswa', $idMahasiswa)
            ->select('id_prestasi', 'nama_prestasi', 'kategori_prestasi', 'tingkat_prestasi', 'juara', 'penyelenggara', 'tanggal', 'status');

        //filter berdasarkan status
        if ($request->status) {
            $prestasis->where('status', $request->status);
        }

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
                // Tampilkan tombol edit hanya jika status pending atau ditolak
                if (in_array($prestasi->status, ['pending', 'ditolak'])) {
                    $btn .= '<button onclick="modalAction(\''.url('/prestasi/' . $prestasi->id_prestasi . '/edit_ajax').'\')" class="btn btn-outline-warning btn-sm">
                                <i class="bi bi-pencil-square"></i><span class="ms-2">Edit</span>
                            </button> ';
                }
                        
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
                'tingkat_prestasi'  => 'required|in:politeknik,kota,provinsi,nasional,internasional',
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
                'reloadHistori' => true
            ]);
        }

        return redirect('/');
    }

    public function edit_ajax(string $id) {
        $prestasi = PrestasiModel::find($id);

        return view('prestasi.edit_ajax', ['prestasi' => $prestasi]);
    }

    public function update_ajax(Request $request, $id) {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_prestasi'     => 'required|string|max:255',
                'kategori_prestasi' => 'required|in:akademik,non-akademik',
                'tingkat_prestasi'  => 'required|in:politeknik,kota,provinsi,nasional,internasional',
                'juara'             => 'required|string|max:100',
                'penyelenggara'     => 'required|string|max:255',
                'tanggal'           => 'required|date',
                'bukti_file'        => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $prestasi = PrestasiModel::find($id);
            if (!$prestasi) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }

            // Update data
            $data = $request->only([
                'nama_prestasi',
                'kategori_prestasi',
                'tingkat_prestasi',
                'juara',
                'penyelenggara',
                'tanggal',
            ]);

            // Ubah status ke pending setiap kali ada perubahan
            $data['status'] = 'pending';

            if ($request->hasFile('bukti_file')) {
                // Hapus file lama jika ada
                if ($prestasi->bukti_file && Storage::disk('public')->exists($prestasi->bukti_file)) {
                    Storage::disk('public')->delete($prestasi->bukti_file);
                }

                $file = $request->file('bukti_file');
                $extension = $file->getClientOriginalExtension();
                $randomName = Str::uuid()->toString() . '.' . $extension;
                $filePath = $file->storeAs('buktiPrestasi', $randomName, 'public');
                $data['bukti_file'] = $filePath;
            }
            Log::info('Data yang akan diupdate:', $data);
            Log::info('Menghapus file lama: ' . $prestasi->bukti_file);
            $prestasi->update($data);

            return response()->json([
                'status' => true,
                'message' => 'Data prestasi berhasil diupdate'
            ]);
        }

        return redirect('/');
    }

    public function show_ajax(string $id) {
        $prestasi = PrestasiModel::find($id);

        return view('prestasi.show_ajax', ['prestasi' => $prestasi]);
    }

    // public function export_pdf() {
    //     $user = auth()->user();
    //     $idMahasiswa = $user->mahasiswa->id_mahasiswa ?? null;

    //     // Ambil data prestasi mahasiswa yang sedang login
    //     $prestasis = PrestasiModel::where('id_mahasiswa', $idMahasiswa)
    //         ->select('nama_prestasi', 'kategori_prestasi', 'tingkat_prestasi', 'juara', 'penyelenggara', 'tanggal', 'status')
    //         ->orderBy('tanggal', 'desc')
    //         ->get();

    //     // Load PDF dari view
    //     $pdf = Pdf::loadView('prestasi.export_pdf', compact('prestasis'));

    //     $pdf->setPaper('a4', 'portrait');
    //     $pdf->setOption("isRemoteEnabled", true);

    //     return $pdf->stream('Data_Prestasi_' . date('Y-m-d_H-i-s') . '.pdf');
    // }
}