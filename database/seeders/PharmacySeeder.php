<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PharmacySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pharmacies')->insert([
            'name'=>'Pharmacy1'
        ]);

        DB::table('pharmacies')->insert([
            'name'=>'Pharmacy2'
        ]);

        DB::table('pharmacies')->insert([
            'name'=>'Pharmacy3'
        ]);

        DB::table('pharmacies')->insert([
            'name'=>'Pharmacy4'
        ]);
    }
}
