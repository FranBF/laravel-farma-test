<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    use HasFactory;

    public function pointsAdded(){
        return $this->hasMany(PointsAdded::class);
    }

    public function pointsRedeemed(){
        return $this->hasMany(PointsRedeemed::class);
    }
}
