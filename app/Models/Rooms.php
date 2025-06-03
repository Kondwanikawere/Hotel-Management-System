<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Rooms extends Model
{
    protected $fillable = [
        'created_at',
        'updated_at',
        'customerId',
        'status',
        'type',
    ];

    protected $hidden = [
        'updated_at'
    ];

    public function customerVisits()
    {
        return $this->hasMany(CustomerVisits::class, 'roomId');
    }

    public function latestCustomerVisit()
            {
                return $this->hasOne(CustomerVisits::class, 'roomId')->latestOfMany('checkIn');
            }
    public function latestRoomVisit()
            {
                
            }
}
