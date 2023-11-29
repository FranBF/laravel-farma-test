<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StorePharmacyRequest;
use App\Http\Requests\UpdatePharmacyRequest;
use App\Models\Pharmacy;
use App\Http\Controllers\Controller;

class PharmacyController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(int $pharmacy)
    {
        $pharm = Pharmacy::find($pharmacy);

        if(!$pharm){
            return(json_encode([
                "Error" => "The ID passed has not been found"
            ]));
        }

        return $pharm;
    }
}
