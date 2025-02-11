<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acceptance extends Model
{

    protected $fillable = ['phone', 'car_id'];

    public function car(){
        return $this -> belongsTo(Car::class);
    }
}
