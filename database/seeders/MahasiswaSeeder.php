<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MahasiswaSeeder extends Seeder
{
    /**
     * Buat akun mahasiswa pertama (dummy) untuk testing.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'mahasiswa@labra.id'],
            [
                'name'          => 'Mahasiswa Dummy',
                'password'      => Hash::make('mahasiswa123'),
                'role'          => 'user',
                'nim'           => '202609001',
                'program_studi' => 'Teknik Informatika',
                'is_active'     => true,
            ]
        );
    }
}
