<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) { // 10 transaksi
            $barang_ids = DB::table('m_barang')->inRandomOrder()->limit(3)->pluck('barang_id');

            foreach ($barang_ids as $barang_id) {
                $harga = DB::table('m_barang')->where('barang_id', $barang_id)->value('harga_jual');

                DB::table('t_penjualan_detail')->insert([
                    'penjualan_id' => $i,
                    'barang_id' => $barang_id,
                    'harga' => $harga,
                    'jumlah' => rand(1, 5),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
