<?php

use App\Position;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return   Position::insert([
            [
                'name' => 'Pengelola Akuntansi',
                'description' => 'Melakukan kegiatan pengelolaan dan penyusunan laporan di bidang akuntansi.',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name' => 'Analis Laporan Keuangan',
                'description' => 'Melakukan kegiatan analisis dan penelaahan laporan keuangan dalam rangka penyusunan rekomendasi kebijakan di bidang keuangan.',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name' => 'Pengelola Data Transaksi',
                'description' => 'Melakukan kegiatan pengelolaan dan penyusunan laporan di bidang data transaksi.',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);
    }
}
