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
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
            ]
        );
        $admin->syncRoles(['admin']);

        // Create Guru User
        $guru = User::updateOrCreate(
            ['email' => 'guru@example.com'],
            [
                'name' => 'Guru User',
                'password' => Hash::make('password123'),
            ]
        );
        $guru->syncRoles(['guru']);

        // Create Kepala Sekolah User
        $kepalaSekolah = User::updateOrCreate(
            ['email' => 'kepala_sekolah@example.com'],
            [
                'name' => 'Kepala Sekolah User',
                'password' => Hash::make('password123'),
            ]
        );
        $kepalaSekolah->syncRoles(['kepala_sekolah']);

        // Create Pengawas User
        $pengawas = User::updateOrCreate(
            ['email' => 'pengawas@example.com'],
            [
                'name' => 'Pengawas User',
                'password' => Hash::make('password123'),
            ]
        );
        $pengawas->syncRoles(['pengawas']);

        // Create Siswa User
        $siswa = User::updateOrCreate(
            ['email' => 'siswa@example.com'],
            [
                'name' => 'Siswa User',
                'password' => Hash::make('password123'),
            ]
        );
        $siswa->syncRoles(['siswa']);
    }
}
