<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointsRedeemed extends Model
{
    use HasFactory;

    public function customers(){
        return $this->belongsTo(Customer::class);
    }

    public function pharmacy(){
        return $this->belongsTo(Pharmacy::class);
    }

    public function pointsAdded(){
        return $this->hasMany(PointsAdded::class);
    }
}
