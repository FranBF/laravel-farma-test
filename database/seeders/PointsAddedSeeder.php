<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PointsAddedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('points_added')->insert([
            'customer_id'=>1,
            'pharmacy_id'=>2,
            'points'=> 500,
            'day_added'=> date("d/m/y H:i:s")
        ]);

        DB::table('points_added')->insert([
            'customer_id'=>2,
            'pharmacy_id'=>3,
            'points'=> 500,
            'day_added'=> date("d/m/y H:i:s")
        ]);
        DB::table('points_added')->insert([
            'customer_id'=>3,
            'pharmacy_id'=>1,
            'points'=> 100,
            'day_added'=> date("d/m/y H:i:s")
        ]);
        DB::table('points_added')->insert([
            'customer_id'=>4,
            'pharmacy_id'=>4,
            'points'=> 700,
            'day_added'=> date("d/m/y H:i:s")
        ]);
    }
}
