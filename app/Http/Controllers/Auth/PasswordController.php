<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Hash;
use App\Models\SMSMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class PasswordController extends Controller
{
    public function index(): View
    {
        return view('common.profile.change-password', ['pageTitle' => __("message.change_password")]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', __('message.auth_failed'));
        }
        $user->password = Hash::make($request->password);
        $user->save();
        return back()->with('success', __('message.pass_change_sucess'));
    }

    public function resetpassword(Request $request)
    {
        $now = now();
        $otp = implode('', $request->otp);
        if (!SMSMessage::where('code', $otp)->where('phone', $request->phone)->where('expires_at', '>', $now)->first()) {
            return back()->with('error', 'otp code invalid');
        }
        $user = User::where('contact_number', $request->phone)->first();
        if (!$user) {
            return back(404)->with('error', 'user not found');
        }
        $user->password = Hash::make($request->password);
        Auth::login($user);
        $user->phone_verified_at = time();
        $user->save();
        return redirect()->route('dashboard')->with('success', __('message.reset_password_success'));

    }
}
