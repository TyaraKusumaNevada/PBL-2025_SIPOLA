<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PreferensiMahasiswaModel;
use App\Models\TambahLombaModel;
use App\Models\BobotKriteriaMahasiswaModel;
use Illuminate\Support\Carbon;

class RekomendasiController extends Controller
{
    // public function form()
    // {
    //     return view('rekomendasi.form');
    // }


    // public function hitung(Request $request)
    // {
    //     $request->validate([
    //         'ipk' => 'required|numeric|min:0|max:4',
    //         'harga' => 'required|numeric|min:0',
    //         'syarat' => 'required|string',
    //         'jenis' => 'required|string',
    //         'benefit' => 'required|string',
    //     ]);

    //     $user = Auth::user();
    //     $ipk = floatval($request->input('ipk'));

    //     // Tentukan tingkat lomba berdasarkan IPK
    //     if ($ipk < 3.0) {
    //         $tingkatanLomba = ['lokal'];
    //     } elseif ($ipk <= 3.4) {
    //         $tingkatanLomba = ['lokal', 'regional'];
    //     } else {
    //         $tingkatanLomba = ['lokal', 'regional', 'internasional'];
    //     }

    //     $keahlian = array_map('trim', explode(',', $user->keahlian ?? ''));
    //     $pengalaman = array_map('trim', explode(',', $user->pengalaman ?? ''));
    //     $minat = array_map('trim', explode(',', $user->minat ?? ''));

    //     $opsiBidang = ['Desain', 'UI/UX', 'Olahraga'];

    //     $bobotBidang = [];
    //     foreach ($opsiBidang as $bidang) {
    //         if (in_array($bidang, $keahlian)) {
    //             $bobotBidang[$bidang] = 1.0;
    //         } elseif (in_array($bidang, $pengalaman)) {
    //             $bobotBidang[$bidang] = 0.5;
    //         } elseif (in_array($bidang, $minat)) {
    //             $bobotBidang[$bidang] = 0.1;
    //         } else {
    //             $bobotBidang[$bidang] = 0.0;
    //         }
    //     }

    //     function buatBobot($opsi, $pilihanUser)
    //     {
    //         $bobotTinggi = 1.0;
    //         $bobotRendah = 0.4;
    //         $bobot = [];

    //         foreach ($opsi as $opsiItem) {
    //             $bobot[$opsiItem] = ($opsiItem === $pilihanUser) ? $bobotTinggi : $bobotRendah;
    //         }

    //         return $bobot;
    //     }

    //     $hargaUser = floatval($request->input('harga'));

    //     $bobotKriteria = [
    //         'jenis'   => buatBobot(['individu', 'tim'], $request->jenis),
    //         'syarat'  => buatBobot(['bebas', 'folow ig', 'upload twiboon'], $request->syarat),
    //         'benefit' => buatBobot(['Dana Transportasi', 'Makan', 'Penginapan', 'Sertifikat', 'Gratis'], $request->benefit),
    //         'bidang'  => $bobotBidang,
    //     ];

    //     $lombaList = [
    //         [
    //             'nama' => 'Desain Poster Digital',
    //             'tingkat' => 'regional',
    //             'jenis' => 'individu',
    //             'bidang' => 'Desain',
    //             'benefit' => 'Gratis',
    //             'harga' => 0,
    //             'syarat' => 'folow ig'
    //         ],
    //         [
    //             'nama' => 'UI/UX Challenge 2025',
    //             'tingkat' => 'regional',
    //             'jenis' => 'individu',
    //             'bidang' => 'UI/UX',
    //             'benefit' => 'Penginapan',
    //             'harga' => 60000,
    //             'syarat' => 'upload twiboon'
    //         ],
    //         [
    //             'nama' => 'SportiCore',
    //             'tingkat' => 'lokal',
    //             'jenis' => 'tim',
    //             'bidang' => 'Olahraga',
    //             'benefit' => 'Sertifikat',
    //             'harga' => 25000,
    //             'syarat' => 'bebas'
    //         ],
    //     ];

    //     // Filter lomba berdasarkan tingkat
    //     $lombaList = array_values(array_filter($lombaList, function ($lomba) use ($tingkatanLomba) {
    //         return in_array($lomba['tingkat'], $tingkatanLomba);
    //     }));

