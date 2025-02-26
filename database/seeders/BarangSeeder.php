<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kategori_id' => 1, 'barang_kode' => 'BRG001', 'barang_nama' => 'Laptop', 'harga_beli' => 5000000, 'harga_jual' => 5500000],
            ['kategori_id' => 1, 'barang_kode' => 'BRG002', 'barang_nama' => 'Smartphone', 'harga_beli' => 3000000, 'harga_jual' => 3500000],
            ['kategori_id' => 2, 'barang_kode' => 'BRG003', 'barang_nama' => 'Kaos', 'harga_beli' => 50000, 'harga_jual' => 75000],
            ['kategori_id' => 2, 'barang_kode' => 'BRG004', 'barang_nama' => 'Celana Jeans', 'harga_beli' => 150000, 'harga_jual' => 200000],
            ['kategori_id' => 3, 'barang_kode' => 'BRG005', 'barang_nama' => 'Nasi Goreng', 'harga_beli' => 15000, 'harga_jual' => 20000],
            ['kategori_id' => 3, 'barang_kode' => 'BRG006', 'barang_nama' => 'Mie Ayam', 'harga_beli' => 12000, 'harga_jual' => 18000],
            ['kategori_id' => 4, 'barang_kode' => 'BRG007', 'barang_nama' => 'Kopi', 'harga_beli' => 5000, 'harga_jual' => 10000],
            ['kategori_id' => 4, 'barang_kode' => 'BRG008', 'barang_nama' => 'Teh Botol', 'harga_beli' => 3000, 'harga_jual' => 6000],
            ['kategori_id' => 5, 'barang_kode' => 'BRG009', 'barang_nama' => 'Meja Kayu', 'harga_beli' => 250000, 'harga_jual' => 300000],
            ['kategori_id' => 5, 'barang_kode' => 'BRG010', 'barang_nama' => 'Kursi Plastik', 'harga_beli' => 50000, 'harga_jual' => 70000],
        ];

        DB::table('m_barang')->insert($data);
    }
}
