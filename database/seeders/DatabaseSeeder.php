<?php

namespace Database\Seeders;

use App\Models\Kategory;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create(
            [
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
            ]
        );

        User::factory()->create(
            [
                'name' => 'User',
                'email' => 'user@gmail.com',
                'password' => bcrypt('user123'),
                'role' => 'karyawan',
            ]
        );

        Kategory::factory()->create([
            'nama' => 'Makanan',
            'deskripsi' => 'Kategori untuk produk makanan',
        ]);

        Supplier::factory()->create([
            'nama' => 'Supplier A',
            'alamat' => 'Jl. Contoh Alamat No. 123, Kota Contoh',
            'telepon' => '081234567890',
        ]);

    }
}
