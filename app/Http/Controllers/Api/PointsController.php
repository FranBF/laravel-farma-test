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
use Illuminate\Support\Facades\Validator;

class PointsController extends Controller
{

    public function getPointsByDate($pharmacy_id, $date){

        $dataToValidate = [
            'pharm_id' => $pharmacy_id,
            'date' => $date
        ];

        $validator2 = Validator::make($dataToValidate, [
            'pharm_id' => 'required|integer',
            'date' => 'required|string|max:255'
        ]);

        if($validator2->fails()){
            return json_encode([
                "Error" => "Something's wrong. Look if all of the parameters given are int"
            ]);
        }
    
            $valid_dates = ["today", "yesterday", "lastWeek", "lastMonth", "lastYear"];
    
            $is_valid = false;
    
            (array) $points = [];
            
    
            if(!in_array((string)$date, $valid_dates)){
                $is_valid = false;
                return(json_encode([
                    "Error" => "The date given is not valid. Please, check the documentation to see what dates are valid."
                ]));
            }else{
                $is_valid = true;
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

    public function returnPharmPointsToClientToApi($pharmacy_id, $client_id){

        $dataToValidate = [
            'pharm_id' => $pharmacy_id,
            'client_id' => $client_id,
        ];

        $validator2 = Validator::make($dataToValidate, [
            'pharm_id' => 'required|integer',
            'client_id' => 'required|integer'
        ]);

        if($validator2->fails()){
            return json_encode([
                "Error" => "Something's wrong. Look if all of the parameters given are int"
            ]);
        }

        $validator = new PointsAddedController;
        $validator->check($client_id, $pharmacy_id);
        $points = $this->getPharmPointsToClient($pharmacy_id, $client_id);
        return json_decode($points)->sum;
    }

    public function getAllClientPoints($client_id){
        $dataToValidate = [
            'client_id' => $client_id,
        ];

        $validator2 = Validator::make($dataToValidate, [
            'client_id' => 'required|integer'
        ]);

        if($validator2->fails()){
            return json_encode([
                "Error" => "Something's wrong. Look if all of the parameters given are int"
            ]);
        }

        $validator = new PointsAddedController;
        $validator->check($client_id, null);
        $points = DB::table('points_added')->where('customer_id', $client_id)->get();
        return $this->sumPoints($points);
    }

}