<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use App\Models\Rooms;
use App\Models\User;
use App\Models\CustomerVisits;
use Illuminate\Http\Request;

class RoomsController extends Controller
{
   public function getRooms(Request $request){
      
         return Rooms::with('latestCustomerVisit')
                        ->when($request->search, function($query) use ($request){
                           $query->where('Rooms.id', 'like', '%'.$request->search.'%');
                        })
                        ->when($request->filled('twin'), function ($q) use ($request) {
                           $q->where('Rooms.type', 'like', $request->twin);
                        })
                        ->when($request->filled('single'), function ($q) use ($request) {
                              $q->orWhere('Rooms.type', 'like', $request->single);
                        })
                        ->when($request->filled('bridal'), function ($q) use ($request) {
                              $q->orWhere('Rooms.type', 'like', $request->bridal);
                        })
                        ->when($request->filled('family'), function ($q) use ($request) {
                              $q->orWhere('Rooms.type', 'like', $request->family);
                        })
                        ->when($request->filled('executive'), function ($q) use ($request) {
                              $q->orWhere('Rooms.type', 'like', $request->executive);
                        })
                        ->paginate(10)
                        ->appends(request()->query()); 
    
   }

   public function getBookedRooms(Request $request){
      return Rooms::with('latestCustomerVisit')
                        ->when($request->search, function($query) use ($request){
                           $query->orWhere('Rooms.id', 'like', '%'.$request->search.'%')
                              ->where('status', 1);
                        })
                        ->when($request->filled('twin'), function ($q) use ($request) {
                           $q->orWhere('Rooms.type', 'like', $request->twin)
                              ->where('status', 1);
                        })
                        ->when($request->filled('single'), function ($q) use ($request) {
                              $q->orWhere('Rooms.type', 'like', $request->single)
                                 ->where('status', 1);
                        })
                        ->when($request->filled('bridal'), function ($q) use ($request) {
                              $q->orWhere('Rooms.type', 'like', $request->bridal)
                                 ->where('status', 1);
                        })
                        ->when($request->filled('family'), function ($q) use ($request) {
                              $q->orWhere('Rooms.type', 'like', $request->family)
                                 ->where('status', 1);
                        })
                        ->when($request->filled('executive'), function ($q) use ($request) {
                              $q->orWhere('Rooms.type', 'like', $request->executive)
                                 ->where('status', 1);
                        })
                        ->where('status', 1)
                        ->paginate(7)
                        ->appends(request()->query()); 
   }

   public function getVacantRooms(Request $request){
      return Rooms::with('latestCustomerVisit')
                        ->when($request->search, function($query) use ($request){
                           $query->orWhere('Rooms.id', 'like', '%'.$request->search.'%')
                              ->where('status', 0);
                        })
                        ->when($request->filled('twin'), function ($q) use ($request) {
                           $q->orWhere('Rooms.type', 'like', $request->twin)
                              ->where('status', 0);
                        })
                        ->when($request->filled('single'), function ($q) use ($request) {
                              $q->orWhere('Rooms.type', 'like', $request->single)
                                 ->where('status', 0);
                        })
                        ->when($request->filled('bridal'), function ($q) use ($request) {
                              $q->orWhere('Rooms.type', 'like', $request->bridal)
                                 ->where('status', 0);
                        })
                        ->when($request->filled('family'), function ($q) use ($request) {
                              $q->orWhere('Rooms.type', 'like', $request->family)
                                 ->where('status', 0);
                        })
                        ->when($request->filled('executive'), function ($q) use ($request) {
                              $q->orWhere('Rooms.type', 'like', $request->executive)
                                 ->where('status', 0);
                        })
                        ->where('status', 0)
                        ->paginate(10)
                        ->appends(request()->query());               
   }

   public function filterRooms(Request $request){
      $rooms = Rooms::with('latestCustomerVisit')
                     ->when($request->search, function($query) use ($request){
                           $query->where('Rooms.type', 'like', $request->twin)
                                 ->orWhere('Rooms.type', 'like', $request->single)
                                 ->orWhere('Rooms.type', 'like', $request->bridal)
                                 ->orWhere('Rooms.type', 'like', $request->family)
                                 ->orWhere('Rooms.type', 'like', $request->executive);
                        })
                     ->paginate(10)
                     ->appends(request()->query()); 

      return Inertia::render('Rooms/allRooms', [
         'rooms' => $rooms,
         'filters' => $request->only(['search', 'twin', 'single', 'bridal', 'family', 'executive'])
      ]);
   }

   public function deactivateCustomerVisit(Request $request){
      $request->merge([
         'roomId' => $request->roomId,
         'customerId' =>$request->customerId,
         'customerVisitId' => $request->customerVisitId
     ]);
     $validated = $request->validate([
         'roomId' => 'required|integer',
         'customerId' => 'required|integer',
         'customerVisitId' => 'required|integer',
     ]);
     
     Rooms::where('id', $validated['roomId'])->update([
         'status' => 0, 
         'updated_at' => now(),
     ]);

     CustomerVisits::where('id', $validated['customerVisitId'])->update([
      'status' => 0, 
     ]);

     $customerDetails = User::where('users.id', $validated['customerId'])
                                ->get();
     $customerVisits = CustomerVisits::with('room')
                                    ->where('customerId', $validated['customerId'])
                                    ->orderBy('checkOut', 'Desc')
                                    ->paginate(4);
     return Inertia::render('Customers/customerDetails', [
      'customerDetails' => $customerDetails,
      'customerVisits' => $customerVisits
     ]);
   }

}
