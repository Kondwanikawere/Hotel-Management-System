<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CustomerVisitsController;
use App\Http\Controllers\BookingRequestsController;
use App\Models\BookingRequests;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CustomerMiddleware;
use App\Models\User;

Route::aliasMiddleware('admin', AdminMiddleware::class);
Route::aliasMiddleware('customer', CustomerMiddleware::class);

route::middleware([])->group(function(){
    Route::inertia('/', 'welcome')->name('welcome');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

route::middleware(['auth', 'admin'])->group(function(){
    //Rooms
    Route::get('/rooms', function (){
        return inertia('dashboard');
    })->name('home');
    Route::get('/rooms', function(Request $request){
        return inertia('Rooms/allRooms', ['rooms' => (new RoomsController)->getRooms($request),
                                          'searchTerm' => $request->search,
                                          'FilterSelection' => $request->all()
                                         ]
                      );
    })->name('allRooms');
    Route::get('/bookedRooms', function(Request $request){
        return inertia('Rooms/bookedRooms', ['rooms' => (new RoomsController)->getBookedRooms($request),
                                          'searchTerm' => $request->search,
                                          'FilterSelection' => $request->all()
                                         ]
                      );
    })->name('bookedRooms');
    Route::get('/vacantRooms', function(Request $request){
        return inertia('Rooms/vacantRooms', ['rooms' => (new RoomsController)->getVacantRooms($request),
                                          'searchTerm' => $request->search,
                                          'FilterSelection' => $request->all()
                                         ]
                      );
    })->name('vacantRooms');
    Route::get('/deactivateCustomerVisit/{roomId}/{customerId}/{customerVisitId}', [RoomsController::class, 'deactivateCustomerVisit'])->name('deactivateCustomerVisit');

    //Customers
    Route::get('/allCustomers', function(Request $request){
        return inertia('Customers/allCustomers', ['customers' => (new UsersController)->getAllCustomers($request),
                                                    'searchTerm' => $request->search,
                                                 ]
                      );
    })->name('allCustomers');
    Route::get('/newCustomers', function(Request $request){
        return inertia('Customers/allCustomers', ['customers' => (new UsersController)->getAllCustomers($request),
                                                    'searchTerm' => $request->search,
                                                 ]
                      );
    })->name('newCustomers');
    Route::get('/customerDetails/{id}', [UsersController::class, 'showCustomerDetails'])->name('customerDetails');

    //Booking requests
    Route::get('/bookingRequests', function(){
        return inertia('BookingRequests/bookingRequests', ['bookingRequests' => (new BookingRequestsController)->getAllBookingRequests()]);
    })->name('bookingRequests');
    Route::get('/acceptBookingRequest/{bookingRequestId}/{customerId}', [BookingRequestsController::class, 'acceptBookingRequest'])->name('acceptBookingRequest');
    Route::get('/acceptBookingRequest', [CustomerVisitsController::class, 'createCustomerVisit'])->name('createCustomerVisit');
    Route::get('/denyBookingRequest/{bookingRequestId}', [BookingRequestsController::class, 'denyBookingRequests'])->name('denyBookingRequests');
    
    Route::get('/editAdminProfile', [UsersController::class, 'editAdminProfile'])->name('editAdminProfile'); 
    Route::get('/updateAdminProfile', [UsersController::class, 'updateAdminProfile'])->name('updateAdminProfile');
    Route::get('/editCustomerProfile/{customerId}', [UsersController::class, 'editCustomerProfile'])->name('editCustomerProfile');
    Route::get('/updateCustomerProfile', [UsersController::class, 'updateCustomerProfile'])->name('updateCustomerProfile');
    
   
    Route::get('/trending', function () {
        return inertia('trending');
    })->name('trending');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::inertia('/downloads', 'downloads')->name('downloads');
    Route::inertia('/favorites', 'favorites')->name('favorites');
    Route::inertia('/search', 'search')->name('search');
    Route::inertia('/profile', 'profile')->name('profile');
    
});


//customer requests
route::middleware(['auth', 'customer'])->group(function(){
    Route::get('/myDetails', [UsersController::class, 'customerDashboard'])->name('customerDashboard');
    Route::get('/roomBooking', [BookingRequestsController::class, 'customerBookingRequests'])->name('customerBookingRequests');
    Route::get('/sendingRequest', [BookingRequestsController::class, 'SendRoomBookingRequest'])->name('SendRoomBookingRequest');
    Route::get('/editProfile', [UsersController::class, 'editMyProfile'])->name('editMyProfile');  
    Route::get('/updateProfile', [UsersController::class, 'updateMyprofile'])->name('updateProfile');  
});


route::middleware('guest')->group(function(){
    Route::get('/login', function () {
        return inertia::render('Auth/signIn');
    })->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::inertia('/register', 'Auth/register')->name('register');
    Route::post('/register', [AuthController::class, 'store']);

});
