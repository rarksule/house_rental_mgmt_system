<?php

namespace App\Http\Controllers;

use App\Models\SMSMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SMSMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::where('contact_number', $request->phone);
        if (!$user) {
            return response(404)->json('user not found');
        }
        $otp = str_pad(random_int(0, pow(10, 6) - 1), 6, '0', STR_PAD_LEFT);

        $expiry = time() + (2 * 60);
        SMSMessage::create([
            'code' => $otp,
            'expires_at' => $expiry,
            'phone' => $request->phone,
        ]);
        return response()->json('OTP sent successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        if (session('warning')) {
            $this->store($request);
        }
        return view('auth.phone_verify', ['phone' => $request->phone]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SMSMessage $sMSMessage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $now = now();
        $otp = implode('', $request->otp);
        if (SMSMessage::where('code', $otp)->where('phone', $request->phone)->where('expires_at', '>', $now)->first()) {
            $user = User::where('contact_number', $request->phone)->first();
            Auth::login($user);
            $user->phone_verified_at = time();
            $user->save();
            return redirect()->route('dashboard')->with('success', 'phone Verification Successfull');
        }
        return back()->with('error', 'data received');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SMSMessage $sMSMessage)
    {
        //
    }
}