    //     // Buat matriks awal, hitung nilai harga alternatif (1 atau 0.4)
    //     $matriks = [];

    //     // Buat array nilai harga alternatif untuk cari nilai terkecil
    //     $nilaiHargaAlternatif = [];

    //     foreach ($lombaList as $lomba) {
    //         $nilaiHarga = ($lomba['harga'] == $hargaUser) ? 1.0 : 0.4;
    //         $nilaiHargaAlternatif[] = $nilaiHarga;
    //     }

    //     // Ambil nilai harga terkecil dari alternatif (misal 0.4)
    //     $hargaTerkecil = min($nilaiHargaAlternatif);

    //     // Baris A0 dengan kriteria harga = nilai terkecil dari alternatif,
    //     // kriteria lain tetap 1
    //     $matriks[] = [
    //         'nama'        => 'A0',
    //         'tingkat'     => 'optimal',
    //         'jenis_text'  => 'optimal',
    //         'bidang_text' => 'optimal',
    //         'syarat_text' => 'optimal',
    //         'harga_text'  => (string) $hargaTerkecil,
    //         'jenis'       => 1,
    //         'bidang'      => 1,
    //         'benefit'     => 1,
    //         'syarat'      => 1,
    //         'harga'       => $hargaTerkecil,
    //     ];

    //     foreach ($lombaList as $lomba) {
    //         $nilaiHarga = ($lomba['harga'] == $hargaUser) ? 1.0 : 0.4;

    //         $matriks[] = [
    //             'nama'        => $lomba['nama'],
    //             'tingkat'     => $lomba['tingkat'],
    //             'jenis_text'  => $lomba['jenis'],
    //             'bidang_text' => $lomba['bidang'],
    //             'syarat_text' => $lomba['syarat'],
    //             'harga_text'  => 'Rp ' . number_format($lomba['harga'], 0, ',', '.'),
    //             'jenis'       => $bobotKriteria['jenis'][$lomba['jenis']] ?? 0,
    //             'bidang'      => $bobotKriteria['bidang'][$lomba['bidang']] ?? 0,
    //             'benefit'     => $bobotKriteria['benefit'][$lomba['benefit']] ?? 0,
    //             'syarat'      => $bobotKriteria['syarat'][$lomba['syarat']] ?? 0,
    //             'harga'       => $nilaiHarga,
    //         ];
    //     }

    //     // Tahap 2: Normalisasi
    //     // Calculate the sum of all values for each criterion, including 'harga'
    //     $total = [
    //         'bidang'  => array_sum(array_column($matriks, 'bidang')),
    //         'benefit' => array_sum(array_column($matriks, 'benefit')),
    //         'jenis'   => array_sum(array_column($matriks, 'jenis')),
    //         'syarat'  => array_sum(array_column($matriks, 'syarat')),
    //         'harga'   => array_sum(array_column($matriks, 'harga')), // Calculate total sum for 'harga'
    //     ];

    //     $normalisasi = [];
    //     foreach ($matriks as $item) {
    //         $normalizedHarga = 0;
    //         // Apply the specific normalization for 'harga' (cost)
    //         if ($total['harga'] > 0) {
    //             // Ensure item['harga'] is not zero to avoid division by zero for the inverse
    //             if ($item['harga'] != 0) {
    //                 $normalizedHarga = (1 / $item['harga']) / $total['harga'];
    //             }
    //         }

    //         $normalisasi[] = [
    //             'nama'    => $item['nama'],
    //             'bidang'  => $total['bidang'] > 0 ? $item['bidang'] / $total['bidang'] : 0,
    //             'benefit' => $total['benefit'] > 0 ? $item['benefit'] / $total['benefit'] : 0,
    //             'jenis'   => $total['jenis'] > 0 ? $item['jenis'] / $total['jenis'] : 0,
    //             'syarat'  => $total['syarat'] > 0 ? $item['syarat'] / $total['syarat'] : 0,
    //             'harga'   => $normalizedHarga, // Use the new normalization for 'harga'
    //         ];
    //     }

