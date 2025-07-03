<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    protected $fillable = [
    'name', 'start_time', 'end_time', 'active', 'auto_activate'
];

    public function mealRecords() {
    return $this->hasMany(MealRecord::class);
    }
}
