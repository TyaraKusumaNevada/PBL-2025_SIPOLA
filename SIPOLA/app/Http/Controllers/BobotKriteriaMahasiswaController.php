<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BobotKriteriaMahasiswaModel;
use Illuminate\Support\Facades\Auth;

class BobotKriteriaMahasiswaController extends Controller
{
    // public function edit() {
    //     $userId = Auth::id();
    //     $bobot = PreferensiMahasiswaModel::firstOrNew(['user_id' => $userId]);

    //     return view('mahasiswa.bobot.edit', compact('bobot'));
    // }

    // public function update(Request $request) {
    //     $userId = Auth::id();

    //     $request->validate([
    //         'bidang_minat' => 'nullable|string|max:100',
    //         'prefer_format' => 'required|in:online,offline,bebas',
    //         'prefer_tipe_lomba' => 'required|in:tim,individu,bebas',
    //         'max_biaya' => 'required|integer|min:0',
    //         'min_hadiah' => 'required|integer|min:0',
    //         'min_tingkat' => 'required|in:politeknik,kota,provinsi,nasional,internasional',
    //         'min_sisa_hari' => 'required|integer|min:0',
    //     ]);

    //     PreferensiMahasiswaModel::updateOrCreate(
    //         ['user_id' => $userId],
    //         $request->only(['bidang_minat', 'prefer_format', 'prefer_tipe_lomba', 'max_biaya', 'min_hadiah', 'min_tingkat', 'min_sisa_hari'])
    //     );

    //     return redirect()->back()->with('success', 'Preferensi berhasil diperbarui.');
    // }

    // Tampilkan form bobot mahasiswa
    // public function create()
    // {
    //     $userId = Auth::id();

    //     // Cek apakah user sudah pernah isi bobot sebelumnya
    //     $bobot = BobotKriteriaMahasiswaModel::where('user_id', $userId)->first();

    //     return view('mahasiswa.rekomendasi.form_bobot', compact('bobot'));
    // }

    // // Simpan atau update bobot mahasiswa
    // public function store(Request $request)
    // {
    //     $userId = Auth::id();

    //     $validated = $request->validate([
    //         'bobot_biaya'     => 'required|numeric|min:0|max:100',
    //         'bobot_hadiah'    => 'required|numeric|min:0|max:100',
    //         'bobot_tingkat'   => 'required|numeric|min:0|max:100',
    //         'bobot_sisa_hari' => 'required|numeric|min:0|max:100',
    //         'bobot_format'    => 'required|numeric|min:0|max:100',
    //         'bobot_minat'     => 'required|numeric|min:0|max:100',
    //     ]);

    //     BobotKriteriaMahasiswaModel::updateOrCreate(
    //         ['user_id' => $userId],
    //         $validated + ['user_id' => $userId]
    //     );

    //     return redirect()->back()->with('success', 'Bobot berhasil disimpan!');
    // }
    // Tampilkan form bobot
    public function create()
    {
        $userId = Auth::id();

        // Ambil data bobot jika sudah pernah disimpan
        $bobot = BobotKriteriaMahasiswaModel::where('user_id', $userId)->first();

        return view('mahasiswa.rekomendasi.form_bobot', compact('bobot'));
    }

    // Simpan atau update bobot
    public function store(Request $request)
    {
        $userId = Auth::id();

        $validated = $request->validate([
            'bobot_biaya'      => 'required|numeric|min:0|max:1',
            'bobot_hadiah'     => 'required|numeric|min:0|max:1',
            'bobot_tingkat'    => 'required|numeric|min:0|max:1',
            'bobot_sisa_hari'  => 'required|numeric|min:0|max:1',
            'bobot_format'     => 'required|numeric|min:0|max:1',
            'bobot_minat'      => 'required|numeric|min:0|max:1',
            'bobot_tipe_lomba' => 'required|numeric|min:0|max:1',
        ]);

        // Cek apakah totalnya <= 1.0
        $total = array_sum($validated);
        if ($total > 1) {
            return redirect()->back()->withInput()->withErrors(['total' => 'Total bobot tidak boleh lebih dari 1.0']);
        }

        BobotKriteriaMahasiswaModel::updateOrCreate(
            ['user_id' => $userId],
            $validated + ['user_id' => $userId]
        );

        return redirect()->route('mahasiswa.rekomendasi.hasil')->with('success', 'Bobot berhasil disimpan!');
    }
}
