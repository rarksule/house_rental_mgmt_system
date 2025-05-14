<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use App\Models\House;
use App\Models\Message;
use App\Models\Setting;
use App\Models\Language;
use App\Models\UserHistory;
use Auth;
use Mews\Purifier\Facades\Purifier;

class AdminController extends Controller
{
    public function index(): View
    {
        $auth = Auth::user();
        return view('admin.dashboard', [
            'user' => $auth,
            'totalOwner' => User::where('role', USER_ROLE_OWNER)->count(),
            'totalHouse' => House::count(),
            'totalmessage' => Message::count(),
            'totalTenant' => User::where('role', USER_ROLE_TENANT)->count(),
            'tenants' => User::where('role', USER_ROLE_TENANT)->orderBy('created_at', 'desc')->limit(5)->get(),
            'owners' => User::where('role', USER_ROLE_OWNER)->orderBy('created_at', 'desc')->limit(5)->get(),

        ]);
    }

    public function settings()
    {
        $languages = Language::all();
        $setting = Setting::find(1);
        return view('admin.setting', compact(['languages','setting']));
    }

    public function language(Request $request)
    {
        $langs = Language::all();
        foreach ($langs as $lang) {
            $lang->status = isset($request->languages[$lang->id]);
            $lang->save();
        }
        return back()->with('success', __("message.saved",['form'=>__('message.language')]));
    }

    public function policy(Request $request)
    {

        $cleanprivacy_policy = Purifier::clean($request->input('privacy_policy'));
        $cleancookie_policy = Purifier::clean($request->input('cookie_policy'));
        $cleanterms_conditions = Purifier::clean($request->input('terms_conditions'));
        $settings = Setting::firstOrCreate(['id' => 1]);
        $settings->update(['privacy_policy' => $cleanprivacy_policy, 'cookie_policy' => $cleancookie_policy, 'terms_conditions' => $cleanterms_conditions]);
        return back()->with('success', __("message.saved",['form'=>__('message.policy')]));
    }

    public function ownerHistory(Request $request){
        if(isAdmin()){
            $rentalHistory = UserHistory::whereHas('user', function($query) {
                $query->where('role', USER_ROLE_OWNER); // assuming 'role' column exists in users table
            })->get();
        }
        $who = __("message.owners");
        
        return view('admin.user_history',compact(['rentalHistory',"who"]));
    }


    public function reply(Request $request)
    {
        if(!isAdmin()){
            return back()->with('error',__('message.action_forbidden'));
        }

        ReviewReplay::create([
            'content'=>$request->content,
            'user_id'=>auth()->id(),
            'review_id' =>$request->review_id,
        ]);

        return back()->with('success',__('message.saved',['form' => __('message.reply')]));
        
    }


}
