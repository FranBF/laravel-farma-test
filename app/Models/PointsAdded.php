<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointsAdded extends Model
{
    use HasFactory;

    protected $table = 'points_added';
    protected $fillable = ['customer_id', 'pharmacy_id', 'points', 'day_added'];

    public function customers(){
        return $this->belongsTo(Customer::class);
    }

    public function pharmacy(){
        return $this->belongsTo(Pharmacy::class);
    }

    public function pointsRedeemed(){
        return $this->hasMany(PointsRedeemed::class);
    }
}
