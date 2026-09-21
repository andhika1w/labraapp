<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Seed kategori pengaduan default sesuai PRD.
     */
    public function run(): void
    {
        $categories = [
            'Ruang Kelas',
            'Laboratorium',
            'Toilet',
            'Perpustakaan',
            'Parkir',
            'Internet/WiFi',
            'AC',
            'Proyektor',
            'Lampu',
            'Meja',
            'Kursi',
            'Fasilitas Olahraga',
            'Lainnya',
        ];

        foreach ($categories as $name) {
            Category::firstOrCreate(
                ['name' => $name],
                ['is_active' => true]
            );
        }
    }
}
