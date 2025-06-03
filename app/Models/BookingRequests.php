<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class BookingRequests extends Model
{
    use HasFactory;
    protected $table = 'bookingRequests';

    protected $fillable = [
        'status',
        'CustomerId',
        'checkIn',
        'checkOut',
        'created_at',
        'updated_at',
        'roomType',
        'response'
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'CustomerId');
    }
    public function customerVisit()
    {
        return $this->hasOne(CustomerVisits::class, 'bookingRequestId', 'Id');
    }
}
