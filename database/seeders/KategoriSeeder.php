<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kategori_kode' => 'KT001', 'kategori_nama' => 'Elektronik'],
            ['kategori_kode' => 'KT002', 'kategori_nama' => 'Pakaian'],
            ['kategori_kode' => 'KT003', 'kategori_nama' => 'Makanan'],
            ['kategori_kode' => 'KT004', 'kategori_nama' => 'Minuman'],
            ['kategori_kode' => 'KT005', 'kategori_nama' => 'Perabotan'],
        ];

        DB::table('m_kategori')->insert($data);
    }
}
