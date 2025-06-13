<?php

namespace App\Http\Controllers;

use App\Models\MahasiswaModel;
use App\Models\DospemModel;
use App\Models\PrestasiModel;
use App\Models\TambahLombaModel;
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    public function index()
    {
        // Jumlah total
        $jumlah_mahasiswa = MahasiswaModel::count();
        $jumlah_dospem = DospemModel::count();
        $jumlah_prestasi = PrestasiModel::count();
        $jumlah_lomba_diikuti = TambahLombaModel::count();


        $lomba_aktif_diikuti = TambahLombaModel::whereHas('infoLomba', function ($q) {
            $q->whereDate('tanggal_selesai', '>=', now());
        })->count();

        // Prestasi terbaru (5 terakhir)
        $prestasi_terbaru = PrestasiModel::with('mahasiswa')
            ->latest('tanggal')
            ->take(5)
            ->get();

        // Lomba terbaru yang diikuti (5 terakhir)
        $lomba_terbaru = TambahLombaModel::with(['mahasiswa', 'infoLomba'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'jumlah_mahasiswa',
            'jumlah_dospem',
            'jumlah_prestasi',
            'jumlah_lomba_diikuti',
            'lomba_aktif_diikuti',
            'prestasi_terbaru',
            'lomba_terbaru'
        ));
    }
}
