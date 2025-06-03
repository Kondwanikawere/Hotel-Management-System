<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookingRequests;
use App\Models\User;
use App\Models\CustomerVisits;
use App\Models\Rooms;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class BookingRequestsController extends Controller
{
    public function getAllBookingRequests(){
        return BookingRequests::with('customer')
                                ->where('status', NULL)
                                ->paginate(10);
    }

    public function acceptBookingRequest($bookingRequestId, $customerId){
        $customerDetails = User::where('users.id', $customerId)
                                ->get();
        $bookingRequest = BookingRequests::where('id', $bookingRequestId)
                                            ->first();
        $vacantRooms = Rooms::where('type', $bookingRequest->roomType)
                              ->where('status', 0)
                              ->get();
        return Inertia::render('BookingRequests/acceptBookingRequest', [
                                'customerDetails' => $customerDetails,
                                'bookingRequest' => $bookingRequest,
                                'vacantRooms' =>  $vacantRooms
        ]);
     }

     public function denyBookingRequests(Request $request){
        $request->merge([
            'bookingRequestId' => $request->bookingRequestId,
        ]);
        $validated = $request->validate([
            'bookingRequestId' => 'required|integer'
        ]);
        
        BookingRequests::where('Id', $validated['bookingRequestId'])->update([
            'status' => 0, 
            'updated_at' => now(),
        ]);

        $bookingRequests = BookingRequests::with('customer')
                                ->where('status', NULL)
                                ->paginate(10);
        return Inertia::render('BookingRequests/bookingRequests', [
                                'bookingRequests' => $bookingRequests,
        ]);
     }

     public function customerBookingRequests(){
        $user = Auth::user();
        $bookingRequest = BookingRequests::with('customerVisit')
                                        ->where('customerId',$user->id)
                                        ->orderBy('bookingrequests.created_at', 'desc')
                                        ->paginate(4);

        return Inertia::render('BookingRequests/customerBookingRequests', [
            'bookingRequests' => $bookingRequest
        ]);
     }

     public function SendRoomBookingRequest(Request $request){
        $validated = $request->validate([
            'checkIn' => 'required|date_format:Y-m-d H:i',
            'checkOut' => 'required|date_format:Y-m-d H:i',
            'roomType' => 'required|string',
        ]);
        $user = Auth::user();
      
        BookingRequests::create([
            'checkIn'   => $validated['checkIn'],
            'checkOut' => $validated['checkOut'],
            'roomType'  => $validated['roomType'],
            'created_at' =>  now(),
            'updated_at' =>  now(),
            'CustomerId' =>  $user->id,
        ]);

        return Inertia::location(route('customerBookingRequests'));  
     }

}

