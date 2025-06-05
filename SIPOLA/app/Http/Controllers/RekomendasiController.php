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

        // Tentukan tingkatan lomba berdasarkan IPK
        $tingkatanLomba = [];
        if ($ipk < 3.0) {
            $tingkatanLomba = ['lokal'];
        } elseif ($ipk <= 3.4) {
            $tingkatanLomba = ['lokal', 'regional'];
        } else {
            $tingkatanLomba = ['lokal', 'regional', 'internasional'];
        }

        // Fungsi pembobotan
        function buatBobot($opsi, $pilihanUser)
        {
            $bobotTinggi = 1.0;
            $bobotRendah = 0.4;
            $bobot = [];

            if (!$pilihanUser || (is_string($pilihanUser) && strtolower($pilihanUser) === 'default')) {
                foreach ($opsi as $opsiItem) {
                    $bobot[$opsiItem] = 0.0;
                }
                return $bobot;
            }

            foreach ($opsi as $opsiItem) {
                $bobot[$opsiItem] = ($opsiItem === $pilihanUser) ? $bobotTinggi : $bobotRendah;
            }

            return $bobot;
        }

              // Bobot bidang berdasarkan keahlian, minat dan hubungan kedekatan
        $opsiBidang = ['IT', 'Sains', 'Desain', 'UI/UX', 'Olahraga'];
        $bobotBidang = [];

        $keahlian = $user->bidang_keahlian;
        $minat = $user->sertifikasi;

        foreach ($opsiBidang as $bidang) {
            if ($bidang === $keahlian) {
                $bobotBidang[$bidang] = 1.0;
            } elseif (
                ($keahlian === 'IT' && $bidang === 'UI/UX') ||
                ($keahlian === 'UI/UX' && $bidang === 'IT') ||
                ($keahlian === 'Desain' && $bidang === 'UI/UX') ||
                ($keahlian === 'UI/UX' && $bidang === 'Desain')
            ) {
                $bobotBidang[$bidang] = 0.5;
            } elseif ($bidang === $minat) {
                $bobotBidang[$bidang] = 0.1;
            } else {
                $bobotBidang[$bidang] = 0.0;
            }
        }

        // Bobot kriteria lainnya
        $bobotKriteria = [
            'jenis'   => buatBobot(['individu', 'tim'], $request->jenis),
            'bidang'  => $bobotBidang,
            'benefit' => buatBobot(['Dana Transportasi', 'Makan', 'Penginapan', 'Sertifikat', 'Gratis'], $request->benefit),
        ];

        // Daftar lomba
        $lombaList = [
            [
                'nama' => 'Lomba Coding Nasional',
                'tingkat' => 'internasional',
                'jenis' => 'individu',
                'bidang' => 'IT',
                'benefit' => 'Sertifikat',
                'harga' => 50000
            ],
            [
                'nama' => 'Olimpiade Matematika',
                'tingkat' => 'lokal',
                'jenis' => 'tim',
                'bidang' => 'Sains',
                'benefit' => 'Makan',
                'harga' => 30000
            ],
            [
                'nama' => 'Desain Poster Digital',
                'tingkat' => 'regional',
                'jenis' => 'individu',
                'bidang' => 'Desain',
                'benefit' => 'Gratis',
                'harga' => 0
            ],
            [
                'nama' => 'Hackathon Jawa Timur',
                'tingkat' => 'regional',
                'jenis' => 'tim',
                'bidang' => 'IT',
                'benefit' => 'Dana Transportasi',
                'harga' => 75000
            ],
            [
                'nama' => 'UI/UX Challenge 2025',
                'tingkat' => 'regional',
                'jenis' => 'individu',
                'bidang' => 'UI/UX',
                'benefit' => 'Penginapan',
                'harga' => 60000
            ],
            [
                'nama' => 'SportiCore',
                'tingkat' => 'lokal',
                'jenis' => 'tim',
                'bidang' => 'Olahraga',
                'benefit' => 'Sertifikat',
                'harga' => 25000
            ],
        ];

        // Filter lomba berdasarkan IPK
        $lombaList = array_filter($lombaList, function ($lomba) use ($tingkatanLomba) {
            return in_array($lomba['tingkat'], $tingkatanLomba);
        });

        $lombaList = array_values($lombaList); // reset index

        // Matriks awal bobot
        $matriks = [];
        foreach ($lombaList as $lomba) {
            $matriks[] = [
                'nama'    => $lomba['nama'],
                'tingkat' => $lomba['tingkat'],
                'jenis'   => $bobotKriteria['jenis'][$lomba['jenis']] ?? 0,
                'bidang'  => $bobotKriteria['bidang'][$lomba['bidang']] ?? 0,
                'benefit' => $bobotKriteria['benefit'][$lomba['benefit']] ?? 0,
                'harga'   => floatval($lomba['harga']),
            ];
        }

        // Total masing-masing kriteria (harga sebagai cost)
        $total = [
            'jenis'   => array_sum(array_column($matriks, 'jenis')),
            'bidang'  => array_sum(array_column($matriks, 'bidang')),
            'benefit' => array_sum(array_column($matriks, 'benefit')),
        ];

        $hargaList = array_column($matriks, 'harga');
        $hargaMin = min($hargaList);

        // Normalisasi
        $normalisasi = [];
        foreach ($matriks as $item) {
            $normalisasi[] = [
                'nama'    => $item['nama'],
                'jenis'   => $total['jenis'] > 0 ? $item['jenis'] / $total['jenis'] : 0,
                'bidang'  => $total['bidang'] > 0 ? $item['bidang'] / $total['bidang'] : 0,
                'benefit' => $total['benefit'] > 0 ? $item['benefit'] / $total['benefit'] : 0,
                'harga'   => $item['harga'] > 0 ? $hargaMin / $item['harga'] : 1,
            ];
        }

        // Bobot global (total 1.0)
        $bobotGlobal = [
            'bidang'  => 0.6,
            'jenis'   => 0.1,
            'benefit' => 0.15,
            'harga'   => 0.15, // cost
        ];

        // Hitung skor akhir
        $hasil = [];
        foreach ($normalisasi as $i => $item) {
            $skor =
                ($item['jenis']   * $bobotGlobal['jenis']) +
                ($item['bidang']  * $bobotGlobal['bidang']) +
                ($item['benefit'] * $bobotGlobal['benefit']) +
                ($item['harga']   * $bobotGlobal['harga']); // cost lebih baik jika lebih kecil

            $hasil[] = [
                'lomba'         => $lombaList[$i],
                'skor'          => $skor,
                'skor_relatif'  => 0,
            ];
        }

        // Normalisasi skor relatif
        $s0 = max(array_column($hasil, 'skor'));
        foreach ($hasil as &$item) {
            $item['skor_relatif'] = $s0 > 0 ? $item['skor'] / $s0 : 0;
        }

        // Urutkan berdasarkan skor relatif tertinggi
        usort($hasil, fn($a, $b) => $b['skor_relatif'] <=> $a['skor_relatif']);

        return view('rekomendasi.hasil', compact('hasil', 'matriks'));
    }
}