    //     // Tahap 3: Normalisasi Terbobot
    //     $bobotGlobal = [
    //         'bidang'  => 0.4,
    //         'benefit' => 0.2,
    //         'jenis'   => 0.15,
    //         'harga'   => 0.15,
    //         'syarat'  => 0.1,
    //     ];

    //     $normalisasiTerbobot = [];
    //     foreach ($normalisasi as $item) {
    //         $normalisasiTerbobot[] = [
    //             'nama'    => $item['nama'],
    //             'bidang'  => $item['bidang'] * $bobotGlobal['bidang'],
    //             'benefit' => $item['benefit'] * $bobotGlobal['benefit'],
    //             'jenis'   => $item['jenis'] * $bobotGlobal['jenis'],
    //             'harga'   => $item['harga'] * $bobotGlobal['harga'],
    //             'syarat'  => $item['syarat'] * $bobotGlobal['syarat'],
    //         ];
    //     }

    //     // Tahap 4: Hitung Si dan Ki
    //     $hasil = [];
    //     $s0 = 0;

    //     foreach ($normalisasiTerbobot as $i => $item) {
    //         $si = $item['bidang'] + $item['benefit'] + $item['jenis'] + $item['harga'] + $item['syarat'];
    //         if ($item['nama'] === 'A0') {
    //             $s0 = $si;
    //         } else {
    //             // Adjust index for $lombaList as it doesn't include A0
    //             $lombaIndex = $i - 1;
    //             // Ensure the index is valid for $lombaList
    //             if (isset($lombaList[$lombaIndex])) {
    //                 $hasil[] = [
    //                     'lomba' => $lombaList[$lombaIndex],
    //                     'si' => round($si, 4),
    //                     'ki' => 0,
    //                     'ranking' => 0,
    //                 ];
    //             }
    //         }
    //     }

    //     foreach ($hasil as &$item) {
    //         $item['ki'] = $s0 > 0 ? round($item['si'] / $s0, 4) : 0;
    //     }

    //     usort($hasil, fn($a, $b) => $b['ki'] <=> $a['ki']);
    //     foreach ($hasil as $index => &$item) {
    //         $item['ranking'] = $index + 1;
    //     }

    //     $arasData = [
    //         'matriks_keputusan' => $matriks,
    //         'normalisasi' => $normalisasi,
    //         'normalisasi_terbobot' => $normalisasiTerbobot,
    //         'bobot_global' => $bobotGlobal,
    //         'harga_user' => $hargaUser,
    //         's0' => round($s0, 4),
    //         'total_normalisasi' => $total,
    //         // 'total_harga' => $totalHarga, // Redundant, already in $total
    //     ];

    //     return view('rekomendasi.hasil', compact('hasil', 'matriks', 'arasData'));
    // }

    // public function index()
    // {
    //     $userId = Auth::id();

    //     // Ambil preferensi dan bobot user
    //     $preferensi = PreferensiMahasiswaModel::where('user_id', $userId)->first();
    //     $bobot = BobotKriteriaMahasiswaModel::where('user_id', $userId)->first();

    //     if (!$preferensi || !$bobot) {
    //         return redirect()->back()->with('error', 'Lengkapi preferensi dan bobot terlebih dahulu.');
    //     }

    //     // Ambil semua lomba yang belum berakhir
    //     $lomba = TambahLombaModel::where('status_verifikasi', 'Disetujui')
    //         ->whereDate('tanggal_selesai', '>=', now())
    //         ->get();

    //     // Lakukan filtering berdasarkan preferensi (misalnya: min_hadiah, max_biaya, dsb)
    //     $filtered = $lomba->filter(function ($item) use ($preferensi) {
    //         return
    //             $item->hadiah >= $preferensi->min_hadiah &&
    //             $item->biaya_pendaftaran <= $preferensi->max_biaya &&
    //             $this->tingkatValue($item->tingkat_lomba) >= $this->tingkatValue($preferensi->min_tingkat) &&
    //             now()->diffInDays($item->tanggal_selesai, false) >= $preferensi->min_sisa_hari;
    //     });

