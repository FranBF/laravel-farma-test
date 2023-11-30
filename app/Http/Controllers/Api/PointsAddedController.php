<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StorePointsAddedRequest;
use App\Http\Requests\UpdatePointsAddedRequest;
use App\Models\PointsAdded;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\PharmacyController;
use App\Http\Controllers\Api\CustomerController;
use Illuminate\Support\Facades\Validator;

class PointsAddedController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $pharm_id, $client_id, $points)
    {
        $dataToValidate = [
            'pharm_id' => $pharm_id,
            'client_id' => $client_id,
            'points' => $points
        ];

        $validator = Validator::make($dataToValidate, [
            'pharm_id' => 'required|integer',
            'client_id' => 'required|integer',
            'points' => 'required|integer'
        ]);

        if($validator->fails()){
            return json_encode([
                "Error" => "Something's wrong. Look if all of the parameters given are int"
            ]);
        }

        $this->check($client_id, $pharm_id);

        $pa = PointsAdded::create([
            'customer_id' => $client_id,
            'pharmacy_id' => $pharm_id,
            'points' => $points,
            'day_added' => date('d-m-y h:i:s')
        ]);

        echo(json_encode([
            'pharm_id' => $pharm_id,
            'client_id' => $client_id,
            'points' => $points
        ]));
    }

    public function check(?int $client_id, ?int $pharm_id){
        if($pharm_id !== null){
            $pharm = new PharmacyController;
            $p_exists = $pharm->show($pharm_id);
            if(array_key_exists("Error", (array)json_decode($p_exists))){
                echo(json_decode($p_exists)->Error);
                die;
            }
        }

        if($client_id !== null){
            $customer = new CustomerController;
            $c_exists = $customer->show($client_id);
            if(array_key_exists("Error", (array)json_decode($c_exists))){
                echo(json_decode($c_exists)->Error);
                die;
            }
        }
    }

}
