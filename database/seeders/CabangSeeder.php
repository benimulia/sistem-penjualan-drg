<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cabang;


class CabangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $cabangs = [
            [
                'nama_cabang' => 'Pakan 1',
                'kategori' => 'Pakan',
                'alamat_cabang' => 'Labuan Bajo',
                'tgl_buka' => '2022-10-10',
            ],
            [
                'nama_cabang' => 'Telur 1',
                'kategori' => 'Telur',
                'alamat_cabang' => 'Labuan Bajo',
                'tgl_buka' => '2022-10-10',
            ],
            [
                'nama_cabang' => 'Telur 2',
                'kategori' => 'Telur',
                'alamat_cabang' => 'Labuan Bajo',
                'tgl_buka' => '2022-10-10',
            ]
        ];

        foreach ($cabangs as $cabang) {
            Cabang::create($cabang);
        }
    }
}
