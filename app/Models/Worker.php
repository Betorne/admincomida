<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    protected $fillable = [
    'name', 'rut', 'email', 'address', 'phone', 'company_id'
];
    public function company() {
    return $this->belongsTo(Company::class);
    }

    public function mealRecords() {
        return $this->hasMany(MealRecord::class);
    }
}