    //     // Siapkan data untuk ARAS (matrix keputusan dan bobot)
    //     $matrix = [];
    //     foreach ($filtered as $item) {
    //         $matrix[] = [
    //             'id_lomba' => $item->id_tambahLomba,
    //             'biaya' => $item->biaya_pendaftaran,
    //             'hadiah' => $item->hadiah,
    //             'format' => $this->formatValue($item->format_lomba, $preferensi->prefer_format),
    //             'tipe' => $this->tipeValue($item->tipe_lomba, $preferensi->prefer_tipe_lomba),
    //             'tingkat' => $this->tingkatValue($item->tingkat_lomba),
    //             'sisa_hari' => now()->diffInDays($item->tanggal_selesai, false)
    //         ];
    //     }

    //     // Hitung ARAS
    //     $ranking = $this->hitungARAS($matrix, $bobot);

    //     return view('mahasiswa.rekomendasi.index', compact('ranking'));
    // }

    // // Fungsi bantu mapping nilai preferensi
    // private function formatValue($format, $prefer)
    // {
    //     if ($prefer === 'bebas') return 1;
    //     return $format === $prefer ? 1 : 0;
    // }

    // private function tipeValue($tipe, $prefer)
    // {
    //     if ($prefer === 'bebas') return 1;
    //     return $tipe === $prefer ? 1 : 0;
    // }

    // private function tingkatValue($tingkat)
    // {
    //     $urutan = ['politeknik' => 1, 'kota' => 2, 'provinsi' => 3, 'nasional' => 4, 'internasional' => 5];
    //     return $urutan[$tingkat] ?? 0;
    // }

    // // Fungsi utama ARAS
    // private function hitungARAS($matrix, $bobot)
    // {
    //     // 1. Normalisasi
    //     $normal = [];
    //     $total = [
    //         'biaya' => array_sum(array_column($matrix, 'biaya')),
    //         'hadiah' => array_sum(array_column($matrix, 'hadiah')),
    //         'format' => array_sum(array_column($matrix, 'format')),
    //         'tipe' => array_sum(array_column($matrix, 'tipe')),
    //         'tingkat' => array_sum(array_column($matrix, 'tingkat')),
    //         'sisa_hari' => array_sum(array_column($matrix, 'sisa_hari')),
    //     ];

    //     foreach ($matrix as $item) {
    //         $normal[] = [
    //             'id_lomba' => $item['id_lomba'],
    //             'biaya' => $item['biaya'] / ($total['biaya'] ?: 1),
    //             'hadiah' => $item['hadiah'] / ($total['hadiah'] ?: 1),
    //             'format' => $item['format'] / ($total['format'] ?: 1),
    //             'tipe' => $item['tipe'] / ($total['tipe'] ?: 1),
    //             'tingkat' => $item['tingkat'] / ($total['tingkat'] ?: 1),
    //             'sisa_hari' => $item['sisa_hari'] / ($total['sisa_hari'] ?: 1),
    //         ];
    //     }

    //     // 2. Hitung skor preferensi
    //     $result = [];
    //     foreach ($normal as $item) {
    //         $score =
    //             $item['biaya'] * $bobot->bobot_biaya +
    //             $item['hadiah'] * $bobot->bobot_hadiah +
    //             $item['format'] * $bobot->bobot_format +
    //             $item['tipe'] * $bobot->bobot_tipe_lomba +
    //             $item['tingkat'] * $bobot->bobot_tingkat +
    //             $item['sisa_hari'] * $bobot->bobot_sisa_hari;

    //         $result[] = [
    //             'id_lomba' => $item['id_lomba'],
    //             'score' => $score
    //         ];
    //     }

    //     // 3. Urutkan
    //     usort($result, fn($a, $b) => $b['score'] <=> $a['score']);
    //     return $result;
    // }
    // public function index() {
    //     $tanggal = Carbon::create(2025, 6, 19);

    //     $lomba = TambahLombaModel::where('status_verifikasi', 'Disetujui')
    //         ->where('tanggal_selesai', '>', $tanggal)
    //         ->get();

    //     return view('mahasiswa.rekomendasi.index', compact('lomba'));
    // }
    // public function hasil()
    // {
    //     $userId = Auth::id();

