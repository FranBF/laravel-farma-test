<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreCustomerRequest;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(int $customer)
    {
        $cust = Customer::find($customer);

        if(!$cust){
            return(json_encode([
                "Error" => "The ID provided has not been found. Please, try again"
            ]));
        }

        return $cust;
    }
}
