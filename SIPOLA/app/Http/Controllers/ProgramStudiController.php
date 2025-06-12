<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProgramStudiModel;
use Yajra\DataTables\Facades\DataTables;

class ProgramStudiController extends Controller
{
    public function index()
    {
        return view('admin.ManajemenProdi.index');
    } 

    public function list(Request $request)
{
    $data = ProgramStudiModel::query();

    if ($request->jenjang) {
        $data->where('jenjang', $request->jenjang);
    }

    return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('aksi', function ($row) {
            $detailBtn = '<button onclick="modalAction(\'' . url("admin/ManajemenProdi/{$row->id_prodi}/show_ajax") . '\')" class="btn btn-sm btn-info">Detail</button>';
            $editBtn = '<button onclick="modalAction(\'' . url("admin/ManajemenProdi/{$row->id_prodi}/edit_ajax") . '\')" class="btn btn-sm btn-warning">Edit</button>';
            $deleteBtn = '<button onclick="modalAction(\'' . url("admin/ManajemenProdi/{$row->id_prodi}/delete_ajax") . '\')" class="btn btn-sm btn-danger">Hapus</button>';
            return $detailBtn . ' ' . $editBtn . ' ' . $deleteBtn;
        })
        ->rawColumns(['aksi'])
        ->make(true);
}

    public function create_ajax()
    {
        return view('admin.ManajemenProdi.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        $request->validate([
            'nama_prodi' => 'required|string|max:100',      //cegah injection
            'jenjang'    => 'required|in:D2,D3,D4',
        ]);
        ProgramStudiModel::create($request->only('nama_prodi', 'jenjang'));
        return response()->json(['success' => true]);
    }

    public function show_ajax($id)
    {
        $prodi = ProgramStudiModel::findOrFail($id);
        return view('admin.ManajemenProdi.show_ajax', compact('prodi'));
    }

    public function edit_ajax($id)
    {
        $prodi = ProgramStudiModel::findOrFail($id);
        return view('admin.ManajemenProdi.edit_ajax', compact('prodi'));
    }

    public function update_ajax(Request $request, $id)
    {
    $request->validate([
        'nama_prodi' => 'required|string|max:100',      //cegah injection
        'jenjang'    => 'required|in:D2,D3,D4',
    ]);

    $prodi = ProgramStudiModel::findOrFail($id); 
    $prodi->update([
        'nama_prodi' => $request->nama_prodi,
        'jenjang'    => $request->jenjang,
    ]);

    return response()->json(['success' => true, 'status' => true]);
    }


   public function confirm_ajax($id)
    {
    $prodi = ProgramStudiModel::find($id);
    return view('admin.ManajemenProdi.confirm_ajax', compact('prodi'));
    }


    // Menghapus data Program Studi via AJAX
    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $prodi = ProgramStudiModel::find($id);
            if ($prodi) {
                $prodi->delete();
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