    //     // Ambil preferensi dan bobot
    //     $preferensi = PreferensiMahasiswaModel::where('user_id', $userId)->first();
    //     $bobot = BobotKriteriaMahasiswaModel::where('user_id', $userId)->first();

    //     // Ambil lomba yang sesuai preferensi
    //     $lomba = TambahLombaModel::where('bidang_minat', $preferensi->bidang_minat)
    //         ->where('format', $preferensi->prefer_format)
    //         ->where('tipe_lomba', $preferensi->prefer_tipe_lomba)
    //         ->where('biaya_pendaftaran', '<=', $preferensi->max_biaya)
    //         ->where('hadiah', '>=', $preferensi->min_hadiah)
    //         ->where('tingkat', '>=', $preferensi->min_tingkat)
    //         ->whereRaw("DATEDIFF(tanggal_akhir, NOW()) >= ?", [$preferensi->min_sisa_hari])
    //         ->get();

    //     if ($lomba->isEmpty()) {
    //         return back()->with('warning', 'Tidak ada lomba yang sesuai dengan preferensi Anda.');
    //     }

    //     // Bangun matriks keputusan
    //     $matriks = $lomba->map(function ($item) use ($preferensi) {
    //         return [
    //             'id' => $item->id,
    //             'biaya' => $item->biaya_pendaftaran,
    //             'hadiah' => $item->hadiah,
    //             'tingkat' => $this->tingkatToNumber($item->tingkat),
    //             'sisa_hari' => \Carbon\Carbon::parse($item->tanggal_akhir)->diffInDays(now()),
    //             'format' => ($item->format == $preferensi->prefer_format || $preferensi->prefer_format == 'bebas') ? 1 : 0,
    //             'minat' => ($item->bidang_minat == $preferensi->bidang_minat) ? 1 : 0,
    //             'tipe_lomba' => ($item->tipe_lomba == $preferensi->prefer_tipe_lomba || $preferensi->prefer_tipe_lomba == 'bebas') ? 1 : 0,
    //         ];
    //     });

    //     // Normalisasi
    //     $sum = [];
    //     foreach ($matriks as $data) {
    //         foreach ($data as $key => $value) {
    //             if ($key == 'id') continue;
    //             $sum[$key] = ($sum[$key] ?? 0) + $value;
    //         }
    //     }

    //     $normalisasi = [];
    //     foreach ($matriks as $data) {
    //         $row = ['id' => $data['id']];
    //         foreach ($data as $key => $value) {
    //             if ($key == 'id') continue;
    //             $row[$key] = ($sum[$key] > 0) ? $value / $sum[$key] : 0;
    //         }
    //         $normalisasi[] = $row;
    //     }

    //     // Bobot dari mahasiswa
    //     $bobotArray = [
    //         'biaya' => $bobot->bobot_biaya,
    //         'hadiah' => $bobot->bobot_hadiah,
    //         'tingkat' => $bobot->bobot_tingkat,
    //         'sisa_hari' => $bobot->bobot_sisa_hari,
    //         'format' => $bobot->bobot_format,
    //         'minat' => $bobot->bobot_minat,
    //         'tipe_lomba' => $bobot->bobot_tipe_lomba,
    //     ];

    //     // Matriks terbobot
    //     $terbobot = [];
    //     foreach ($normalisasi as $data) {
    //         $row = ['id' => $data['id']];
    //         foreach ($data as $key => $value) {
    //             if ($key == 'id') continue;
    //             $row[$key] = $value * $bobotArray[$key];
    //         }
    //         $terbobot[] = $row;
    //     }

    //     // Hitung skor total (nilai optimal S)
    //     $ranking = [];
    //     foreach ($terbobot as $data) {
    //         $total = 0;
    //         foreach ($data as $key => $value) {
    //             if ($key == 'id') continue;
    //             $total += $value;
    //         }
    //         $ranking[] = [
    //             'id' => $data['id'],
    //             'score' => $total
    //         ];
    //     }

    //     // Urutkan skor dari tinggi ke rendah
    //     usort($ranking, function ($a, $b) {
    //         return $b['score'] <=> $a['score'];
    //     });

