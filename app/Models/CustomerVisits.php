<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Sequence;



class CustomerVisits extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'customervisits';

    protected $fillable = [
        'checkIn',
        'checkOut',
        'customerId',
        'roomId',
        'bookingRequestId',
        'status'
    ];

    public function bookingRequest()
    {
        return $this->belongsTo(BookingRequests::class, 'bookingRequestId');
    }
    public function room()
    {
        return $this->belongsTo(Rooms::class, 'roomId');
    }
}
