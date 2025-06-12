<?php

namespace App\Http\Controllers;

use App\Models\PrestasiModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanPrestasiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Laporan Prestasi',
            'list'  => ['Home', 'Laporan & Analisis Prestasi']
        ];
        
        $kategoriLomba = ['akademik', 'non-akademik'];
        return view('admin.laporan.index', compact('breadcrumb', 'kategoriLomba'));

    }

    public function list(Request $request)
    {
        $prestasis = PrestasiModel::with('mahasiswa');

        // Filter kategori jika ada
        if ($request->has('kategori') && $request->kategori != '') {
            $prestasis->where('kategori_prestasi', $request->kategori);
        }

        return DataTables::eloquent($prestasis)
            ->addIndexColumn()
            ->addColumn('nama', fn($row) => $row->mahasiswa->nama ?? '-')
            ->addColumn('nama_prestasi', fn($row) => $row->nama_prestasi ?? '-')
            ->addColumn('kategori_prestasi', fn($row) => $row->kategori_prestasi ?? '-')
            ->addColumn('tingkat_prestasi', fn($row) => $row->tingkat_prestasi ?? '-')
            ->editColumn('status', fn($row) => match ($row->status) {
                'pending' => '<span class="badge bg-warning">Pending</span>',
                'divalidasi' => '<span class="badge bg-success">Divalidasi</span>',
                'ditolak' => '<span class="badge bg-danger">Ditolak</span>',
                default => $row->status,
            })
            ->addColumn('catatan', fn($row) => $row->catatan ?? '-')
            ->rawColumns(['status'])
            ->make(true);
    }

    public function grafik()
    {
        $statistik = PrestasiModel::selectRaw('kategori_prestasi, COUNT(*) as total')
            ->groupBy('kategori_prestasi')
            ->pluck('total', 'kategori_prestasi');

        return response()->json($statistik);
    }

public function statistikBox(Request $request)
{
    $kategori = $request->kategori;

    $query = PrestasiModel::query();
    if ($kategori) {
        $query->where('kategori_prestasi', $kategori);
    }

    return response()->json([
        'mahasiswa' => $query->distinct('mahasiswa_id')->count('mahasiswa_id'),
        'total' => $query->count(),
        'divalidasi' => $query->where('status', 'divalidasi')->count(),
        'pending' => $query->where('status', 'pending')->count(),
    ]);
}

    public function exportPdf()
    {
        $prestasi = PrestasiModel::with('mahasiswa')->get();
        $pdf = Pdf::loadView('admin.laporan.export_pdf', compact('prestasi'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('Laporan_Prestasi_' . date('Y-m-d_H-i-s') . '.pdf');
    }
}
