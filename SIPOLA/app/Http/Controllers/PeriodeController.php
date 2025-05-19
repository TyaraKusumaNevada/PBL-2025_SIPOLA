<?php

namespace App\Http\Controllers;

use App\Models\AngkatanModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PeriodeController extends Controller
{
    public function index() {
        $breadcrumb = (object) [
            'title' => 'Kelola Periode',
            'list'  => ['Home', 'Periode Angkatan']
        ]; 

        $periode = AngkatanModel::all();

        return view('periode.index', ['breadcrumb' => $breadcrumb, 'periode' => $periode]
        );
    }

    public function list(Request $request) {
        $periodes = AngkatanModel::select('id_angkatan', 'semester', 'tahun_ajaran');

        return DataTables::of($periodes)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            // menambahkan kolom aksi
            ->addColumn('aksi', function ($periode) {

                $btn  = '<button onclick="modalAction(\''.url('/periode/' . $periode->id_angkatan . '/show_ajax').'\')" class="btn btn-info btn-sm">
                            <i class="bi bi-eye"></i><span class="ms-2">Detail</span>
                        </button> ';
                $btn .= '<button onclick="modalAction(\''.url('/periode/' . $periode->id_angkatan . '/edit_ajax').'\')" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i><span class="ms-2">Edit</span>
                        </button> ';
                $btn .= '<button onclick="modalAction(\''.url('/periode/' . $periode->id_angkatan . '/delete_ajax').'\')" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i><span class="ms-2">Hapus</span>
                        </button>';
                        
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function show_ajax(string $id) {
        $periode = AngkatanModel::find($id);

        return view('periode.show_ajax', ['periode' => $periode]);
    }

    public function create_ajax() {
        return view('periode.create_ajax');
    }

    public function store_ajax(Request $request) {
        // cek apakah request berupa ajax
        if($request->ajax() || $request->wantsJson()) {
            $rules = [
                'semester'      => 'required|string|max:10',    
                'tahun_ajaran'  => 'required|string|max:255',   
            ];

            $validator = Validator::make($request->all(), $rules);
    
            if($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors(), // pesan error validasi
                ]);
            }
    
            AngkatanModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data periode semester berhasil disimpan'
            ]);
        }
    
        redirect('/');
    } 

    public function edit_ajax(string $id) {
        $periode = AngkatanModel::find($id);

        return view('periode.edit_ajax', ['periode' => $periode]);
    }

    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
               'semester'      => 'required|string|max:10',     
               'tahun_ajaran'  => 'required|string|max:255',  
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }

            $periode = AngkatanModel::find($id);
            if ($periode) {
                $periode->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function confirm_ajax(string $id) {
        $periode = AngkatanModel::find($id);

        return view('periode.confirm_ajax', ['periode' => $periode]);
     }

    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $periode = AngkatanModel::find($id);
            if ($periode) {
                $periode->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
}