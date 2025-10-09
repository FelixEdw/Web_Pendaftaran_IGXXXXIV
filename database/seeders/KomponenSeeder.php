<?php

namespace Database\Seeders;

use App\Models\Komponen;
use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KomponenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        /*$teams = Team::all();

        foreach ($teams as $team) {
            Komponen::create([
                'team_id' => $team->id,
                'wheel' => rand(2, 4),
                'brake_and_pedal' => rand(2, 4),
                'chain_and_gear' => rand(2, 4),
                'city_frame' => rand(0, 1),
                'folding_frame' => rand(0, 1),
                'mountain_frame' => rand(0, 1),
                'unicycle_frame' => rand(0, 1),
            ]);
            DB::table('sepeda')->insert([
            'team_id' => $team->id,
            'city' => 1
        ]);
        DB::table('poin_babak1')->insert([
            'sepeda_komponen_peserta_namaTim1' => $team->id,
            'poin' => 100,
            'sesi' => 1
        ]);
        
        }*/
    }
}
