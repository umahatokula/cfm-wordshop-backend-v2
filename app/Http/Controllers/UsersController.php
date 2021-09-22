<?php

namespace App\Http\Controllers;

use DB;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserCollection;
use App\Http\Controllers\UsersController;
use App\Http\Resources\User as UserResource;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
    	// $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data['usersMenu'] = 1;
    	$data['title'] = 'Manage Users';
    	$data['roles'] = Role::pluck('name', 'id');
    	$data['users'] = User::all();
    	$data['permissions'] = [];

    	return view('users.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

    	$rules = [
    	'name' => 'required',
    	'password' => 'required',
        'email' => 'required|email|unique:users,email',
    	// 'username' => 'required|unique:users,username',
    	'role_ids' => 'required',
    	];

    	$messages = [
    	'name.required' => 'Name is required',
    	'password.required' => 'Password is required',
    	'email.required' => 'Email is required',
    	'username.required' => 'Username is required',
    	'role_ids.required' => 'Select at least one role',
    	];

        $this->validate($request, $rules, $messages);

        $user               = new User;
        $user->email 		= $request->email;
    	$user->password     = \Hash::make($request->password);
    	$user->name   		= $request->name;
    	// $user->username     = $request->username;
    	$user->save();

        // assign role
        // $role = config('roles.models.role')::where('id', '=', $request->role_ids)->first();
        // $user->attachRole($role);
        $user->assignRole($request->role_ids);

    	return redirect('users');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        if (request()->expectsJson()) {
            return response([
                'data' => new UserResource($user)
            ], 200);
        }

        return view('users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
    	$data['title'] = 'Edit Users';
    	$data['manage_users'] = 1;
    	$data['user'] = User::find($id);
    	$data['roles'] = Role::pluck('name', 'id');

    	return view('users.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());

    	$rules = [
    	'name' => 'required',
    	'password' => 'required',
        'email' => 'required|email',
    	'username' => 'required',
    	'role_ids' => 'required',
    	];

    	$messages = [
    	'name.required' => 'Name is required',
    	'password.required' => 'Password is required',
    	'email.required' => 'Email is required',
    	'username.required' => 'Username is required',
    	'role_ids.required' => 'Select at least one role',
    	];

        $this->validate($request, $rules, $messages);

        $user               = User::find($id);
        $user->email 		= $request->email;
    	$user->password     = \Hash::make($request->password);
    	$user->name   		= $request->name;
    	$user->username     = $request->username;
        $user->save();
        

        // detach roles
        $user->detachAllRoles();

        // attach roles
        $user->syncRoles($request->role_ids);

    	return redirect('users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        	$user = User::destroy($id);

        	return redirect('users');
    }


        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $user = User::destroy($id);

        session()->flash('successMessage', 'User was deleted.');
        return redirect('users');
    }


    /**
     * Activate Resource
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activate($id)
    {
        $user = User::find($id);
        $user->status_id = 1;
        $user->save();

        return redirect('users');
    }


    /**
     * Deactivate Resource
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deactivate($id)
    {
        $user = User::find($id);
        $user->status_id = 2;
        $user->save();

        return redirect('users');
    }


    /**
     * show form to change password
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function changePassword() {
        return view('settings.users.changePassword');
    }


    /**
     * store changed password
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function storeChangedPassword(Request $request) {
        // dd($request->all());
        //password update.
        $now_password       = $request->now_password;
        $password           = $request->password;
        $passwordconf       = $request->password_confirmation;
        $id                 = $request->id;

        $rules = array(
            'now_password'          => 'required',
            'password'              => 'required|min:5|confirmed|different:now_password',
            'password_confirmation' => 'required_with:password|min:5'
            );

        $messages = array(
            'now_password.required' => 'Your current password is required',
            'password.required' => 'Your new password is required',
            'password.confirmed' => 'New password and confirmationn must match',
            'password.different' => 'You new password must be different from current password',
            'password.min' => 'New passwordmust be at least 5 characters' );


        $validator = \Validator::make($request->only('now_password', 'password', 'password_confirmation'), $rules, $messages);

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator);

        } elseif (\Hash::check($now_password, \Auth::user()->password)) {

            $user = User::find($id);
            $user->password = \Hash::make($password);
            $user->save();
            return redirect()->back()->with('success', true)->with('successMessage','Password changed successfully.');

        } else  {

            return redirect()->back()->with('errorMessage','Old password is incorrect');

        }

        return view('settings.users.changePassword');
    }
}
