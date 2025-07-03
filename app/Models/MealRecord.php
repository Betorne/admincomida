<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealRecord extends Model
{
        protected $fillable = [
            'worker_id',
            'service_type_id',
            'registered_at',
        ];
        protected $casts = [
    'registered_at' => 'datetime',
];
        public function worker()
        {
            return $this->belongsTo(Worker::class);
        }

        public function serviceType()
        {
            return $this->belongsTo(ServiceType::class);
        }
}
