<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PosSeeder extends Seeder
{
    public function run(): void
    {
        $singlePos = [3, 15, 17, 19, 21]; // daftar pos yang single

        for ($i = 1; $i <= 25; $i++) {
            DB::table('pos')->insert([
                'nama' => 'Pos ' . $i,
                'status' => 'kosong',
                'tipe' => in_array($i, $singlePos) ? 'single' : 'battle',
            ]);
        }
    }
}
