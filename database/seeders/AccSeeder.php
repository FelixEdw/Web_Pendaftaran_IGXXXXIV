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
            'name' => "admin",
            'role' => 'admin',
            'password' => bcrypt("admin@ig33"),
        ]);

        User::create([
            'name' => "jolem",
            'role' => 'admin',
            'password' => bcrypt("jolem@ig33"),
        ]);
        
        User::create([
            'name' => "angel",
            'role' => 'admin',
            'password' => bcrypt("angel@ig33"),
        ]);

         User::create([
            'name' => "steven",
            'role' => 'admin',
            'password' => bcrypt("steven@ig33"),
        ]);
        
         User::create([
            'name' => "federico",
            'role' => 'admin',
            'password' => bcrypt("federico@ig33"),
        ]);
        
         User::create([
            'name' => "philander",
            'role' => 'admin',
            'password' => bcrypt("philander@ig33"),
        ]);
        
         User::create([
            'name' => "evan",
            'role' => 'admin',
            'password' => bcrypt("evan@ig33"),
        ]);
        
         User::create([
            'name' => "brandon",
            'role' => 'admin',
            'password' => bcrypt("brandon@ig33"),
        ]);
        
         User::create([
            'name' => "rakel",
            'role' => 'admin',
            'password' => bcrypt("rakel@ig33"),
        ]);
        
         User::create([
            'name' => "nico",
            'role' => 'admin',
            'password' => bcrypt("nico@ig33"),
        ]);
        
         User::create([
            'name' => "gaby",
            'role' => 'admin',
            'password' => bcrypt("gaby@ig33"),
        ]);
        
         User::create([
            'name' => "wahyu",
            'role' => 'admin',
            'password' => bcrypt("wahyu@ig33"),
        ]);
        
         User::create([
            'name' => "lady",
            'role' => 'admin',
            'password' => bcrypt("lady@ig33"),
        ]);
        
         User::create([
            'name' => "armando",
            'role' => 'admin',
            'password' => bcrypt("armando@ig33"),
        ]);
        
         User::create([
            'name' => "jason",
            'role' => 'admin',
            'password' => bcrypt("jason@ig33"),
        ]);
        
         User::create([
            'name' => "yuriko",
            'role' => 'admin',
            'password' => bcrypt("yuriko@ig33"),
        ]);
        
         User::create([
            'name' => "albert",
            'role' => 'admin',
            'password' => bcrypt("albert@ig33"),
        ]);
        
         User::create([
            'name' => "frederico",
            'role' => 'admin',
            'password' => bcrypt("frederico@ig33"),
        ]);
        
         User::create([
            'name' => "safira",
            'role' => 'admin',
            'password' => bcrypt("safira@ig33"),
        ]);
        
         User::create([
            'name' => "david",
            'role' => 'admin',
            'password' => bcrypt("david@ig33"),
        ]);
        
         User::create([
            'name' => "yovent",
            'role' => 'admin',
            'password' => bcrypt("yovent@ig33"),
        ]);
        
         User::create([
            'name' => "jeslyn",
            'role' => 'admin',
            'password' => bcrypt("jeslyn@ig33"),
        ]);
        
         User::create([
            'name' => "grace",
            'role' => 'admin',
            'password' => bcrypt("grace@ig33"),
        ]);
        
         User::create([
            'name' => "monica",
            'role' => 'admin',
            'password' => bcrypt("monica@ig33"),
        ]);
        
         User::create([
            'name' => "joice",
            'role' => 'admin',
            'password' => bcrypt("joice@ig33"),
        ]);
        
         User::create([
            'name' => "felice",
            'role' => 'admin',
            'password' => bcrypt("felice@ig33"),
        ]);
    }
}
