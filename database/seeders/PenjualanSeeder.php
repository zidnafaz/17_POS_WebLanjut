<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PenjualanSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('t_penjualan')->insert([
                'user_id' => 3, // Hanya user ID 3 sebagai kasir
                'pembeli' => 'Pembeli ' . $i,
                'penjualan_kode' => 'PJ' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'penjualan_tanggal' => Carbon::now()->subDays(rand(1, 30)),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
