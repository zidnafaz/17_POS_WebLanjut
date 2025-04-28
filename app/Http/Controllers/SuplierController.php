<?php

namespace App\Http\Controllers;

use App\Models\SuplierModel;
use Illuminate\Http\Request;
use App\DataTables\SuplierDataTable;

class SuplierController extends Controller
{
    public function index(SuplierDataTable $dataTable)
    {
        return $dataTable->render('suplier.index');
    }

    public function create_ajax()
    {
        return view('suplier.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        $request->validate([
            'kode_suplier' => 'required|string|max:10',
            'nama_suplier' => 'required|string|max:100',
            'no_telepon' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
        ]);

        SuplierModel::create([
            'kode_suplier' => $request->kode_suplier,
            'nama_suplier' => $request->nama_suplier,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
        ]);

        return response()->json(['success' => true]);
    }

    public function edit_ajax($id)
    {
        $suplier = SuplierModel::findOrFail($id);
        return view('suplier.edit_ajax', compact('suplier'));
    }

    public function update_ajax(Request $request, $id)
    {
        $request->validate([
            'kode_suplier' => 'required|string|max:10',
            'nama_suplier' => 'required|string|max:100',
            'no_telepon' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
        ]);

        $suplier = SuplierModel::findOrFail($id);
        $suplier->update([
            'kode_suplier' => $request->kode_suplier,
            'nama_suplier' => $request->nama_suplier,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
        ]);

        return response()->json(['success' => true]);
    }

    public function confirm_ajax($id)
    {
        $suplier = SuplierModel::findOrFail($id);
        return view('suplier.confirm_ajax', compact('suplier'));
    }

    public function delete_ajax($id)
    {
        $suplier = SuplierModel::findOrFail($id);
        $suplier->delete();

        return response()->json(['success' => true]);
    }

    public function detail_ajax($id)
    {
        $suplier = SuplierModel::findOrFail($id);
        return view('suplier.detail_ajax', compact('suplier'));
    }
}
