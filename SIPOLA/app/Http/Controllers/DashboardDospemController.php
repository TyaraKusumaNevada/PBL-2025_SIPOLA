<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\DospemModel;
use App\Models\MahasiswaModel;
use App\Models\PrestasiModel;

class DashboardDospemController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->withErrors('Silakan login terlebih dahulu.');
        }

        // Cari dosen berdasarkan username (yang menyimpan NIDN)
        $dosen = DospemModel::where('nidn', $user->username)->first();

        if (!$dosen) {
            abort(403, 'Data dosen tidak ditemukan.');
        }

        $id_dosen = $dosen->id_dosen;

        // Ambil semua mahasiswa bimbingan
        $mahasiswa_bimbingan = MahasiswaModel::where('id_dosen', $id_dosen)->pluck('id_mahasiswa');

        return view('dospem.dashboard', [
            'total_mahasiswa' => $mahasiswa_bimbingan->count(),
            'total_prestasi' => PrestasiModel::whereIn('id_mahasiswa', $mahasiswa_bimbingan)->count(),
            'prestasi_disetujui' => PrestasiModel::whereIn('id_mahasiswa', $mahasiswa_bimbingan)
                                                ->where('status', 'Disetujui')->count(),
            'prestasi_pending' => PrestasiModel::whereIn('id_mahasiswa', $mahasiswa_bimbingan)
                                                ->where('status', 'Pending')->count(),
            'recent_prestasi' => PrestasiModel::with('mahasiswa')
                                            ->whereIn('id_mahasiswa', $mahasiswa_bimbingan)
                                            ->latest('tanggal')->take(5)->get(),
            'dosen' => $dosen
        ]);
    }
}