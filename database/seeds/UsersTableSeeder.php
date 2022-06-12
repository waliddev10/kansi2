<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return User::insert([
            [
                'name' => 'Locals Admin',
                'nip' => '0000000000000000',
                'email' => 'admin@gmail.com',
                'color' => 'FF0000',
                'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'password' => Hash::make('admin'),
                'handphone' => '085172277277',
                'role' => 'admin',
                'workunit_id' => 1,
                'position_id' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);
    }
}
