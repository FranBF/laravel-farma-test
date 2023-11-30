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
    /* public function store(int $customer_id, int $pharm_id, int $pointsToRedeem)
    {
        
        $position = 1;

        
        $points_redeemed_by_client = $this->getPointsRedeemedByCustomerInPharm($customer_id, $pharm_id);
        
        $client_points = ($this->getPointsAddedByCustomerInPharm($customer_id, $pharm_id, $position));
        

        if(count($points_redeemed_by_client) === 0){
            
            if($client_points[0]->points > $pointsToRedeem){
                $newRecord = PointsRedeemed::create([
                    'customer_id' => $customer_id,
                    'pharmacy_id' => $pharm_id,
                    'points_added_id' => $client_points[$position - 1]->id,
                    'points' => $pointsToRedeem,
                    'day_redeemed' => $client_points[$position - 1]->created_at
                ]);

                if($newRecord){
                    return($newRecord);
                }else{
                    return(json_encode([
                        "Error" => "Something's been wrong. Please, try again"
                    ]));
                }
            }
        }
        
        $ids = $this->addIdsRedeemedToArray();
        $equals = [];

        for((int)$c = 0; $c < count($client_points); $c++){
            for((int)$z = 0; $z<count($points_redeemed_by_client); $z++){
                if($client_points[$c]->id === $points_redeemed_by_client[$z]->points_added_id){
                    array_push($client_points[$c], $equals);
                }
            }
        }

        print_r($equals);
        die;

        
        for((int)$y = 0; $y < count($client_points); $y++){


           
            if(in_array($client_points[$y]->id, $ids)){
                
                for((int)$x = 0; $x<count($points_redeemed_by_client); $x++){

                    
                    
                    
                    if($client_points[$y]->points === $points_redeemed_by_client[$x]->points){
                        
                        $position++;
                        $client_points = ($this->getPointsAddedByCustomerInPharm($customer_id, $pharm_id, $position));

                        if(in_array($client_points[$position - 1]->id, $ids)){
                            
                            if($pointsToRedeem > $client_points[$position-1]->points){
                                $diff = $pointsToRedeem - $client_points[$position - 1]->points;
                                $newRecord = PointsRedeemed::create([
                                    'customer_id' => $customer_id,
                                    'pharmacy_id' => $pharm_id,
                                    'points_added_id' => $client_points[$position - 1]->id,
                                    'points' => $diff,
                                    'day_redeemed' => $client_points[$position - 1]->created_at
                                ]);
                
                                $position++;
                                $client_points = ($this->getPointsAddedByCustomerInPharm($customer_id, $pharm_id, $position));
                            }else{
                                $diff = $client_points[$position - 1]->points - $pointsToRedeem;
                                $newRecord = PointsRedeemed::create([
                                    'customer_id' => $customer_id,
                                    'pharmacy_id' => $pharm_id,
                                    'points_added_id' => $client_points[$position - 1]->id,
                                    'points' => $diff,
                                    'day_redeemed' => $client_points[$position - 1]->created_at
                                ]);
                                if($newRecord){
                                    return($newRecord);
                                }else{
                                    return(json_encode([
                                        "Error" => "Something's been wrong. Please, try again"
                                    ]));
                                }
                            }
                        }
                        if(isset($client_points[$position - 1])){
                            
                            if($client_points[$position - 1]->points > $pointsToRedeem || $client_points[$position - 1]->points === $pointsToRedeem){
                                $newRecord = PointsRedeemed::create([
                                    'customer_id' => $customer_id,
                                    'pharmacy_id' => $pharm_id,
                                    'points_added_id' => $client_points[$position - 1]->id,
                                    'points' => $pointsToRedeem,
                                    'day_redeemed' => $client_points[$position - 1]->created_at
                                ]);
                
                                if($newRecord){
                                    return($newRecord);
                                }else{
                                    return(json_encode([
                                        "Error" => "Something's been wrong. Please, try again"
                                    ]));
                                }
                            }else{
                                $diff = $pointsToRedeem - $client_points[0]->points;
                                $newRecord = PointsRedeemed::create([
                                    'customer_id' => $customer_id,
                                    'pharmacy_id' => $pharm_id,
                                    'points_added_id' => $client_points[$position - 1]->id,
                                    'points' => $diff,
                                    'day_redeemed' => $client_points[$position - 1]->created_at
                                ]);
                
                                $position++;
                                $client_points = ($this->getPointsAddedByCustomerInPharm($customer_id, $pharm_id, $position));
                            }
                        }else{
                        }
                        
                    }else{
                        $minus = $client_points[$position-1]->points - $pointsToRedeem;
                        
                        if($pointsToRedeem > $minus){
                            
                            $newRecord = PointsRedeemed::create([
                                'customer_id' => $customer_id,
                                'pharmacy_id' => $pharm_id,
                                'points_added_id' => $client_points[$position - 1]->id,
                                'points' => $minus,
                                'day_redeemed' => $client_points[$position - 1]->created_at
                            ]);
                            
                            $pointsToRedeem = $pointsToRedeem - $minus;                            
                            $position++;
                            $client_points = ($this->getPointsAddedByCustomerInPharm($customer_id, $pharm_id, $position));
                            
                        }else{
                            
                            $diff = $client_points[$position - 1]->points - $pointsToRedeem;
                            
                            $newRecord = PointsRedeemed::create([
                                'customer_id' => $customer_id,
                                'pharmacy_id' => $pharm_id,
                                'points_added_id' => $client_points[$position - 1]->id,
                                'points' => $diff,
                                'day_redeemed' => $client_points[$position - 1]->created_at
                            ]);
                            if($newRecord){
                                return($newRecord);
                            }else{
                                return(json_encode([
                                    "Error" => "Something's been wrong. Please, try again"
                                ]));
                            }
                        }
                    }
                    
                }
        }else{
            
                            
        }
        if($pointsToRedeem > $client_points[$position-1]->points){
            $diff = $pointsToRedeem - $client_points[$position - 1]->points;
            $newRecord = PointsRedeemed::create([
                'customer_id' => $customer_id,
                'pharmacy_id' => $pharm_id,
                'points_added_id' => $client_points[$position - 1]->id,
                'points' => $diff,
                'day_redeemed' => $client_points[$position - 1]->created_at
            ]);

            $position++;
            $client_points = ($this->getPointsAddedByCustomerInPharm($customer_id, $pharm_id, $position));
        }else{
            $diff = $client_points[$position - 1]->points - $pointsToRedeem;
            $newRecord = PointsRedeemed::create([
                'customer_id' => $customer_id,
                'pharmacy_id' => $pharm_id,
                'points_added_id' => $client_points[$position - 1]->id,
                'points' => $diff,
                'day_redeemed' => $client_points[$position - 1]->created_at
            ]);
            if($newRecord){
                return($newRecord);
            }else{
                return(json_encode([
                    "Error" => "Something's been wrong. Please, try again"
                ]));
            }
            die;
        }
            if($client_points[0]->points === 3){}
        }
    } */

    private function addIdsRedeemedToArray(){
        $pr = DB::table('points_redeemeds')->get();
        $arr = [];

        for((int)$i = 0; $i<count($pr); $i++){
            array_push($arr, $pr[$i]->points_added_id);
        }

        return $arr;
    }

    private function getPointsAddedByCustomerInPharm(int $c_id, int $p_id, int $position){
        $points = DB::table('points_added')->where('customer_id', $c_id)->where('pharmacy_id', $p_id)->take($position)->get();

        if(empty($points)){
            return(json_encode([
                "Error" => "The record you are trying to access does not exist"
            ]));
        }

        return $points;
    }

    private function getPointsRedeemedByCustomerInPharm(int $c_id, int $p_id){
        $points = DB::table('points_redeemeds')->where('customer_id', $c_id)->where('pharmacy_id', $p_id)->get();

        return $points;
    }
    
}
