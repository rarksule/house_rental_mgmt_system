<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use App\Models\User;
use App\HistoryTrait;


class UserController extends Controller
{
    use HistoryTrait;

    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'contact_number' => ['required', 'string', 'max:9', 'min:9', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => ['required', 'in:' . USER_ROLE_OWNER . ',' . USER_ROLE_TENANT],
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'contact_number' => $request->contact_number,
            'status' => 1,
            'role' => $request->role,
        ]);
        $this->recordHistory(REGISTERED,$user->id);

        return redirect()->route('phoneVerify', ['phone' => $request->contact_number])->with('warning', __('message.verify_phone'));

    }
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return back()->with('error', __('auth.failed'));
        }

        $user = User::where('email', $request->email)->first();
        if (isset($user)) {
            session()->put('locale', $user->locale);
            if (($user->deleted_at != null)) {
                Auth::logout();
                return back()->with('error', __('message.user_status', __('message.deleted')));
            } elseif (($user->status != USER_STATUS_ACTIVE)) {
                Auth::logout();
                return back()->with('error', __('message.user_status', __('message.inactive')));
            } elseif (($user->phone_verified_at == null && $user->role != USER_ROLE_ADMIN)) {
                $phone = $user->contact_number;
                Auth::logout();
                return redirect()->route('phoneVerify', ['phone' => $phone])->with('warning', __('message.verify_phone'));

            } elseif (($user->status == USER_STATUS_ACTIVE)) {
                return redirect()->route('dashboard');
            } else {
                Auth::logout();
                return back()->with('error', __(SOMETHING_WENT_WRONG));
            }
        } else {
            Auth::logout();
            return back()->with('error', __(SOMETHING_WENT_WRONG));
        }
    }



    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = User::where('email', $request->email)->first();

        if (!isset($user) || (!isAdmin() && ($user->id != Auth::user()->id))) {
            return back()->with('error', __('message.action_forbidden'));
        }
        if (!Hash::check($request->password, $user->password) && !isAdmin()) {
            return back()->with('error', __('message.action_forbidden'));
        }
        $user->delete();
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }


    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        return redirect('/');
    }


}

