<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function updateCustomerInfo(Request $request, $id) {
        // dd($request->all(), $id);

        $rules = [
        'name' => 'required',
        'email' => 'required|email',
        // 'email' => 'required|email|unique:users,email',
        // 'username' => 'required|unique:users,username',
        ];

        $messages = [
        'name.required' => 'Name is required',
        'email.required' => 'Email is required',
        'email.unique' => 'This email is already registered with us',
        // 'username.required' => 'Username is required',
        ];

        $this->validate($request, $rules, $messages);

        $user = User::find($id);
        // dd($user);
        $user->name     = $request->name;
        $user->username = $request->username;
        $user->email    = $request->email;
        $user->phone    = $request->phone;
        $user->save();

        return response()->json($user, 200);;
    }
}
