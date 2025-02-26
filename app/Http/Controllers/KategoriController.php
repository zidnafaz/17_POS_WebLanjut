<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index()
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

        $data = DB::select('select * from m_kategori');
        return view('kategori', ['data' => $data]);
    }
}
