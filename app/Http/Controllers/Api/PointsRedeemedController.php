<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StorePointsRedeemedRequest;
use App\Http\Requests\UpdatePointsRedeemedRequest;
use App\Http\Controllers\Api\PointsController;
use App\Models\PointsRedeemed;
use App\Models\PointsAdded;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;


class PointsRedeemedController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(int $customer_id, int $pharm_id, int $pointsToRedeem)
    {
        $points = new PointsController;
        $currentDate = strtotime('now');
        $latestDate = [];
        (int) $tempRes = 0;

        $pointsRedeemedByCustomerInPharm = $this->getPointsRedeemedByCustomerInPharm($customer_id, $pharm_id);

        $totalPoints = $points->getPharmPointsToClient($pharm_id, $customer_id);

        $object = json_decode($totalPoints);
        $object = $object->object;
        
        if($pointsToRedeem > json_decode($totalPoints)->sum){
            return(json_encode([
                "Error" => "The user has not enough points to redeem in this pharmacy. please, try again"
            ]));
        }        
        

        for((int) $i=0; $i< count($object); $i++){
            $tempRes = $currentDate - (int)$object[$i]->created_at;
            if(!empty($latestDate)){
                if($tempRes > $latestDate->created_at ){
                    $latestDate = $object[$i];
                }
            }else{
                $latestDate = $object[$i];
            }
            
        }

        print_r($latestDate);
        die;
        

        $pr = PointsRedeemed::create([
            'customer_id'=>$latestDate->customer_id,
            'pharmacy_id' => $latestDate->pharmacy_id
        ]);

    }

    private function getPointsRedeemedByCustomerInPharm(int $c_id, int $p_id){
        $points_id = [];
        $points = DB::table('points_redeemed')->where('customer_id', $c_id)->where('pharmacy_id', $p_id)->get();

        for((int) $i = 0; $i<count($points); $i++){
            array_push($points_id, $points[$i]->id);
        }

        return $points_id;
    }

    
    
}
