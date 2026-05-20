<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MuridImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // 1. Cek apakah Guru dengan email ini sudah ada di database?
        $guru = User::where('role', 'guru')
                    ->where('email', $row['email_guru'])
                    ->first();

        // 2. Kalau Gurunya BELUM ADA, kita BIKIN SEKALIAN!
        if (!$guru) {
            $guru = User::create([
                'name'     => $row['nama_guru'],
                'email'    => $row['email_guru'],
                'password' => Hash::make('guru1234'), // Sandi default buat Guru Baru
                'role'     => 'guru',
            ]);
        }

        // 3. Bikin email otomatis buat murid (biar simpel)
        $emailMurid = strtolower(str_replace(' ', '', $row['nama_murid'])) . '@siswa.com';
        
        // Jaga-jaga kalau ada murid yang namanya sama persis
        if (User::where('email', $emailMurid)->exists()) {
            $emailMurid = strtolower(str_replace(' ', '', $row['nama_murid'])) . rand(10,99) . '@siswa.com';
        }

        // 4. Masukkan data Murid & Langsung hubungkan dengan ID Guru tadi!
        return new User([
            'name'     => $row['nama_murid'],
            'email'    => $emailMurid,
            'username' => $row['nisn'],
            'password' => Hash::make('12345678'), // Sandi default buat Murid
            'role'     => 'murid',
            'guru_id'  => $guru->id, // OTOMATIS BERJODOH!
        ]);
    }
}