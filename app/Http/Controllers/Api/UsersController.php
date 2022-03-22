<?php

namespace App\Http\Controllers\Api;

use DB;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserCollection;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\User as UserResource;

class UsersController extends Controller
{
    
        
    /**
     * login
     *
     * @param  mixed $request
     * @return void
     */
    function login (LoginRequest $request) {

        $credentials = request(['email', 'password']);
        if (!auth()->attempt($credentials)) {
            return response()->json([
                'message' => 'These credentials do not match our records.',
                'errors' => [
                    'password' => [
                        'Invalid credentials'
                    ],
                ]
            ], 422);
        }

        $user = User::where('email', $request->email)->first();
        $authToken = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'status' => true,
            'user'    => $user,
            'token' => $authToken,
        ], 200);
    }

    /**
     * Register a new user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function signup(StoreUserRequest $request) {
        // dd($request->all());
        
        $validated = $request->validated();

        $user               = new User;
        $user->email 		= $request->email;
    	$user->password     = \Hash::make($request->password);
    	$user->name   		= $request->name;
    	$user->save();

        $token = $user->createToken('frontend-token')->plainTextToken; // create personalized access token

        $user->assignRole($request->role_ids);

    	return response()->json([
            'status' => true,
            'user'    => $user,
            'token'   => $token
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {

        $user = auth()->user();

        return response([
            'status' => true,
            'user'    => new UserResource($user)
        ], 200);

    }
    
    /**
     * logout
     *
     * @param  mixed $request
     * @return void
     */
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => true,
            'message' => 'User successfully signed out'
        ]);
    }
    
}
