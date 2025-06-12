<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\MahasiswaModel;
use App\Models\PrestasiModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function filterView() {
        $kategori_prestasi = PrestasiModel::select('kategori_prestasi')->distinct()->pluck('kategori_prestasi');
        $tahun = PrestasiModel::selectRaw('YEAR(tanggal) as tahun')->distinct()->pluck('tahun');

        return view('dospem.prestasi_filter.index', compact('kategori_prestasi', 'tahun'));
    }

    public function filterData(Request $request) {
        // Ambil data dosen dari user login
        $dosen = Auth::user()->dosen;

        if (!$dosen) {
            Log::warning('User login bukan dosen. User ID: ' . Auth::id());
            return DataTables::of(collect())->make(true);
        }

        $idDosen = $dosen->id_dosen; // 👈 gunakan id_dosen, bukan id

        // Log untuk debugging
        Log::info('Dosen login:', [
            'user_id' => Auth::id(),
            'username' => Auth::user()->username,
            'id_dosen' => $idDosen,
            'nama_dosen' => $dosen->nama ?? '(nama kosong)',
        ]);

        // Ambil prestasi mahasiswa yang dibimbing dosen ini
        $query = PrestasiModel::with('mahasiswa')
            ->whereHas('mahasiswa', function ($q) use ($idDosen) {
                $q->where('id_dosen', $idDosen);
            });

        // Filter kategori prestasi jika ada
        if ($request->kategori_prestasi) {
            $query->where('kategori_prestasi', $request->kategori_prestasi);
        }

        // Filter tahun prestasi jika ada
        if ($request->tahun) {
            $query->whereYear('tanggal', $request->tahun);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('nama', function ($row) {
                return $row->mahasiswa->nama ?? '-';
            })
            ->addColumn('nim', function ($row) {
                return $row->mahasiswa->nim ?? '-';
            })
            ->editColumn('tanggal', function ($row) {
                return date('d-m-Y', strtotime($row->tanggal));
            })
            ->make(true);
    }
}