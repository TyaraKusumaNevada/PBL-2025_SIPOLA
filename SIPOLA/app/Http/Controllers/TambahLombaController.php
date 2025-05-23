<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TambahLombaModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class TambahLombaController extends Controller
{
    public function index() {
        $breadcrumb = (object) [
            'title' => 'Kelola Lomba',
            'list'  => ['Home', 'Lomba']
        ];

        $lomba = TambahLombaModel::all();

        return view('lomba.index', ['breadcrumb' => $breadcrumb, 'lomba' => $lomba]);
    }

    public function list(Request $request) {
    $lombas = TambahLombaModel::select(
        'id_tambahLomba',
        'nama_lomba',
        'kategori_lomba',
        'tingkat_lomba',
        'penyelenggara_lomba',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'pamflet_lomba',
        'status_verifikasi'
    );

        return DataTables::of($lombas)
            ->addIndexColumn()
            ->addColumn('tanggal_mulai', function ($row) {
                return date('d M Y', strtotime($row->tanggal_mulai));
            })
            ->addColumn('tanggal_selesai', function ($row) {
                return date('d M Y', strtotime($row->tanggal_selesai));
            })
            ->addColumn('pamflet_lomba', function ($row) {
                if ($row->pamflet_lomba) {
                    return '<img src="' . asset('storage/pamflet_lomba/' . $row->pamflet_lomba) . '" width="60">';
                }
                return '<span class="text-muted">Tidak ada</span>';
            })
            ->addColumn('aksi', function ($row) {
                $btn = '<div class="d-flex gap-1 justify-content-center">';
                $btn .= '<button onclick="modalAction(\''.url('/lomba/' . $row->id_tambahLomba . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button>';
                $btn .= '<button onclick="modalAction(\''.url('/lomba/' . $row->id_tambahLomba . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button>';
                $btn .= '<button onclick="modalAction(\''.url('/lomba/' . $row->id_tambahLomba . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button>';
                $btn .= '</div>';
                return $btn;
            })

            ->rawColumns(['aksi', 'pamflet_lomba']) // ⬅️ tambahkan pamflet_lomba
            ->make(true);
    }


    public function create_ajax() {
        return view('lomba.create_ajax');
    }

    public function store_ajax(Request $request) {
        if ($request->ajax()) {
            $rules = [
                'nama_lomba'         => 'required|string',
                'kategori_lomba'     => 'required|string',
                'tingkat_lomba'      => 'required|in:lokal,nasional,internasional',
                'penyelenggara_lomba'=> 'required|string',
                'deskripsi'          => 'required|string',
                'tanggal_mulai'      => 'required|date',
                'tanggal_selesai'    => 'required|date|after_or_equal:tanggal_mulai',
                'pamflet_lomba'      => 'nullable|image|max:2048',
                'status_verifikasi'  => 'required|in:Pending,Disetujui,Ditolak'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $data = $request->except('pamflet_lomba');

            if ($request->hasFile('pamflet_lomba')) {
                $file = $request->file('pamflet_lomba');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/pamflet_lomba', $filename);
                $data['pamflet_lomba'] = $filename;
            }

            TambahLombaModel::create($data);

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil disimpan'
            ]);
        }
    }

    public function show_ajax($id) {
        $lomba = TambahLombaModel::find($id);
        return view('lomba.show_ajax', compact('lomba'));
    }

    public function edit_ajax($id) {
        $lomba = TambahLombaModel::find($id);
        return view('lomba.edit_ajax', compact('lomba'));
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax()) {
            $rules = [
                'nama_lomba'         => 'required|string',
                'kategori_lomba'     => 'required|string',
                'tingkat_lomba'      => 'required|in:lokal,nasional,internasional',
                'penyelenggara_lomba'=> 'required|string',
                'deskripsi'          => 'required|string',
                'tanggal_mulai'      => 'required|date',
                'tanggal_selesai'    => 'required|date|after_or_equal:tanggal_mulai',
                'pamflet_lomba'      => 'nullable|image|max:2048',
                'status_verifikasi'  => 'required|in:Pending,Disetujui,Ditolak'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            try {
                $lomba = TambahLombaModel::find($id);

                if (!$lomba) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data lomba tidak ditemukan'
                    ], 404);
                }

                $data = $request->except('pamflet_lomba');

                if ($request->hasFile('pamflet_lomba')) {
                    // Hapus file lama jika ada dan eksis
                    if ($lomba->pamflet_lomba && Storage::exists('public/pamflet_lomba/' . $lomba->pamflet_lomba)) {
                        Storage::delete('public/pamflet_lomba/' . $lomba->pamflet_lomba);
                    }

                    $file = $request->file('pamflet_lomba');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('public/pamflet_lomba', $filename);
                    $data['pamflet_lomba'] = $filename;
                }

                $lomba->update($data);

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diperbarui'
                ]);
            } catch (\Exception $e) {
                        return response()->json([
                'status' => false,
                'message' => 'Akses tidak valid (bukan request AJAX)'
            ], 400);
            }
        }
    }


    public function confirm_ajax($id) {
        $lomba = TambahLombaModel::find($id);
        return view('lomba.confirm_ajax', compact('lomba'));
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax()) {
            $lomba = TambahLombaModel::find($id);
            if ($lomba) {
                // Pastikan file ada sebelum hapus
                if ($lomba->pamflet_lomba && Storage::exists('public/pamflet_lomba/' . $lomba->pamflet_lomba)) {
                    Storage::delete('public/pamflet_lomba/' . $lomba->pamflet_lomba);
                }

                $lomba->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid request'
        ]);
    }
}
