<?php

use App\Workunit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class WorkunitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            [
                'name' => 'KPPN PURWODADI',
                'baes1' => '12345',
                'code' => '648812',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
        ];
        Workunit::insert($data);
    }
}
