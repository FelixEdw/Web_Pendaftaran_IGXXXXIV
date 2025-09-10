<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PosSeeder extends Seeder
{
    public function run(): void
    {
        $singlePos = [3, 15, 17, 19, 21]; // daftar pos yang single

        DB::table('pos')->insert([
            [
            'nama' => 'Scramble',
            'status' => 'kosong',
            'tipe' => 'battle',
            ],
            [
            'nama' => 'Code 24',
            'status' => 'kosong',
            'tipe' => 'battle',
            ],
            [
            'nama' => 'Line Trap',
            'status' => 'kosong',
            'tipe' => 'single',
            ],
            [
            'nama' => 'Signal Override',
            'status' => 'kosong',
            'tipe' => 'battle',
            ],
            [
            'nama' => 'Blind Retrieval',
            'status' => 'kosong',
            'tipe' => 'battle',
            ],
            [
            'nama' => 'Tic Tac Think',
            'status' => 'kosong',
            'tipe' => 'battle',
            ],
            [
            'nama' => 'Mission Escape',
            'status' => 'kosong',
            'tipe' => 'battle',
            ],
            [
            'nama' => 'Flag Rush',
            'status' => 'kosong',
            'tipe' => 'battle',
            ],
            [
            'nama' => 'Command Trigger',
            'status' => 'kosong',
            'tipe' => 'battle',
            ],
            [
            'nama' => 'Ball Relay Rush',
            'status' => 'kosong',
            'tipe' => 'battle',
            ],
            [
            'nama' => 'Throw Zone',
            'status' => 'kosong',
            'tipe' => 'battle',
            ],
            [
            'nama' => 'Quiz Blits',
            'status' => 'kosong',
            'tipe' => 'battle',
            ],
            [
            'nama' => 'Bottle Brain Battle',
            'status' => 'kosong',
            'tipe' => 'battle',
            ],
            [
            'nama' => 'Memory Minefield',
            'status' => 'kosong',
            'tipe' => 'single',
            ],
            [
            'nama' => 'Sketch Relay',
            'status' => 'kosong',
            'tipe' => 'single',
            ],
            [
            'nama' => 'Its Number Game, Open Up!',
            'status' => 'kosong',
            'tipe' => 'battle',
            ],
            [
            'nama' => 'Word Assembly',
            'status' => 'kosong',
            'tipe' => 'single',
            ],
            [
            'nama' => 'Rubber Pass',
            'status' => 'kosong',
            'tipe' => 'single',
            ],
            [
            'nama' => 'Knowledge Bid',
            'status' => 'kosong',
            'tipe' => 'battle',
            ],
            [
            'nama' => 'Mystery Match',
            'status' => 'kosong',
            'tipe' => 'battle',
            ],
            [
            'nama' => 'Tower Tangle',
            'status' => 'kosong',
            'tipe' => 'battle',
            ],
            [
            'nama' => 'Connected Pipes',
            'status' => 'kosong',
            'tipe' => 'battle',
            ]
        ]);
    }
}
