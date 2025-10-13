<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::updateOrCreate(['name' => 'admin']);
        Role::updateOrCreate(['name' => 'guru']);
        Role::updateOrCreate(['name' => 'kepala_sekolah']);
        Role::updateOrCreate(['name' => 'pengawas']);
        Role::updateOrCreate(['name' => 'siswa']);
    }
}
