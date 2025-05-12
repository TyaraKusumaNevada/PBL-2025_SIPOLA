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
            $detailBtn = '<button onclick="modalAction(\'' . url("admin/ManajemenProdi/{$row->id}/detail_ajax") . '\')" class="btn btn-sm btn-info">Detail</button>';
            $editBtn = '<button onclick="modalAction(\'' . url("admin/ManajemenProdi/{$row->id}/edit_ajax") . '\')" class="btn btn-sm btn-warning">Edit</button>';
            $deleteBtn = '<button onclick="modalAction(\'' . url("admin/ManajemenProdi/delete_ajax/{$row->id}") . '\')" class="btn btn-sm btn-danger">Hapus</button>';
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
            'nama_prodi' => 'required|string|max:255',
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
            'nama_prodi' => 'required|string|max:255',
            'jenjang'    => 'required|in:D2,D3,D4',
        ]);
        $prodi = ProgramStudiModel::findOrFail($id);
        $prodi->update($request->only('nama_prodi', 'jenjang'));
        return response()->json(['success' => true]);
        
    }

    public function delete_ajax($id)
    {
        ProgramStudiModel::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}



