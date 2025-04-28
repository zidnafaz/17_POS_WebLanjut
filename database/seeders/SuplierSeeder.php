<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuplierSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('m_suplier')->insert([
            [
                'kode_suplier' => 'SUP001',
                'nama_suplier' => 'PT Sumber Makmur',
                'no_telepon' => '081234567890',
                'alamat' => 'Jl. Merdeka No. 12, Jakarta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_suplier' => 'SUP002',
                'nama_suplier' => 'CV Anugrah Jaya',
                'no_telepon' => '082345678901',
                'alamat' => 'Jl. Sudirman No. 45, Bandung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_suplier' => 'SUP003',
                'nama_suplier' => 'PT Indoteknik',
                'no_telepon' => '083456789012',
                'alamat' => 'Jl. Diponegoro No. 21, Surabaya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_suplier' => 'SUP004',
                'nama_suplier' => 'UD Sinar Terang',
                'no_telepon' => '084567890123',
                'alamat' => 'Jl. Gajah Mada No. 9, Medan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_suplier' => 'SUP005',
                'nama_suplier' => 'PT Maju Bersama',
                'no_telepon' => '085678901234',
                'alamat' => 'Jl. Ahmad Yani No. 5, Semarang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_suplier' => 'SUP006',
                'nama_suplier' => 'CV Cipta Prima',
                'no_telepon' => '086789012345',
                'alamat' => 'Jl. Siliwangi No. 17, Yogyakarta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_suplier' => 'SUP007',
                'nama_suplier' => 'PT Sentosa Abadi',
                'no_telepon' => '087890123456',
                'alamat' => 'Jl. Panglima Sudirman No. 30, Malang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_suplier' => 'SUP008',
                'nama_suplier' => 'UD Karya Sejahtera',
                'no_telepon' => '088901234567',
                'alamat' => 'Jl. Kartini No. 3, Bali',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_suplier' => 'SUP009',
                'nama_suplier' => 'PT Mega Supply',
                'no_telepon' => '089012345678',
                'alamat' => 'Jl. Pemuda No. 50, Makassar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_suplier' => 'SUP010',
                'nama_suplier' => 'CV Gemilang',
                'no_telepon' => '081345678912',
                'alamat' => 'Jl. Hasanuddin No. 14, Balikpapan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
