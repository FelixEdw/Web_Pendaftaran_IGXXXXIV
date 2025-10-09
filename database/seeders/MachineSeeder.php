<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Machine;

class MachineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Machine::create([
            'name' => 'Cutting',
            'jenis' => '1',
            'harga_dasar' => 2500,
            'kapasitas_dasar' => 5,
            'base_time' => 5, // dalam menit
            "biaya_jual"=>1500,
            'biaya_maintenance' => 1000,
        ]);

        Machine::create([
            'name' => 'Welding',
            'jenis' => '2',
            'harga_dasar' => 3000,
            'kapasitas_dasar' => 7,
            'base_time' => 7, // dalam menit
            "biaya_jual"=>2000,
            'biaya_maintenance' => 1000,
        ]);

        Machine::create([
            'name' => 'Painting',
            'jenis' => '3',
            'harga_dasar' => 3250,
            'kapasitas_dasar' => 4,
            'base_time' => 6, // dalam menit
            "biaya_jual"=>2000,
            'biaya_maintenance' => 1000,
        ]);

        Machine::create([
            'name' => 'Assembly',
            'jenis' => '4',
            'harga_dasar' => 3500,
            'kapasitas_dasar' => 4,
            'base_time' => 7, // dalam menit
            "biaya_jual"=>2000,
            'biaya_maintenance' => 1000,
        ]);
Machine::create([
            'name' => 'Cutting',
            'jenis' => '1',
            'harga_dasar' => 2500,
            'kapasitas_dasar' => 5,
            'base_time' => 5, // dalam menit
            "biaya_jual"=>1500,
            'biaya_maintenance' => 1000,
        ]);

        Machine::create([
            'name' => 'Welding',
            'jenis' => '2',
            'harga_dasar' => 3000,
            'kapasitas_dasar' => 7,
            'base_time' => 7, // dalam menit
            "biaya_jual"=>2000,
            'biaya_maintenance' => 1000,
        ]);

        Machine::create([
            'name' => 'Painting',
            'jenis' => '3',
            'harga_dasar' => 3250,
            'kapasitas_dasar' => 4,
            'base_time' => 6, // dalam menit
            "biaya_jual"=>2000,
            'biaya_maintenance' => 1000,
        ]);

        Machine::create([
            'name' => 'Assembly',
            'jenis' => '4',
            'harga_dasar' => 3500,
            'kapasitas_dasar' => 4,
            'base_time' => 7, // dalam menit
            "biaya_jual"=>2000,
            'biaya_maintenance' => 1000,
        ]);Machine::create([
            'name' => 'Cutting',
            'jenis' => '1',
            'harga_dasar' => 2500,
            'kapasitas_dasar' => 5,
            'base_time' => 5, // dalam menit
            "biaya_jual"=>1500,
            'biaya_maintenance' => 1000,
        ]);

        Machine::create([
            'name' => 'Welding',
            'jenis' => '2',
            'harga_dasar' => 3000,
            'kapasitas_dasar' => 7,
            'base_time' => 7, // dalam menit
            "biaya_jual"=>2000,
            'biaya_maintenance' => 1000,
        ]);

        Machine::create([
            'name' => 'Painting',
            'jenis' => '3',
            'harga_dasar' => 3250,
            'kapasitas_dasar' => 4,
            'base_time' => 6, // dalam menit
            "biaya_jual"=>2000,
            'biaya_maintenance' => 1000,
        ]);

        Machine::create([
            'name' => 'Assembly',
            'jenis' => '4',
            'harga_dasar' => 3500,
            'kapasitas_dasar' => 4,
            'base_time' => 7, // dalam menit
            "biaya_jual"=>2000,
            'biaya_maintenance' => 1000,
        ]);
        
         Machine::create([
            'name' => 'Cutting',
            'jenis' => '1',
            'harga_dasar' => 2500,
            'kapasitas_dasar' => 5,
            'base_time' => 5, // dalam menit
            "biaya_jual"=>1500,
            'biaya_maintenance' => 1000,
        ]);

        Machine::create([
            'name' => 'Welding',
            'jenis' => '2',
            'harga_dasar' => 3000,
            'kapasitas_dasar' => 7,
            'base_time' => 7, // dalam menit
            "biaya_jual"=>2000,
            'biaya_maintenance' => 1000,
        ]);

        Machine::create([
            'name' => 'Painting',
            'jenis' => '3',
            'harga_dasar' => 3250,
            'kapasitas_dasar' => 4,
            'base_time' => 6, // dalam menit
            "biaya_jual"=>2000,
            'biaya_maintenance' => 1000,
        ]);

        Machine::create([
            'name' => 'Assembly',
            'jenis' => '4',
            'harga_dasar' => 3500,
            'kapasitas_dasar' => 4,
            'base_time' => 7, // dalam menit
            "biaya_jual"=>2000,
            'biaya_maintenance' => 1000,
        ]);
    }
}
