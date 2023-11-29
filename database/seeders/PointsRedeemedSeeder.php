<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PointsRedeemedSeeder extends Seeder
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
    }
}
