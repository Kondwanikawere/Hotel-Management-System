<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\CustomerVisits;
use App\Models\Rooms;
use App\Models\BookingRequests;


class CustomerVisitsController extends Controller
{
    public function createCustomerVisit(Request $request){
        $validated = $request->validate([
            'checkIn' => 'required|date_format:Y-m-d H:i',
            'checkOut' => 'required|date_format:Y-m-d H:i',
            'roomId' => 'required|string',
            'customerId' => 'required|string',
            'bookingRequestId' => 'required|string'
        ]);

        CustomerVisits::create([
            'checkIn'   => $validated['checkIn'],
            'checkOut' => $validated['checkOut'],
            'roomId'  => $validated['roomId'],
            'customerId'  => $validated['customerId'],
            'bookingRequestId' =>  $validated['bookingRequestId'],
        ]);
        Rooms::where('id', $validated['roomId'])->update([
            'status' => 1,
            'updated_at' => now() 
        ]);
        User::where('id', $validated['customerId'])->update([
            'updated_at' => now() 
        ]);
        BookingRequests::where('Id', $validated['bookingRequestId'])->update([
            'status' => 1, 
            'updated_at' => now(),
        ]);

        $bookingRequests = BookingRequests::with('customer')
                                ->where('status', NULL)
                                ->paginate(10);
        return Inertia::render('BookingRequests/bookingRequests', [
                                'bookingRequests' => $bookingRequests,
        ]);

    }
}
