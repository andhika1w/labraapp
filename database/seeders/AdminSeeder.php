<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Buat akun admin pertama untuk sistem.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@labra.id'],
            [
                'name'      => 'Administrator',
                'password'  => Hash::make('admin123'),
                'role'      => 'admin',
                'nip'       => '198001012010011001',
                'is_active' => true,
            ]
        );
    }
}
