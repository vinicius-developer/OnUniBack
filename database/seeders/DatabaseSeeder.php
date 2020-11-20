<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CausasSociaisTableSeeder::class);
        $this->call(LojasTableSeeder::class);
        $this->call(GenerosSeeder::class);
        $this->call(UfSeeder::class);
    }
}
