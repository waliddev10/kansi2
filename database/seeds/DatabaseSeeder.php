<?php

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
        $this->call(PositionsTableSeeder::class);
        $this->call(WorkunitsTableSeeder::class);
        $this->call(StatusAgendasTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