    //     // Gabungkan dengan data lomba
    //     $hasilRekomendasi = collect($ranking)->map(function ($item) use ($lomba) {
    //         $detail = $lomba->where('id', $item['id'])->first();
    //         return [
    //             'lomba' => $detail,
    //             'skor' => round($item['score'], 4)
    //         ];
    //     });

    //     return view('mahasiswa.rekomendasi.hasil', [
    //         'rekomendasi' => $hasilRekomendasi
    //     ]);
    // }

    // private function tingkatToNumber($tingkat)
    // {
    //     return match ($tingkat) {
    //         'politeknik' => 1,
    //         'kota' => 2,
    //         'provinsi' => 3,
    //         'nasional' => 4,
    //         'internasional' => 5,
    //         default => 0,
    //     };
    // }

    public function index()
{
    // Ambil semua lomba yang disetujui dan tanggalnya masih aktif
    $lombaAktif = TambahLombaModel::where('status_verifikasi', 'Disetujui')
        ->where('tanggal_selesai', '>', now())
        ->get();

    // Kembali ke view tanpa skor (belum klik rekomendasi)
    return view('mahasiswa.rekomendasi.index', [
        'lomba' => $lombaAktif,
        'rekomendasi' => [] // kosong karena belum dihitung
    ]);
}

