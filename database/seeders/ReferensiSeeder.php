<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReferensiSeeder extends Seeder
{
    public function run()
    {
        DB::table('referensi')->insert([
            [
                'jenis'     => 3,
                'id'        => 0,
                'deskripsi' => 'Batal',
                'ref_id'    => '0',
                'teks'      => 'status verifikasi',
                'status'    => 1,
            ],
            [
                'jenis'     => 3,
                'id'        => 1,
                'deskripsi' => 'belum diverifikasi',
                'ref_id'    => '1',
                'teks'      => 'status verifikasi',
                'status'    => 1,
            ],
            [
                'jenis'     => 3,
                'id'        => 3,
                'deskripsi' => 'terverifikasi',
                'ref_id'    => '3',
                'teks'      => 'status verifikasi',
                'status'    => 1,
            ],
            [
                'jenis'     => 3,
                'id'        => 4,
                'deskripsi' => 'butuh perbaikan',
                'ref_id'    => '4',
                'teks'      => 'status verifikasi',
                'status'    => 1,
            ],
            
        ]);
    }
}