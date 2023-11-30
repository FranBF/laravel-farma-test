<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\PointsAdded;
use Illuminate\Support\Facades\DB;

class PointsAddedTest extends TestCase
{
    public function test_add_points(){
        $p_add = PointsAdded::create([
            'customer_id' => 1,
            'pharmacy_id' => 2,
            'points' => 200,
            'day_added' => date('d-m-y h:i:s')
        ]);

        $this->assertTrue(true);
    }

    public function test_get_points_by_date(){
        $points = DB::table('points_added')->where('day_added', date('d/m/y'))->where('pharmacy_id', 1)->get();

        $this->assertTrue(true);
    }

    
}
