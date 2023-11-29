<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UpdatePointsAddedRequest;
use App\Models\PointsAdded;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\PharmacyController;
use App\Http\Controllers\Api\PointsAddedController;
use App\Http\Controllers\Api\CustomerController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class PointsController extends Controller
{

    public function getPointsByDate(int $pharmacy_id, string $date){

        try{
            if(!is_int($pharmacy_id)){
                return json_encode([
                    "Error" => "Pharmacy ID can only be type int, " . gettype($pharmacy_id) . " given"
                ]);
            }
    
            if(!is_string($date)){
                return json_encode([
                    "Error" => "Date can only be type string, " . gettype($date) . " given"
                ]);
            }
    
    
            $valid_dates = ["today", "yesterday", "lastWeek", "lastMonth", "lastYear"];
    
            $is_valid = false;
    
            (array) $points = [];
            
    
            for($i = 0; $i < count($valid_dates); $i++){
    
                if($date === $valid_dates[$i]){
                    $is_valid = true;
                }else{}
                    
                /* return json_encode([
                    "Error" => "The date provided does not match our records. Please, insert one of the dates indicated in the API Documentation."
                ]); */
            }
    
            if($is_valid){
                switch($date){
                    case $valid_dates[0]:
                        $points = DB::table('points_added')->where('day_added', date('d/m/y'))->where('pharmacy_id', $pharmacy_id)->get();
                        break;
                    case $valid_dates[1]:
                        $points = DB::table('points_added')->where('day_added', date('d/m/y', strtotime('-1 days')))->where('pharmacy_id', $pharmacy_id)->get();
                        echo $this->sumPoints($points);
                        break;
                    case $valid_dates[2]:
                        $points = DB::table('points_added')->where('day_added', '<=', date('d/m/y', strtotime('-1 week')))->where('pharmacy_id', $pharmacy_id)->get();
                        echo $this->sumPoints($points);
                        break;
                    case $valid_dates[3]:
                        $points = DB::table('points_added')->where('day_added', '<=', date('d/m/y', strtotime('-1 month')))->where('pharmacy_id', $pharmacy_id)->get();
                        echo $this->sumPoints($points);
                        break;
                    case $valid_dates[4]:
                        $points = DB::table('points_added')->where('day_added', '<=', date('d/m/y', strtotime('-1 year')))->where('pharmacy_id', $pharmacy_id)->get();
                        echo $this->sumPoints($points);
                        break;
                }
            }
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    private function sumPoints(Collection $p){
        (int) $sum_points = 0;
        foreach ($p as $point){
            $sum_points += (int)$point->points;
        }
        return $sum_points;
    }

    public function getPharmPointsToClient(int $pharmacy_id, int $client_id){
        (array) $points = [];

        $points = DB::table('points_added')->where('customer_id', $client_id)->where('pharmacy_id', $pharmacy_id)->get();

        return json_encode([
            "sum" => $this->sumPoints($points),
            "object" => $points
        ]);

    }

    public function returnPharmPointsToClientToApi(int $pharmacy_id, int $client_id){
        $validator = new PointsAddedController;
        $validator->check($client_id, $pharmacy_id);
        $points = $this->getPharmPointsToClient($pharmacy_id, $client_id);
        return json_decode($points)->sum;
    }

    public function getAllClientPoints(int $client_id){
        $validator = new PointsAddedController;
        $validator->check($client_id, null);
        $points = DB::table('points_added')->where('customer_id', $client_id)->get();
        return $this->sumPoints($points);
    }

}