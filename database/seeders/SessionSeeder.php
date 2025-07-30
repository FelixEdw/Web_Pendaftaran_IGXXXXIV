<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Session;

class SessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Session::create([
            'id' => 1,
            "jenis_sesi" => 1,
            'durasi' => 35,
            'demand' => 30,
            'event' => "",
        ]);

        Session::create([
            'id' => 2,
            "jenis_sesi" => 0,
            'durasi' => 35,
            'demand' => 50,
            'event' => "Total Hadih Point X 1.5",
        ]);

        Session::create([
            'id' => 3,
            "jenis_sesi" => 0,
            'durasi' => 35,
            'demand' => 35,
            'event' => "Harga Maintenance X 1.5",
        ]);

        Session::create([
            'id' => 4,
            "jenis_sesi" => 0,
            'durasi' => 35,
            'demand' => 70,
            'event' => "",
        ]);
    }
}