    public function hasil()
{
    $userId = Auth::id();

    // Ambil preferensi dan bobot
    $preferensi = PreferensiMahasiswaModel::where('user_id', $userId)->first();
    $bobot = BobotKriteriaMahasiswaModel::where('user_id', $userId)->first();

    // Validasi
    if (!$preferensi || !$bobot) {
        return redirect()->route('mahasiswa.rekomendasi.index')
            ->with('error', 'Lengkapi preferensi dan bobot terlebih dahulu.');
    }

    // Ambil dan filter lomba berdasarkan preferensi
    $lombaFiltered = TambahLombaModel::where('bidang_minat', $preferensi->bidang_minat_id)
        ->where('format_lomba', $preferensi->prefer_format)
        ->where('tipe_lomba', $preferensi->prefer_tipe_lomba)
        ->where('biaya_pendaftaran', '<=', $preferensi->max_biaya)
        ->where('hadiah', '>=', $preferensi->min_hadiah)
        ->where('tingkat_lomba', '>=', $preferensi->min_tingkat)
        ->whereRaw("DATEDIFF(tanggal_selesai, NOW()) >= ?", [$preferensi->min_sisa_hari])
        ->get();

    if ($lombaFiltered->isEmpty()) {
        return redirect()->route('mahasiswa.rekomendasi.index')
            ->with('error', 'Tidak ada lomba sesuai preferensi Anda.');
    }

    $matriks = $lombaFiltered->map(function ($item) use ($preferensi) {
        return [
            'id' => $item->id_tambahLomba,
            'biaya' => $item->biaya_pendaftaran,
            'hadiah' => $item->hadiah,
            'tingkat' => $this->tingkatToNumber($item->tingkat_lomba),
            'sisa_hari' => \Carbon\Carbon::parse($item->tanggal_selesai)->diffInDays(now()),
            'format' => ($item->format_lomba == $preferensi->prefer_format || $preferensi->prefer_format == 'bebas') ? 1 : 0,
            'minat' => ($item->bidang_minat == $preferensi->bidang_minat_id) ? 1 : 0,
            'tipe_lomba' => ($item->tipe_lomba == $preferensi->prefer_tipe_lomba || $preferensi->prefer_tipe_lomba == 'bebas') ? 1 : 0,
        ];
    });

    // Normalisasi
    $sum = [];
    foreach ($matriks as $data) {
        foreach ($data as $key => $value) {
            if ($key == 'id') continue;
            $sum[$key] = ($sum[$key] ?? 0) + $value;
        }
    }

    $normalisasi = [];
    foreach ($matriks as $data) {
        $row = ['id' => $data['id']];
        foreach ($data as $key => $value) {
            if ($key == 'id') continue;
            $row[$key] = ($sum[$key] > 0) ? $value / $sum[$key] : 0;
        }
        $normalisasi[] = $row;
    }

    // Bobot
    $bobotArray = [
        'biaya' => $bobot->bobot_biaya,
        'hadiah' => $bobot->bobot_hadiah,
        'tingkat' => $bobot->bobot_tingkat,
        'sisa_hari' => $bobot->bobot_sisa_hari,
        'format' => $bobot->bobot_format,
        'minat' => $bobot->bobot_minat,
        'tipe_lomba' => $bobot->bobot_tipe_lomba,
    ];

    // Matriks terbobot
    $terbobot = [];
    foreach ($normalisasi as $data) {
        $row = ['id' => $data['id']];
        foreach ($data as $key => $value) {
            if ($key == 'id') continue;
            $row[$key] = $value * $bobotArray[$key];
        }
        $terbobot[] = $row;
    }

    // Hitung skor
    $ranking = [];
    foreach ($terbobot as $data) {
        $total = 0;
        foreach ($data as $key => $value) {
            if ($key == 'id') continue;
            $total += $value;
        }
        $ranking[] = [
            'id' => $data['id'],
            'score' => $total
        ];
    }

    // Urutkan
    usort($ranking, fn($a, $b) => $b['score'] <=> $a['score']);

    // Gabungkan dengan data lomba
    $hasilRekomendasi = collect($ranking)->map(function ($item) use ($lombaFiltered) {
        $detail = $lombaFiltered->where('id_tambahLomba', $item['id'])->first();
        return [
            'lomba' => $detail,
            'skor' => round($item['score'], 4)
        ];
    });

    // Ambil seluruh lomba aktif untuk tabel utama
    $lombaAktif = TambahLombaModel::where('status_verifikasi', 'Disetujui')
        ->where('tanggal_selesai', '>', now())
        ->get();

    // Tampilkan ke view index
    return view('mahasiswa.rekomendasi.index', [
        'lomba' => $lombaAktif,
        'rekomendasi' => $hasilRekomendasi
    ]);
}

private function tingkatToNumber($tingkat)
{
    return match ($tingkat) {
        'politeknik' => 1,
        'kota' => 2,
        'provinsi' => 3,
        'nasional' => 4,
        'internasional' => 5,
        default => 0,
    };
}

public function detailAras($id)
{
    $userId = Auth::id();

    $preferensi = PreferensiMahasiswaModel::where('user_id', $userId)->first();
    $bobot = BobotKriteriaMahasiswaModel::where('user_id', $userId)->first();
    $lomba = TambahLombaModel::findOrFail($id);

    if (!$preferensi || !$bobot || !$lomba) {
        return response()->json(['error' => 'Data tidak lengkap'], 400);
    }

    // Matriks Keputusan
    $data = [
        'biaya' => $lomba->biaya_pendaftaran,
        'hadiah' => $lomba->hadiah,
        'tingkat' => $this->tingkatToNumber($lomba->tingkat_lomba),
        'sisa_hari' => \Carbon\Carbon::parse($lomba->tanggal_selesai)->diffInDays(now()),
        'format' => ($lomba->format_lomba == $preferensi->prefer_format || $preferensi->prefer_format == 'bebas') ? 1 : 0,
        'minat' => ($lomba->bidang_minat == $preferensi->bidang_minat_id) ? 1 : 0,
        'tipe_lomba' => ($lomba->tipe_lomba == $preferensi->prefer_tipe_lomba || $preferensi->prefer_tipe_lomba == 'bebas') ? 1 : 0,
    ];

    // Sum untuk normalisasi
    $sum = [
        'biaya' => TambahLombaModel::where('status_verifikasi', 'Disetujui')->where('tanggal_selesai', '>', now())->sum('biaya_pendaftaran'),
        'hadiah' => TambahLombaModel::where('status_verifikasi', 'Disetujui')->where('tanggal_selesai', '>', now())->sum('hadiah'),
        'tingkat' => 0,
        'sisa_hari' => 0,
        'format' => 1,
        'minat' => 1,
        'tipe_lomba' => 1,
    ];

    // Normalisasi
    $normalisasi = [];
    foreach ($data as $key => $value) {
        $normalisasi[$key] = ($sum[$key] ?? 1) > 0
            ? $value / ($sum[$key] ?: 1)
            : 0;
    }

    // Terbobot
    $terbobot = [];
    foreach ($normalisasi as $key => $value) {
        $terbobot[$key] = $value * $bobot->{'bobot_' . $key};
    }

    $skor = array_sum($terbobot);

    return response()->json([
        'data' => $data,
        'normalisasi' => $normalisasi,
        'terbobot' => $terbobot,
        'skor' => round($skor, 4)
    ]);
}

// public function detailAras($id)
// {
//     $userId = Auth::id();
//     $preferensi = PreferensiMahasiswaModel::where('user_id', $userId)->first();
//     $bobot = BobotKriteriaMahasiswaModel::where('user_id', $userId)->first();
//     $lomba = TambahLombaModel::findOrFail($id);

//     $data = [
//         'biaya' => $lomba->biaya_pendaftaran,
//         'hadiah' => $lomba->hadiah,
//         'tingkat' => $this->tingkatToNumber($lomba->tingkat_lomba),
//         'sisa_hari' => \Carbon\Carbon::parse($lomba->tanggal_selesai)->diffInDays(now()),
//         'format' => ($lomba->format_lomba == $preferensi->prefer_format || $preferensi->prefer_format == 'bebas') ? 1 : 0,
//         'minat' => ($lomba->bidang_minat == $preferensi->bidang_minat_id) ? 1 : 0,
//         'tipe_lomba' => ($lomba->tipe_lomba == $preferensi->prefer_tipe_lomba || $preferensi->prefer_tipe_lomba == 'bebas') ? 1 : 0,
//     ];

//     return view('mahasiswa.rekomendasi.detail_aras', compact('lomba', 'data', 'bobot'));
// }
// public function detailAras($id)
// {
//     $userId = Auth::id();

//     $preferensi = PreferensiMahasiswaModel::where('user_id', $userId)->first();
//     $bobot = BobotKriteriaMahasiswaModel::where('user_id', $userId)->first();
//     $lomba = TambahLombaModel::findOrFail($id);

//     $data = [
//         'biaya' => $lomba->biaya_pendaftaran,
//         'hadiah' => $lomba->hadiah,
//         'tingkat' => $this->tingkatToNumber($lomba->tingkat_lomba),
//         'sisa_hari' => \Carbon\Carbon::parse($lomba->tanggal_selesai)->diffInDays(now()),
//         'format' => ($lomba->format_lomba == $preferensi->prefer_format || $preferensi->prefer_format == 'bebas') ? 1 : 0,
//         'minat' => ($lomba->bidang_minat == $preferensi->bidang_minat_id) ? 1 : 0,
//         'tipe_lomba' => ($lomba->tipe_lomba == $preferensi->prefer_tipe_lomba || $preferensi->prefer_tipe_lomba == 'bebas') ? 1 : 0,
//     ];

//     $sum = array_map(function ($key) use ($userId) {
//         return TambahLombaModel::where('status_verifikasi', 'Disetujui')
//             ->where('tanggal_selesai', '>', now())
//             ->sum($key);
//     }, ['biaya_pendaftaran', 'hadiah']);

//     $sum['tingkat'] = 0;
//     $sum['sisa_hari'] = 0;
//     $sum['format'] = 1;
//     $sum['minat'] = 1;
//     $sum['tipe_lomba'] = 1;

//     // $normalisasi = [];
//     // foreach ($data as $key => $value) {
//     //     $normalisasi[$key] = ($sum[$key] ?? array_sum(array_column([$data], $key))) > 0
//     //         ? $value / ($sum[$key] ?: 1)
//     //         : 0;
//     // }

//     $normalisasi = [];
//     foreach ($data as $key => $value) {
//         $normalisasi[$key] = ($sum[$key] ?? 1) > 0
//             ? $value / ($sum[$key] ?: 1)
//             : 0;
//     }

//     $terbobot = [];
//     foreach ($normalisasi as $key => $value) {
//         $terbobot[$key] = $value * $bobot->{'bobot_' . $key};
//     }

//     $skor = array_sum($terbobot);

//     return response()->json([
//         'data' => $data,
//         'normalisasi' => $normalisasi,
//         'terbobot' => $terbobot,
//         'skor' => round($skor, 4)
//     ]);
// }
}