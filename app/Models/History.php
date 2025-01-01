<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $fillable = ['vehicle_id', 'booking_id', 'start_date', 'end_date', 'fuel_consumption'];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

}
