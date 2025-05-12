<?php

namespace App\Http\Controllers\Owner;

use App\Models\UserHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Message;

class OwnerController extends Controller
{

    /**
     * Display the user's profile form.
     */
    public function index(): View
    {
        $auth = Auth::user();
        $renters = User::whereHas('rentedHouse', function($query) {
            $query->where('owner_id', auth()->id());
        })->with(['rentedHouse' => function($query) {
            $query->orderBy('payment_date', 'asc');
        }])->limit(5)->get();
        return view('owner.dashboard', [
            'user' => $auth,
            'totalProperties'=>$auth->houses->count(),
            'totalTenants'=>$auth->houses->whereNotNull('tenant_id')->count(),
            'revenue'=>$auth->houses->whereNotNull('tenant_id')->sum('price'),
            'renters'=>$renters,
            'tenantLead' => tourRequested(1)
        ]);
    }


    public function tenatHistory(Request $request){
        if(isAdmin()){
            $rentalHistory = UserHistory::whereHas('user', function($query) {
                $query->where('role', USER_ROLE_TENANT); // assuming 'role' column exists in users table
            })->get();
            $who = __("message.tenants");
        }else{
            $userId = auth()->id();
            $rentalHistory = User::find($userId)->houseHistories;
            $who = __("message.your");
        }
        
        return view('admin.user_history',compact(['rentalHistory','who']));
    }

    
}
