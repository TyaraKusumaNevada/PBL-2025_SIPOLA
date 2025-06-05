<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\MahasiswaModel;
use App\Models\PrestasiModel;
use App\Models\TambahLombaModel;
use App\Models\RekomendasiModel;

class DashboardMahasiswaController extends Controller
{
    public function index()
    {
        // Ambil data mahasiswa yang sedang login
        $mahasiswa = MahasiswaModel::where('email', Auth::user()->email)->first();

        // Ambil ID mahasiswa
        $id = $mahasiswa->id_mahasiswa;

        return view('mahasiswa.dashboard', [
            'total_prestasi' => PrestasiModel::where('id_mahasiswa', $id)->count(),
            'prestasi_verified' => PrestasiModel::where('id_mahasiswa', $id)
                ->where('status', 'Disetujui')
                ->count(),
            'total_lomba_diikuti' => RekomendasiModel::where('id_mahasiswa', $id)->count(),
            'lomba_aktif' => TambahLombaModel::where('status_verifikasi', 'Disetujui')
                                ->whereDate('tanggal_selesai', '>=', now())
                                ->count(),
            'lomba_terbaru' => TambahLombaModel::where('status_verifikasi', 'Disetujui')
                                ->whereDate('tanggal_selesai', '>=', now())
                                ->orderBy('tanggal_mulai', 'asc')
                                ->get(),
            'riwayat_prestasi' => PrestasiModel::where('id_mahasiswa', $id)->latest('tanggal')->take(5)->get(),
            'mahasiswa' => $mahasiswa,
        ]);
    }
}
