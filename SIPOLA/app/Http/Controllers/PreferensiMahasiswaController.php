<?php

namespace App\Http\Controllers;

use App\Models\BidangMinatModel;
use App\Models\BobotKriteriaMahasiswaModel;
use Illuminate\Http\Request;
use App\Models\PreferensiMahasiswaModel;
use Illuminate\Support\Facades\Auth;

class PreferensiMahasiswaController extends Controller
{
    // Menampilkan form preferensi
    public function showFormPreferensi()
    {
        $bidangMinat = BidangMinatModel::whereNull('parent_id')->get();
        return view('mahasiswa.rekomendasi.form_preferensi', compact('bidangMinat'));
    }

    // Menyimpan preferensi ke database
    public function storePreferensi(Request $request) {
        $request->validate([
            'bidang_minat_id' => 'required|exists:bidang_minat,id',
            'prefer_format' => 'required|string|in:online,offline,bebas',
            'prefer_tipe_lomba' => 'required|string|in:tim,individu,bebas',
            'max_biaya' => 'required|numeric|min:0',
            'min_hadiah' => 'required|numeric|min:0',
            'min_tingkat' => 'required|in:politeknik,kota,provinsi,nasional,internasional',
            'min_sisa_hari' => 'required|numeric|min:0',
        ]);

        PreferensiMahasiswaModel::updateOrCreate(
            ['user_id' => auth()->id()],
            $request->all() + ['user_id' => auth()->id()]
        );

        return response()->json(['success' => true]);
    }
    // public function storePreferensi(Request $request)
    // {
    //     $request->validate([
    //         'bidang_minat' => 'required|string|max:255',
    //         'prefer_format' => 'required|string|max:255',
    //         'max_biaya' => 'required|numeric|min:0',
    //         // tambahkan validasi lain jika kamu punya field tambahan
    //     ]);

    //     PreferensiMahasiswaModel::updateOrCreate(
    //         ['user_id' => auth()->id()],
    //         $request->all() + ['user_id' => auth()->id()]
    //     );

    //     return response()->json(['success' => true]);
    // }
    // public function create() {
    //     return view('mahasiswa.rekomendasi.form_bobot');
    // }

    // public function store(Request $request) {
    //     $request->validate([
    //         'bobot_biaya' => 'required|numeric',
    //         'bobot_hadiah' => 'required|numeric',
    //         'bobot_tingkat' => 'required|numeric',
    //         'bobot_sisa_hari' => 'required|numeric',
    //         'bobot_format' => 'required|numeric',
    //         'bobot_minat' => 'required|numeric',
    //     ]);

    //     BobotKriteriaMahasiswaModel::updateOrCreate(
    //         ['user_id' => auth()->id()],
    //         $request->all() + ['user_id' => auth()->id()]
    //     );

    //     return response()->json(['success' => 'Preferensi disimpan']);
    // }

    // public function edit() {
    //     $userId = Auth::id();
    //     $preferensi = PreferensiMahasiswaModel::firstOrNew(['user_id' => $userId]);

    //     return view('mahasiswa.preferensi.edit', compact('preferensi'));
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

}