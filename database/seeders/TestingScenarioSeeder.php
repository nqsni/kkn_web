<?php

namespace Database\Seeders;

use App\Models\PeriodeKkn;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestingScenarioSeeder extends Seeder
{
    public function run(): void
    {
        $periode = PeriodeKkn::firstOrCreate(
            ['nama' => 'Periode 2028'],
            [
                'tanggal_mulai' => '2028-08-01',
                'tanggal_selesai' => '2028-12-31',
                'status' => 'aktif',
            ]
        );

        // Password semua akun: 08082026 (hasil dari tanggal_lahir 2026-08-08)
        $tanggalLahir = '2026-08-08';
        $password = Hash::make('08082026');

        $akunList = [
            ['name' => 'Super Admin', 'email' => 'admin@mail.com', 'role' => 'super_admin'],
            ['name' => 'Panitia KKN', 'email' => 'panitia@mail.com', 'role' => 'panitia_kkn'],
            ['name' => 'Dosen Satu', 'email' => 'dsatu@mail.com', 'role' => 'dosen_pembimbing'],
            ['name' => 'Dosen Dua', 'email' => 'ddua@mail.com', 'role' => 'dosen_pembimbing'],
            ['name' => 'Mahasiswa Satu', 'email' => 'msatu@mail.com', 'role' => 'mahasiswa'],
            ['name' => 'Mahasiswa Dua', 'email' => 'mdua@mail.com', 'role' => 'mahasiswa'],
            ['name' => 'Mahasiswa Tiga', 'email' => 'mtiga@mail.com', 'role' => 'mahasiswa'],
            ['name' => 'Mahasiswa Empat', 'email' => 'mempat@mail.com', 'role' => 'mahasiswa'],
        ];

        foreach ($akunList as $akun) {
            $user = User::firstOrCreate(
                ['email' => $akun['email']],
                [
                    'name' => $akun['name'],
                    'tanggal_lahir' => $tanggalLahir,
                    'password' => $password,
                    'email_verified_at' => now(),
                ]
            );

            if (!$user->hasRole($akun['role'])) {
                $user->assignRole($akun['role']);
            }

            $sudahDiPeriode = $periode->users()->where('user_id', $user->id)->exists();
            if (!$sudahDiPeriode) {
                $periode->users()->attach($user->id, ['role_saat_itu' => $akun['role']]);
            }
        }
    }
}