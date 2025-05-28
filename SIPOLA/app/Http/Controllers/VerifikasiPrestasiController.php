<?php

namespace App\Http\Controllers;

use App\Models\PrestasiModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
    use Illuminate\Support\Facades\Validator;

class VerifikasiPrestasiController extends Controller
{
    public function index() {
        $breadcrumb = (object) [
            'title' => 'Verifikasi Prestasi',
            'list'  => ['Home', 'Verifikasi Prestasi']
        ]; 

        // $verifikasiPrestasi = VerifikasiPrestasiModel::all();
        $verifikasiStatus = PrestasiModel::select('status')->distinct()->pluck('status');

        return view('prestasiAdmin.index', ['breadcrumb' => $breadcrumb, 'verifikasiStatus' => $verifikasiStatus]
        );
    }

    public function list(Request $request) {
        $verifikasis = PrestasiModel::select('id_prestasi', 'nama_prestasi', 'kategori_prestasi', 'tingkat_prestasi', 'status', 'catatan', 'id_mahasiswa')
                        ->with('mahasiswa');

        //filter berdasarkan status
        if ($request->status) {
            $verifikasis->where('status', $request->status);
        }

        return DataTables::of($verifikasis)
            ->addIndexColumn()
            ->addColumn('nama', function ($row) {
                return $row->mahasiswa->nama ?? '-';
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
            ->addColumn('aksi', function ($verifikasi) {

                $btn  = '<button onclick="modalAction(\''.url('/prestasiAdmin/' . $verifikasi->id_prestasi . '/show_ajax').'\')" class="btn btn-outline-info btn-sm mb-2">
                            <i class="bi bi-eye"></i><span class="ms-2">Lihat Prestasi</span>
                        </button> ';
                switch (strtolower($verifikasi->status)) {
                    case 'divalidasi':
                        $btn .= '<button onclick="modalAction(\''.url('/prestasiAdmin/' . $verifikasi->id_prestasi . '/ubahStatus').'\')" class="btn btn-outline-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i><span class="ms-2">Lihat Status</span>
                                </button>';
                        break;

                    case 'ditolak':
                        $btn .= '<button onclick="modalAction(\''.url('/prestasiAdmin/' . $verifikasi->id_prestasi . '/ubahStatus').'\')" class="btn btn-outline-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i><span class="ms-2">Ubah Status</span>
                                </button>';
                        break;

                    default: // misalnya 'pending' atau status lain
                        $btn .= '<button onclick="modalAction(\''.url('/prestasiAdmin/' . $verifikasi->id_prestasi . '/ubahStatus').'\')" class="btn btn-outline-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i><span class="ms-2">Verifikasi</span>
                                </button>';
                        break;
                }
                return $btn;
            })
            ->rawColumns(['aksi', 'status']) // hanya status yang mengandung HTML
            ->make(true);
    }
    
    public function ubahStatus($id) {
        $data = PrestasiModel::findOrFail($id);
        return view('prestasiAdmin.form-ubah-status', compact('data'));
    }

    public function simpanStatus(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            // Aturan validasi
            $rules = [
                'status' => 'required|in:pending,divalidasi,ditolak',
                'catatan' => 'nullable|string|max:255'
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
            $data = PrestasiModel::find($id);
            if ($data) {
                $data->status = $request->status;
                $data->catatan = $request->catatan;
                $data->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Status prestasi berhasil diperbarui.'
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
}