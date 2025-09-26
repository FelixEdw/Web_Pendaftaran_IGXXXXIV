<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

      //  User::factory()->create([
      //      'name' => 'Test User',
      //      'email' => 'test@example.com',
       // ]);

       $this->call([
            SessionSeeder::class,
            MachineSeeder::class,
            SoalQrSeeder::class,
            MysteryEnvelopeSeeder::class,
            AccSeeder::class,
            KomponenSeeder::class,
            PosSeeder::class,
            PosStokSeeder::class,
            SesiRally1Seeder::class,
    ]);
    }
}
