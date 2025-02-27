<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LevelController extends Controller
{
    public function index()
    {
        // DB::insert('insert into m_level(level_kode, level_nama, created_at) value(?, ?, ?)', ['CUS', 'Pelanggan', now()]);
        // $message = 'Insert data berhasil';

        // // Kirim hasil update ke view
        // return view('level', compact('message'));

        // // Melakukan update data
        // $row = DB::update('update m_level set level_nama = ? where level_kode = ?', ['Customer', 'CUS']);
        // $message = 'Update data berhasil. Jumlah data yang diupdate: ' . $row . ' baris';

        // // Kirim hasil update ke view
        // return view('level', compact('message'));

        // $row = DB::delete('delete from m_level where level_kode = ?', ['CUS']);
        // $message = 'Delete data berhasil. Jumlah data yang dihapus : ' . $row . ' baris';

        // return view('level', compact('message'));

        $data = DB::select('select * from m_level');
        return view('level', ['data' => $data]);
    }
}
