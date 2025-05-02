<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use App\Models\User;
use App\DataTables\OwnersDataTable;
use App\DataTables\TenantsDataTable;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function owners(OwnersDataTable $dataTable)
    {
        $pageTitle = 'owners Managment';
        $title = 'owners';
        $columns = $dataTable->getViewColumns();
        $button = isAdmin() ? '<a href="'.route('admin.adduser' , ['role'=>USER_ROLE_OWNER]) .'" class="btn btn-success btn-sm">
        <i class="fas fa-plus"></i>'.__('message.add_new',[__('message.owner.0')]).'</a>' : '';
        return $dataTable->render('common.tables', compact(['columns','title','pageTitle','button']));
    
    }

    public function create(Request $request){
        $add = $request->role ==USER_ROLE_OWNER ? __('message.owners') : __('message.tenants');
        $pageTitle = 'Add '.$add;
        $role = $request->role;
        return view('common.profile.my-profile', compact(['pageTitle','role']));
    }


    public function store(Request $request){
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'contact_number' => ['required', 'string','max:255','unique:'.User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role'=> ['required','in:'.USER_ROLE_OWNER.','.USER_ROLE_TENANT],
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        return redirect()->route($request->role==USER_ROLE_TENANT ? 'admin.tenants' : 'admin.owners')->with('success',  __('message.saved',[$request->role==USER_ROLE_TENANT ? __('message.tenant') : __('message.owner.0')]));
    }

    public function tenants(TenantsDataTable $dataTable)
    {
        $pageTitle = 'Tenants Managment';
        $title = 'Tenants';
        $columns = $dataTable->getViewColumns();
        $button = isAdmin() ? '<a href="'.route('admin.adduser' , ['role'=>USER_ROLE_TENANT]) .'" class="btn btn-success btn-sm">
        <i class="fas fa-plus"></i> Add New '. $title .'</a>' : '';
        return $dataTable->render('common.tables', compact(['columns','title','pageTitle','button']));
    
    }

    public function edit($id){
        $pageTitle = 'Edit User';
        $user = User::findOrFail($id);
        return view('common.profile.my-profile',compact(['pageTitle','user']));
    }


    public function activte($id){
        if(!isAdmin()){
            return back(401)->with('error','message.action_forbidden');
        }
        $user = User::findOrFail($id);
        $user->status = $user->status ? 0 : 1;
        $user->save();
        return back()->with('success',__('message.user_active',[$user->status ? __('message.activate') : __('message.deactivate')]));
        
    }

    public function destroy($id){
        if(!isAdmin()){
            return back(401)->with('error','message.action_forbidden');
        }
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('success','user deleted succesfully');

    }
}
