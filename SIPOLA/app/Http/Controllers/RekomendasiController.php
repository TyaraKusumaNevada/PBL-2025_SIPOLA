<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RekomendasiController extends Controller
{
    public function form()
    {
        return view('rekomendasi.form');
    }

    public function hitung(Request $request)
    {
        $request->validate([
            'ipk' => 'required|numeric|min:0|max:4',
            'harga' => 'required|numeric|min:0',
            'syarat' => 'required|string',
            'jenis' => 'required|string',
            'benefit' => 'required|string',
        ]);

        $user = Auth::user();
        $ipk = floatval($request->input('ipk'));

        // Tentukan tingkat lomba berdasarkan IPK
        if ($ipk < 3.0) {
            $tingkatanLomba = ['lokal'];
        } elseif ($ipk <= 3.4) {
            $tingkatanLomba = ['lokal', 'regional'];
        } else {
            $tingkatanLomba = ['lokal', 'regional', 'internasional'];
        }

        $keahlian = array_map('trim', explode(',', $user->keahlian ?? ''));
        $pengalaman = array_map('trim', explode(',', $user->pengalaman ?? ''));
        $minat = array_map('trim', explode(',', $user->minat ?? ''));

        $opsiBidang = ['Desain', 'UI/UX', 'Olahraga'];

        $bobotBidang = [];
        foreach ($opsiBidang as $bidang) {
            if (in_array($bidang, $keahlian)) {
                $bobotBidang[$bidang] = 1.0;
            } elseif (in_array($bidang, $pengalaman)) {
                $bobotBidang[$bidang] = 0.5;
            } elseif (in_array($bidang, $minat)) {
                $bobotBidang[$bidang] = 0.1;
            } else {
                $bobotBidang[$bidang] = 0.0;
            }
        }

        function buatBobot($opsi, $pilihanUser)
        {
            $bobotTinggi = 1.0;
            $bobotRendah = 0.4;
            $bobot = [];

            foreach ($opsi as $opsiItem) {
                $bobot[$opsiItem] = ($opsiItem === $pilihanUser) ? $bobotTinggi : $bobotRendah;
            }

            return $bobot;
        }

        $hargaUser = floatval($request->input('harga'));

        $bobotKriteria = [
            'jenis'   => buatBobot(['individu', 'tim'], $request->jenis),
            'syarat'  => buatBobot(['bebas', 'folow ig', 'upload twiboon'], $request->syarat),
            'benefit' => buatBobot(['Dana Transportasi', 'Makan', 'Penginapan', 'Sertifikat', 'Gratis'], $request->benefit),
            'bidang'  => $bobotBidang,
        ];

        $lombaList = [
            [
                'nama' => 'Desain Poster Digital',
                'tingkat' => 'regional',
                'jenis' => 'individu',
                'bidang' => 'Desain',
                'benefit' => 'Gratis',
                'harga' => 0,
                'syarat' => 'folow ig'
            ],
            [
                'nama' => 'UI/UX Challenge 2025',
                'tingkat' => 'regional',
                'jenis' => 'individu',
                'bidang' => 'UI/UX',
                'benefit' => 'Penginapan',
                'harga' => 60000,
                'syarat' => 'upload twiboon'
            ],
            [
                'nama' => 'SportiCore',
                'tingkat' => 'lokal',
                'jenis' => 'tim',
                'bidang' => 'Olahraga',
                'benefit' => 'Sertifikat',
                'harga' => 25000,
                'syarat' => 'bebas'
            ],
        ];

        // Filter lomba berdasarkan tingkat
        $lombaList = array_values(array_filter($lombaList, function ($lomba) use ($tingkatanLomba) {
            return in_array($lomba['tingkat'], $tingkatanLomba);
        }));

        // Buat matriks awal, hitung nilai harga alternatif (1 atau 0.4)
        $matriks = [];

        // Buat array nilai harga alternatif untuk cari nilai terkecil
        $nilaiHargaAlternatif = [];

        foreach ($lombaList as $lomba) {
            $nilaiHarga = ($lomba['harga'] == $hargaUser) ? 1.0 : 0.4;
            $nilaiHargaAlternatif[] = $nilaiHarga;
        }

        // Ambil nilai harga terkecil dari alternatif (misal 0.4)
        $hargaTerkecil = min($nilaiHargaAlternatif);

        // Baris A0 dengan kriteria harga = nilai terkecil dari alternatif,
        // kriteria lain tetap 1
        $matriks[] = [
            'nama'        => 'A0',
            'tingkat'     => 'optimal',
            'jenis_text'  => 'optimal',
            'bidang_text' => 'optimal',
            'syarat_text' => 'optimal',
            'harga_text'  => (string) $hargaTerkecil,
            'jenis'       => 1,
            'bidang'      => 1,
            'benefit'     => 1,
            'syarat'      => 1,
            'harga'       => $hargaTerkecil,
        ];

        foreach ($lombaList as $lomba) {
            $nilaiHarga = ($lomba['harga'] == $hargaUser) ? 1.0 : 0.4;

            $matriks[] = [
                'nama'        => $lomba['nama'],
                'tingkat'     => $lomba['tingkat'],
                'jenis_text'  => $lomba['jenis'],
                'bidang_text' => $lomba['bidang'],
                'syarat_text' => $lomba['syarat'],
                'harga_text'  => 'Rp ' . number_format($lomba['harga'], 0, ',', '.'),
                'jenis'       => $bobotKriteria['jenis'][$lomba['jenis']] ?? 0,
                'bidang'      => $bobotKriteria['bidang'][$lomba['bidang']] ?? 0,
                'benefit'     => $bobotKriteria['benefit'][$lomba['benefit']] ?? 0,
                'syarat'      => $bobotKriteria['syarat'][$lomba['syarat']] ?? 0,
                'harga'       => $nilaiHarga,
            ];
        }

        // Tahap 2: Normalisasi
        // Calculate the sum of all values for each criterion, including 'harga'
        $total = [
            'bidang'  => array_sum(array_column($matriks, 'bidang')),
            'benefit' => array_sum(array_column($matriks, 'benefit')),
            'jenis'   => array_sum(array_column($matriks, 'jenis')),
            'syarat'  => array_sum(array_column($matriks, 'syarat')),
            'harga'   => array_sum(array_column($matriks, 'harga')), // Calculate total sum for 'harga'
        ];

        $normalisasi = [];
        foreach ($matriks as $item) {
            $normalizedHarga = 0;
            // Apply the specific normalization for 'harga' (cost)
            if ($total['harga'] > 0) {
                // Ensure item['harga'] is not zero to avoid division by zero for the inverse
                if ($item['harga'] != 0) {
                    $normalizedHarga = (1 / $item['harga']) / $total['harga'];
                }
            }

            $normalisasi[] = [
                'nama'    => $item['nama'],
                'bidang'  => $total['bidang'] > 0 ? $item['bidang'] / $total['bidang'] : 0,
                'benefit' => $total['benefit'] > 0 ? $item['benefit'] / $total['benefit'] : 0,
                'jenis'   => $total['jenis'] > 0 ? $item['jenis'] / $total['jenis'] : 0,
                'syarat'  => $total['syarat'] > 0 ? $item['syarat'] / $total['syarat'] : 0,
                'harga'   => $normalizedHarga, // Use the new normalization for 'harga'
            ];
        }

        // Tahap 3: Normalisasi Terbobot
        $bobotGlobal = [
            'bidang'  => 0.4,
            'benefit' => 0.2,
            'jenis'   => 0.15,
            'harga'   => 0.15,
            'syarat'  => 0.1,
        ];

        $normalisasiTerbobot = [];
        foreach ($normalisasi as $item) {
            $normalisasiTerbobot[] = [
                'nama'    => $item['nama'],
                'bidang'  => $item['bidang'] * $bobotGlobal['bidang'],
                'benefit' => $item['benefit'] * $bobotGlobal['benefit'],
                'jenis'   => $item['jenis'] * $bobotGlobal['jenis'],
                'harga'   => $item['harga'] * $bobotGlobal['harga'],
                'syarat'  => $item['syarat'] * $bobotGlobal['syarat'],
            ];
        }

        // Tahap 4: Hitung Si dan Ki
        $hasil = [];
        $s0 = 0;

        foreach ($normalisasiTerbobot as $i => $item) {
            $si = $item['bidang'] + $item['benefit'] + $item['jenis'] + $item['harga'] + $item['syarat'];
            if ($item['nama'] === 'A0') {
                $s0 = $si;
            } else {
                // Adjust index for $lombaList as it doesn't include A0
                $lombaIndex = $i - 1;
                // Ensure the index is valid for $lombaList
                if (isset($lombaList[$lombaIndex])) {
                    $hasil[] = [
                        'lomba' => $lombaList[$lombaIndex],
                        'si' => round($si, 4),
                        'ki' => 0,
                        'ranking' => 0,
                    ];
                }
            }
        }

        foreach ($hasil as &$item) {
            $item['ki'] = $s0 > 0 ? round($item['si'] / $s0, 4) : 0;
        }

        usort($hasil, fn($a, $b) => $b['ki'] <=> $a['ki']);
        foreach ($hasil as $index => &$item) {
            $item['ranking'] = $index + 1;
        }

        $arasData = [
            'matriks_keputusan' => $matriks,
            'normalisasi' => $normalisasi,
            'normalisasi_terbobot' => $normalisasiTerbobot,
            'bobot_global' => $bobotGlobal,
            'harga_user' => $hargaUser,
            's0' => round($s0, 4),
            'total_normalisasi' => $total,
            // 'total_harga' => $totalHarga, // Redundant, already in $total
        ];

        return view('rekomendasi.hasil', compact('hasil', 'matriks', 'arasData'));
    }
}