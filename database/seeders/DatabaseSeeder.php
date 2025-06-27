<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\PassDebug;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        PassDebug::create([
            'passDebug' => 'admin',
            ]);

        // Seed Users
        $admin = User::create([
            'nama' => 'Administrator',
            'email' => 'admin@gmail.com',
            'instansi'=> 'Kementrian Keamanan',
            'role' => '1',
            'status' => 1,
            'password' => bcrypt('admin'),
            'no_hp' => '08123456789',
            'foto' => 'admin.jpg',
        ]);

        // Seed Users
        $petugas = User::create([
            'nama' => 'Vestia Zeta',
            'email' => 'zeta@gmail.com',
            'instansi'=> 'Hololive Corporation',
            'role' => '2',
            'status' => 1,
            'password' => bcrypt('Zeta123*'),
            'no_hp' => '08123456710',
            'foto' => 'petugas.jpg',
        ]);

        $user = User::create([
            'nik'=> '1234567890123456',
            'nama' => 'Trisna Almuti',
            'email' => 'trisnahomie@gmail.com',
            'role' => '0',
            'status' => 1,
            'password' => bcrypt('123'),
            'no_hp' => '0895711856677',
            'foto' => '',
        ]);

        $user1 = User::create([
            'nik'=> '1234567890123456',
            'nama' => 'Fathur Rahman',
            'email' => 'fathur@gmail.com',
            'role' => '0',
            'status' => 1,
            'password' => bcrypt('123'),
            'no_hp' => '089575567890',
            'foto' => '',
        ]);

        $user2 = User::create([
            'nik'=> '1234567890123456',
            'nama' => 'Zainal Abidin',
            'email' => 'zainal@gmail.com',
            'role' => '0',
            'status' => 0,
            'password' => bcrypt('123'),
            'no_hp' => '089575567890',
            'foto' => '',
        ]);
    }
}
