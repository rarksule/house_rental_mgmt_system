<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $pageTitle = __('message.edit_profile');
        $user = auth()->user();
        return view('common.profile.my-profile', compact(['pageTitle', 'user']));
    }

    public function update(Request $request, $id)
    {
        $authuser = auth()->user();
        if ($authuser->id != $id && !isAdmin()) {
            return redirect()->back(402)->with('error', __('message.action_forbidden'));
        }
        $user = User::findOrFail($id);

        $user->update($request->all());
        if ($request->hasFile('profile_image')) {
            $user->addImage();
        }
        return redirect()->back()->with('success',__('message.saved',['form'=>__('message.profile')]));

    }
}
