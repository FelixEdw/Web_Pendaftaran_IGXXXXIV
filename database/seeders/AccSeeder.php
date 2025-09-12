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
            'nama_tim' => "b",
            'password' => "123",
            'asal_sekolah' => "kelaz",
            'foto_bukti_pembayaran' => ""
        ]);

        User::create([
            'name' => "b",
            'role' => 'peserta',
            'password' => bcrypt(123), 
        ]);

               Team::create([
            'nama_tim' => "c",
            'password' => "123",
            'asal_sekolah' => "mahal",
            'foto_bukti_pembayaran' => ""
        ]);

        User::create([
            'name' => "c",
            'role' => 'peserta',
            'password' => bcrypt(123), 
        ]);
        User::create([
            'name' => "c",
            'role' => 'peserta',
            'password' => bcrypt(123), 
        ]);

        User::create([
            'name' => "jolem",
            'role' => 'admin',
            'password' => bcrypt("jolem"),
        ]);
        
        User::create([
            'name' => "angel",
            'role' => 'admin',
            'password' => bcrypt("angel"),
        ]);

         User::create([
            'name' => "steven",
            'role' => 'admin',
            'password' => bcrypt("steven"),
        ]);
        
         User::create([
            'name' => "federico",
            'role' => 'admin',
            'password' => bcrypt("federico"),
        ]);
        
         User::create([
            'name' => "philander",
            'role' => 'admin',
            'password' => bcrypt("philander"),
        ]);
        
         User::create([
            'name' => "evan",
            'role' => 'admin',
            'password' => bcrypt("evan"),
        ]);
        
         User::create([
            'name' => "rakel",
            'role' => 'admin',
            'password' => bcrypt("rakel"),
        ]);
        
         User::create([
            'name' => "nico",
            'role' => 'admin',
            'password' => bcrypt("nico"),
        ]);
        
         User::create([
            'name' => "gaby",
            'role' => 'admin',
            'password' => bcrypt("gaby"),
        ]);
        
         User::create([
            'name' => "wahyu",
            'role' => 'admin',
            'password' => bcrypt("wahyu"),
        ]);
        
         User::create([
            'name' => "lady",
            'role' => 'admin',
            'password' => bcrypt("lady"),
        ]);
        
         User::create([
            'name' => "armando",
            'role' => 'admin',
            'password' => bcrypt("armando"),
        ]);
        
         User::create([
            'name' => "jason",
            'role' => 'admin',
            'password' => bcrypt("jason"),
        ]);
        
         User::create([
            'name' => "yuriko",
            'role' => 'admin',
            'password' => bcrypt("yuriko"),
        ]);
        
         User::create([
            'name' => "albert",
            'role' => 'admin',
            'password' => bcrypt("albert"),
        ]);
        
         User::create([
            'name' => "frederico",
            'role' => 'admin',
            'password' => bcrypt("frederico"),
        ]);
        
         User::create([
            'name' => "safira",
            'role' => 'admin',
            'password' => bcrypt("safira"),
        ]);
        
         User::create([
            'name' => "david",
            'role' => 'admin',
            'password' => bcrypt("david"),
        ]);
        
         User::create([
            'name' => "yovent",
            'role' => 'admin',
            'password' => bcrypt("yovent"),
        ]);
        
         User::create([
            'name' => "jeselin",
            'role' => 'admin',
            'password' => bcrypt("jeselin"),
        ]);
        
         User::create([
            'name' => "grace",
            'role' => 'admin',
            'password' => bcrypt("grace"),
        ]);
        
         User::create([
            'name' => "monica",
            'role' => 'admin',
            'password' => bcrypt("monica"),
        ]);
        
         User::create([
            'name' => "joice",
            'role' => 'admin',
            'password' => bcrypt("joice"),
        ]);
        
         User::create([
            'name' => "felice",
            'role' => 'admin',
            'password' => bcrypt("felice"),
        ]);
    }
}
