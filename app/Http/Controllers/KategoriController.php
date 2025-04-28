<?php

namespace App\Http\Controllers;

use App\DataTables\KategoriDataTable;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index(KategoriDataTable $dataTable)
    {
        // $data = [
        //     [
        //         'kategori_kode' => 'KT006',
        //         'kategori_nama' => 'Snack/Makanan Ringan',
        //         'created_at' => now()
        //     ],
        // ];

        // DB::table('m_kategori')->insert($data);

        // $message = 'Insert data baru berhasil';
        // return view('kategori', compact('message'));

        // $row = DB::table('m_kategori')->where('kategori_kode', 'KT006')
        //                                      ->update(['kategori_nama' => 'Camilan']);
        // $message = 'Update data berhasil.  Jumlah data yang ditambahkan : ' . $row . ' baris';

        // return view('kategori', compact('message'));

        // $row = DB::table('m_kategori')->where('kategori_kode', 'KT006')->delete();
        // $message = 'Update data berhasil.  Jumlah data yang dihapus : ' . $row . ' baris';

        // return view('kategori', compact('message'));

        // $data = DB::select('select * from m_kategori');
        // return view('kategori', ['data' => $data]);

        return $dataTable->render('kategori.index');
    }

    public function create_ajax()
    {
        return view('kategori.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        $request->validate([
            'kategori_kode' => 'required|string|max:255',
            'kategori_nama' => 'required|string|max:255',
        ]);

        KategoriModel::create([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
        ]);

        return response()->json(['success' => true]);
    }

    public function edit_ajax($id)
    {
        $kategori = KategoriModel::findOrFail($id);
        return view('kategori.edit_ajax', compact('kategori'));
    }

    public function update_ajax(Request $request, $id)
    {
        $request->validate([
            'kategori_kode' => 'required|string|max:255',
            'kategori_nama' => 'required|string|max:255',
        ]);

        $kategori = KategoriModel::findOrFail($id);
        $kategori->update([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        //
    }

    public function confirm_ajax($id)
    {
        $kategori = KategoriModel::findOrFail($id);
        return view('kategori.confirm_ajax', compact('kategori'));
    }

    public function delete_ajax($id)
    {
        $kategori = KategoriModel::findOrFail($id);
        $kategori->delete();

        return response()->json(['success' => true]);
    }

public function detail_ajax($id)
{
    $kategori = KategoriModel::with('barang')->findOrFail($id);
    $jumlahProduk = $kategori->barang->count();
    return view('kategori.detail_ajax', compact('kategori', 'jumlahProduk'));
}
}
