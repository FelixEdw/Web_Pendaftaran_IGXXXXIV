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
<<<<<<< Updated upstream
=======

        Team::create([
            'nama_tim' => "kelompok1",
            'password' => "kelompok1",
            'asal_sekolah' => "sekolah1",
            'foto_bukti_pembayaran' => ""
        ]);

        User::create([
            'name' => "kelompok1",
            'role' => 'peserta',
            'password' => bcrypt("kelompok1"),
        ]);

        Team::create([
            'nama_tim' => "kelompok2",
            'password' => "kelompok2",
            'asal_sekolah' => "sekolah2",
            'foto_bukti_pembayaran' => ""
        ]);

        User::create([
            'name' => "kelompok2",
            'role' => 'peserta',
            'password' => bcrypt("kelompok2"),
        ]);

        Team::create([
            'nama_tim' => "kelompok3",
            'password' => "kelompok3",
            'asal_sekolah' => "sekolah3",
            'foto_bukti_pembayaran' => ""
        ]);

        User::create([
            'name' => "kelompok3",
            'role' => 'peserta',
            'password' => bcrypt("kelompok3"),
        ]);

        Team::create([
            'nama_tim' => "kelompok4",
            'password' => "kelompok4",
            'asal_sekolah' => "sekolah4",
            'foto_bukti_pembayaran' => ""
        ]);

        User::create([
            'name' => "kelompok4",
            'role' => 'peserta',
            'password' => bcrypt("kelompok4"),
        ]);

        Team::create([
            'nama_tim' => "kelompok5",
            'password' => "kelompok5",
            'asal_sekolah' => "sekolah5",
            'foto_bukti_pembayaran' => ""
        ]);

        User::create([
            'name' => "kelompok5",
            'role' => 'peserta',
            'password' => bcrypt("kelompok5"),
        ]);

        Team::create([
            'nama_tim' => "kelompok6",
            'password' => "kelompok6",
            'asal_sekolah' => "sekolah6",
            'foto_bukti_pembayaran' => ""
        ]);

        User::create([
            'name' => "kelompok6",
            'role' => 'peserta',
            'password' => bcrypt("kelompok6"),
        ]);

        Team::create([
            'nama_tim' => "kelompok7",
            'password' => "kelompok7",
            'asal_sekolah' => "sekolah7",
            'foto_bukti_pembayaran' => ""
        ]);

        User::create([
            'name' => "kelompok7",
            'role' => 'peserta',
            'password' => bcrypt("kelompok7"),
        ]);

        Team::create([
            'nama_tim' => "kelompok8",
            'password' => "kelompok8",
            'asal_sekolah' => "sekolah8",
            'foto_bukti_pembayaran' => ""
        ]);

        User::create([
            'name' => "kelompok8",
            'role' => 'peserta',
            'password' => bcrypt("kelompok8"),
        ]);

        Team::create([
            'nama_tim' => "kelompok9",
            'password' => "kelompok9",
            'asal_sekolah' => "sekolah9",
            'foto_bukti_pembayaran' => ""
        ]);

        User::create([
            'name' => "kelompok9",
            'role' => 'peserta',
            'password' => bcrypt("kelompok9"),
        ]);

        Team::create([
            'nama_tim' => "kelompok10",
            'password' => "kelompok10",
            'asal_sekolah' => "sekolah10",
            'foto_bukti_pembayaran' => ""
        ]);

        User::create([
            'name' => "kelompok10",
            'role' => 'peserta',
            'password' => bcrypt("kelompok10"),
        ]);

        Team::create([
            'nama_tim' => "kelompok11",
            'password' => "kelompok11",
            'asal_sekolah' => "sekolah11",
            'foto_bukti_pembayaran' => ""
        ]);

        User::create([
            'name' => "kelompok11",
            'role' => 'peserta',
            'password' => bcrypt("kelompok11"),
        ]);

        Team::create([
            'nama_tim' => "kelompok12",
            'password' => "kelompok12",
            'asal_sekolah' => "sekolah12",
            'foto_bukti_pembayaran' => ""
        ]);

        User::create([
            'name' => "kelompok12",
            'role' => 'peserta',
            'password' => bcrypt("kelompok12"),
        ]);

        Team::create([
            'nama_tim' => "kelompok13",
            'password' => "kelompok13",
            'asal_sekolah' => "sekolah13",
            'foto_bukti_pembayaran' => ""
        ]);

        User::create([
            'name' => "kelompok13",
            'role' => 'peserta',
            'password' => bcrypt("kelompok13"),
        ]);

        Team::create([
            'nama_tim' => "kelompok14",
            'password' => "kelompok14",
            'asal_sekolah' => "sekolah14",
            'foto_bukti_pembayaran' => ""
        ]);

        User::create([
            'name' => "kelompok14",
            'role' => 'peserta',
            'password' => bcrypt("kelompok14"),
        ]);

        Team::create([
            'nama_tim' => "kelompok15",
            'password' => "kelompok15",
            'asal_sekolah' => "sekolah15",
            'foto_bukti_pembayaran' => ""
        ]);

        User::create([
            'name' => "kelompok15",
            'role' => 'peserta',
            'password' => bcrypt("kelompok15"),
        ]);

>>>>>>> Stashed changes
        User::create([
            'name' => "c",
            'role' => 'peserta',
            'password' => bcrypt(123),
        ]);

        User::create([
<<<<<<< Updated upstream
            'name' => "admin",
            'role' => 'admin',
            'password' => bcrypt("admin@ig33"),
=======
            'name' => "c",
            'role' => 'peserta',
            'password' => bcrypt(123),
>>>>>>> Stashed changes
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
