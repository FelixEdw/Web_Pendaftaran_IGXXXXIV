<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pos')->insert([
            [
            'nama' => 'Scramble', //1
            'status' => 'kosong',
            'tipe' => 'battle',
            ],
            [
            'nama' => 'Code 24', //2
            'status' => 'kosong',
            'tipe' => 'battle',
            ],
            [
            'nama' => 'Line Trap', //3
            'status' => 'kosong',
            'tipe' => 'single',
            ],
            [
            'nama' => 'Signal Override', //4
            'status' => 'kosong',
            'tipe' => 'battle',
            ],
            [
            'nama' => 'Blind Retrieval', //5
            'status' => 'kosong',
            'tipe' => 'battle',
            ],
            [
            'nama' => 'Tic Tac Think', //6
            'status' => 'kosong',
            'tipe' => 'battle',
            ],
            [
            'nama' => 'Mission Escape', //7
            'status' => 'kosong',
            'tipe' => 'battle',
            ],
            [
            'nama' => 'Flag Rush', //8
            'status' => 'kosong',
            'tipe' => 'battle',
            ],
            [
            'nama' => 'Command Trigger', //9
            'status' => 'kosong',
            'tipe' => 'battle',
            ],
            [
            'nama' => 'Ball Relay Rush', //10
            'status' => 'kosong',
            'tipe' => 'battle',
            ],
            [
            'nama' => 'Throw Zone', //11
            'status' => 'kosong',
            'tipe' => 'single',
            ],
            [
            'nama' => 'Quiz Blits', //12
            'status' => 'kosong',
            'tipe' => 'battle',
            ],
            [
            'nama' => 'Flip & Think', //13
            'status' => 'kosong',
            'tipe' => 'battle',
            ],
            [
            'nama' => 'Memory Minefield', //14
            'status' => 'kosong',
            'tipe' => 'single',
            ],
            [
            'nama' => 'Sketch Relay', //15
            'status' => 'kosong',
            'tipe' => 'single',
            ],
            [
            'nama' => 'Number Game, Open Up!', //16
            'status' => 'kosong',
            'tipe' => 'battle',
            ],
            [
            'nama' => 'Word Assembly Race', //17
            'status' => 'kosong',
            'tipe' => 'single',
            ],
            [
            'nama' => 'Rubber Pass', //18
            'status' => 'kosong',
            'tipe' => 'battle',
            ],
            [
            'nama' => 'Knowledge Bid', //19
            'status' => 'kosong',
            'tipe' => 'battle',
            ],
            [
            'nama' => 'Mystery Match', //20
            'status' => 'kosong',
            'tipe' => 'battle',
            ],
            [
            'nama' => 'Tower Tangle', //21
            'status' => 'kosong',
            'tipe' => 'battle',
            ],
            [
            'nama' => 'Connected Pipes', //22
            'status' => 'kosong',
            'tipe' => 'battle',
            ]
        ]);
    }
}
