<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InfoLombaController extends Controller
{
    public function index()
    {
        // Ambil 10 data lomba terbaru dari tabel rekomendasi (asumsi ada kolom created_at)
        $lombaTerbaru = DB::table('rekomendasi')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('infolomba.index', compact('lombaTerbaru'));
    }
}
