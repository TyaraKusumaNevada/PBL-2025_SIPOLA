<?php

namespace App\Http\Controllers;

use App\Models\MahasiswaModel;
use App\Models\PrestasiModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class DospemController extends Controller
{
    public function index() {
        return view('dospem.mahasiswa_prestasi.index');
    }
    
    public function listMahasiswaPrestasi(Request $request) {
        $dosenId = auth()->user()->dosen->id_dosen ?? null;

        $data = MahasiswaModel::with(['user', 'prodi'])
            ->where('id_dosen', $dosenId)
            ->withCount('prestasi') // 👉 hitung jumlah prestasi
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nama', fn ($row) => $row->user->name ?? '-')
            ->addColumn('nim', fn ($row) => $row->nim ?? '-')
            ->addColumn('program_studi', fn ($row) => $row->prodi->nama_prodi ?? '-')
            ->addColumn('jumlah_prestasi', fn ($row) => $row->prestasi_count) //tampilkan jumlah prestasi
            ->addColumn('detail_prestasi', function ($row) {
                $url = route('dospem.mahasiswa_prestasi.detail', $row->id_mahasiswa); //route ke modal
                return '<button onclick="modalAction(`'.$url.'`)" class="btn btn-sm btn-info">Lihat Detail</button>';
            })
            ->rawColumns(['detail_prestasi'])
            ->make(true);
    }

    public function detailPrestasi($id) {
        $mahasiswa = MahasiswaModel::with(['prestasi'])->findOrFail($id);

        return view('dospem.partials.detail_prestasi', compact('mahasiswa'));
    }
}