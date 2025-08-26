<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\User;

class AccSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Team::create([
            'nama_tim' => "a",
            'password' => "123",
            'asal_sekolah' => "anjay",
            'foto_bukti_pembayaran' => ""
        ]);
        User::create([
            'name' => "a",
            'role' => 'peserta',
            'password' => bcrypt(123),
        ]);
        
        Team::create([
            'nama_tim' => "tes",
            'password' => "tes123",
            'asal_sekolah' => "Sekolah Tes",
            'foto_bukti_pembayaran' => ""
        ]);

        User::create([
            'name' => "tes",
            'role' => 'peserta',
            'password' => bcrypt(123), 
        ]);

        User::create([
            'name' => "admin",
            'role' => 'admin',
            'password' => bcrypt("admin123"),
        ]);
    }
}
