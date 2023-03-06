<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JabatanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jabatan = [
            [
                'nama' => 'Kepala Sekolah',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'nama' => 'Staff TU',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'nama' => 'Ketua OSIS',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'nama' => 'Ketua MPK',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'nama' => 'Ketua Olah Raga',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'nama' => 'Katua Seni Tari',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'nama' => 'Ketua PMR',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'nama' => 'Ketua Paskibra',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
        ];
        DB::table('jabatans')->insert($jabatan);
    }
}
