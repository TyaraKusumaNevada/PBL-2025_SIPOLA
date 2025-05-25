<?php

namespace App\Http\Controllers;

use App\Models\PrestasiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

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

        $prestasis = PrestasiModel::where('id_mahasiswa', $user->id)
            ->select('id_prestasi', 'nama_prestasi', 'kategori_prestasi', 'tingkat_prestasi', 'penyelenggara', 'tanggal', 'status');

        return DataTables::of($prestasis)
            ->addIndexColumn()
            ->editColumn('tanggal', function ($data) {
                return \Carbon\Carbon::parse($data->tanggal)->format('d-m-Y');
            })
            ->editColumn('status', function ($data) {
                switch ($data->status) {
                    case 'pending':
                        return '<span class="badge bg-warning text-dark">Pending</span>';
                    case 'diterima':
                        return '<span class="badge bg-success">Diterima</span>';
                    case 'ditolak':
                        return '<span class="badge bg-danger">Ditolak</span>';
                    default:
                        return $data->status;
                }
            })
            ->rawColumns(['status']) // hanya status yang mengandung HTML
            ->make(true);
    }
}