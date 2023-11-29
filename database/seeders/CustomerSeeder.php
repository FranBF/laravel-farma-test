<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('customers')->insert([
            'name' => 'Customer1'
        ]);

        DB::table('customers')->insert([
            'name' => 'Customer2'
        ]);

        DB::table('customers')->insert([
            'name' => 'Customer3'
        ]);

        DB::table('customers')->insert([
            'name' => 'Customer4'
        ]);
    }
}
