<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CustomerVisits;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function getAllCustomers(Request $request){
        return User::where('role', 1)
                        ->when($request->search, function($query) use ($request){
                            $query->where('id', 'like', '%'.$request->search.'%')
                                ->orWhere('firstName', 'like', '%'.$request->search.'%')
                                ->orWhere('username', 'like', '%'.$request->search.'%')
                                ->orWhere('surname', 'like', '%'.$request->search.'%')
                                ->orWhere('email', 'like', '%'.$request->search.'%');
                        })
                        ->paginate(7)
                        ->appends(request()->query());
    }

    public function showCustomerDetails($id){
        $customerDetails = User::where('users.id', $id)
                                ->get();
        $customerVisits = CustomerVisits::with('room')
                                        ->where('customerId', $id)
                                        ->orderBy('customervisits.checkOut', 'Desc')
                                        ->paginate(5);
        return Inertia::render('Customers/customerDetails', [
            'customerDetails' => $customerDetails,
            'customerVisits' => $customerVisits
        ]);
    }

    public function customerDashboard(){
        $user = Auth::user();
        $customerDetails = collect($user)->only('id', 'firstName', 'surname', 'username', 'email', 'created_at');
        $customerVisits = CustomerVisits::with('room')
                                        ->where('customerId', $customerDetails['id'])
                                        ->orderBy('checkOut', 'Desc')
                                        ->paginate(5);
        return Inertia::render('Customers/customerDashboard', [
            'customerDetails' => $customerDetails,
            'customerVisits' => $customerVisits
        ]);
    }

    
    public function editMyProfile(){
        $user = Auth::user();
        $customerDetails = collect($user)->only('id', 'firstName', 'surname', 'username', 'email');

        return Inertia::render('Customers/editProfile', [
            'user' => $customerDetails,
        ]);
     }

     public function updateMyprofile(Request $request)
    {
        sleep(1);
        
        if($request->password){
            $fields = $request->validate([
                'firstName' => ['required', 'max:255'],
                'surname' => ['required', 'max:255'],
                'username' => ['required', 'max:255'],
                'email' => ['required', 'email', 'max:255'],
                'password' => ['required', 'max:255']
            ]);
           
            $user = Auth::user();

            User::where('id', $user->id)->update([
                'firstName' => $fields['firstName'],
                'surname' => $fields['surname'],
                'username' => $fields['username'],
                'email' => $fields['email'],
                'password' => Hash::make($fields['password']),
                'updated_at' => now()
            ]);
        } else{
            
            $fields = $request->validate([
                'firstName' => ['required', 'max:255'],
                'surname' => ['required', 'max:255'],
                'username' => ['required', 'max:255'],
                'email' => ['required', 'email', 'max:255'],
            ]);

            $user = Auth::user();

            User::where('id', $user->id)->update([
                'firstName' => $fields['firstName'],
                'surname' => $fields['surname'],
                'username' => $fields['username'],
                'email' => $fields['email'],
                'updated_at' => now()
            ]);
        }
         
        $user = User::find(Auth::id());
        
        $customerDetails = collect($user)->only('id', 'firstName', 'surname', 'username', 'email', 'created_at');
        $customerVisits = CustomerVisits::with('room')
                                        ->where('customerId', $customerDetails['id'])
                                        ->orderBy('checkOut', 'Desc')
                                        ->paginate(5);
        return Inertia::render('Customers/customerDashboard', [
            'customerDetails' => $customerDetails,
            'customerVisits' => $customerVisits
        ]);
    }

    public function editAdminProfile(){
        $user = Auth::user();
        $details = collect($user)->only('id', 'firstName', 'surname', 'username', 'email');

        return Inertia::render('Admin/editAdminProfile', [
            'user' => $details,
        ]);
    }

    public function updateAdminProfile(Request $request)
    {
        sleep(1);
        
        if($request->password){
            $fields = $request->validate([
                'firstName' => ['required', 'max:255'],
                'surname' => ['required', 'max:255'],
                'username' => ['required', 'max:255'],
                'email' => ['required', 'email', 'max:255'],
                'password' => ['required', 'max:255']
            ]);
           
            $user = Auth::user();

            User::where('id', $user->id)->update([
                'firstName' => $fields['firstName'],
                'surname' => $fields['surname'],
                'username' => $fields['username'],
                'email' => $fields['email'],
                'password' => Hash::make($fields['password']),
                'updated_at' => now()
            ]);
        } else{
            
            $fields = $request->validate([
                'firstName' => ['required', 'max:255'],
                'surname' => ['required', 'max:255'],
                'username' => ['required', 'max:255'],
                'email' => ['required', 'email', 'max:255'],
            ]);

            $user = Auth::user();

            User::where('id', $user->id)->update([
                'firstName' => $fields['firstName'],
                'surname' => $fields['surname'],
                'username' => $fields['username'],
                'email' => $fields['email'],
                'updated_at' => now()
            ]);
        }
         
        return redirect()->route('allRooms');
    }

    public function editCustomerProfile(Request $request){
        $user = User::find($request->customerId);
        $details = collect($user)->only('id', 'firstName', 'surname', 'username', 'email');

        return Inertia::render('Admin/editCustomerProfile', [
            'user' => $details,
        ]);
    }

    public function updateCustomerProfile(Request $request)
    {
        sleep(1);
      
        if($request->password){
            $fields = $request->validate([
                'firstName' => ['required', 'max:255'],
                'surname' => ['required', 'max:255'],
                'username' => ['required', 'max:255'],
                'email' => ['required', 'email', 'max:255'],
                'password' => ['required', 'max:255']
            ]);
            
            $user = User::find($request->userId);

            User::where('id', $user->id)->update([
                'firstName' => $fields['firstName'],
                'surname' => $fields['surname'],
                'username' => $fields['username'],
                'email' => $fields['email'],
                'password' => Hash::make($fields['password']),
                'updated_at' => now()
            ]);
        } else{
            
            $fields = $request->validate([
                'firstName' => ['required', 'max:255'],
                'surname' => ['required', 'max:255'],
                'username' => ['required', 'max:255'],
                'email' => ['required', 'email', 'max:255'],
            ]);

            $user = User::find($request->userId);

            User::where('id', $user->id)->update([
                'firstName' => $fields['firstName'],
                'surname' => $fields['surname'],
                'username' => $fields['username'],
                'email' => $fields['email'],
                'updated_at' => now()
            ]);
        }
         
        $customerDetails = User::where('users.id', $request->userId)
                                ->get();
        $customerVisits = CustomerVisits::with('room')
                        ->where('customerId', $request->userId)
                        ->orderBy('customervisits.checkOut', 'Desc')
                        ->paginate(5);
        return Inertia::render('Customers/customerDetails', [
            'customerDetails' => $customerDetails,
            'customerVisits' => $customerVisits
        ]);
    }
}
