<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['penjualan_id'=> 1,'user_id' => 1, 'pembeli' => 'Pembeli_1', 'penjualan_kode' => 'JL_1', 'penjualan _tanggal' => '2024-01-10 09:00:00'],
            ['penjualan_id'=> 2,'user_id' => 1, 'pembeli' => 'Pembeli_2', 'penjualan_kode' => 'JL_2', 'penjualan _tanggal' => '2024-01-10 09:00:00'],
            ['penjualan_id'=> 3,'user_id' => 1, 'pembeli' => 'Pembeli_3', 'penjualan_kode' => 'JL_3', 'penjualan _tanggal' => '2024-01-10 09:00:00'],
            ['penjualan_id'=> 4,'user_id' => 3, 'pembeli' => 'Pembeli_4', 'penjualan_kode' => 'JL_4', 'penjualan _tanggal' => '2024-01-10 09:00:00'],
            ['penjualan_id'=> 5,'user_id' => 3, 'pembeli' => 'Pembeli_5', 'penjualan_kode' => 'JL_5', 'penjualan _tanggal' => '2024-01-11 09:00:00'],
            ['penjualan_id'=> 6,'user_id' => 3, 'pembeli' => 'Pembeli_6', 'penjualan_kode' => 'JL_6', 'penjualan _tanggal' => '2024-01-11 10:00:00'],
            ['penjualan_id'=> 7,'user_id' => 3, 'pembeli' => 'Pembeli_7', 'penjualan_kode' => 'JL_7', 'penjualan _tanggal' => '2024-01-11 10:00:00'],
            ['penjualan_id'=> 8,'user_id' => 3, 'pembeli' => 'Pembeli_8', 'penjualan_kode' => 'JL_8', 'penjualan _tanggal' => '2024-01-11 10:00:00'],
            ['penjualan_id'=> 9,'user_id' => 2, 'pembeli' => 'Pembeli_9', 'penjualan_kode' => 'JL_9', 'penjualan _tanggal' => '2024-01-11 10:00:00'],
            ['penjualan_id'=> 10,'user_id' => 2, 'pembeli' => 'Pembeli_10', 'penjualan_kode' => 'JL_10', 'penjualan _tanggal' => '2024-01-11 10:00:00'],           

        ];
        DB::table('t_penjualan')->insert($data);
    }
}
