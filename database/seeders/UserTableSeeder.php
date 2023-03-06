<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'nama' => 'Fira Ferista',
                'username' => 'firaferista',
                'email' => 'fira.ferista@gmail.com',
                'jabatan_id' => 1,
                'avatar' => 'default.jpg',
                'password' => Hash::make('password'),
                'aktif' => 1,
                'role' => 'Kepala Sekolah',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'nama' => 'Irwan Supriawansyah',
                'username' => 'irwan',
                'email' => 'irwan.supriawansyah@gmail.com',
                'jabatan_id' => 2,
                'avatar' => 'default.jpg',
                'password' => Hash::make('password'),
                'aktif' => 1,
                'role' => 'Admin',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'nama' => 'Mochamad Maulana',
                'username' => 'mochamadmaulana',
                'email' => 'mochamad.maulana@raharja.info',
                'jabatan_id' => 3,
                'avatar' => 'default.jpg',
                'password' => Hash::make('password'),
                'aktif' => 1,
                'role' => 'User',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
        ];
        DB::table('users')->insert($users);
    }
}
