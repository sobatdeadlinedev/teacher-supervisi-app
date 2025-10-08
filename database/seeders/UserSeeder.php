<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
        ]);
        $admin->assignRole('admin');

        // Create Guru User
        $guru = User::create([
            'name' => 'Guru User',
            'email' => 'guru@example.com',
            'password' => Hash::make('password123'),
        ]);
        $guru->assignRole('guru');

        // Create Kepala Sekolah User
        $kepalaSekolah = User::create([
            'name' => 'Kepala Sekolah User',
            'email' => 'kepala_sekolah@example.com',
            'password' => Hash::make('password123'),
        ]);
        $kepalaSekolah->assignRole('kepala_sekolah');

        // Create Pengawas User
        $pengawas = User::create([
            'name' => 'Pengawas User',
            'email' => 'pengawas@example.com',
            'password' => Hash::make('password123'),
        ]);
        $pengawas->assignRole('pengawas');
    }
}
