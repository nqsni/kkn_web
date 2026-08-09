<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Jalankan pembuatan Role terlebih dahulu
        $this->call([
            RoleSeeder::class,
        ]);

        // 2. Buat satu akun dummy khusus mahasiswa
        $mahasiswa = User::create([
            'name' => 'Akun Mahasiswa Uji Coba',
            'email' => 'mahasiswa@kampus.com',
            'password' => Hash::make('password123'), // Kata sandi untuk login
        ]);

        // 3. Tempelkan role 'mahasiswa' ke akun yang baru dibuat
        $mahasiswa->assignRole('mahasiswa');

        $dosen = User::create([
            'name' => 'Ahmadi Dosen',
            'email' => '12345678@kampus.com', // Anggap ini sebagai NIK sementara
            'password' => Hash::make('password123'),
        ]);
        $dosen->assignRole('dosen_pembimbing');

        $panitia = User::create([
            'name' => 'Wahyu',
            'email' => 'why@kampus.com', // Anggap ini sebagai NIK sementara
            'password' => Hash::make('password123'),
        ]);
        $panitia->assignRole('panitia_kkn');

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@kampus.com', // Anggap ini sebagai NIK sementara
            'password' => Hash::make('password123'),
        ]);
        $admin->assignRole('super_admin');
    }


}