<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //

    public function register(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'role' => 'required|string|in:admin,user',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:5|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Create the user
        $user = User::create([
            'name' => $request->get('name'),
            'role' => $request->get('role'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);

        // Return a success response
        return response()->json(['message' => 'User registered successfully', 'data' => $user], 201);

    }


    public function login(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:100',
            'password' => 'required|string|min:5',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $credentials = $request->only('email', 'password');
        // Attempt to log the user in
        try{
            if(!$token = JWTAuth::attempt($credentials)){
                return response()->json(['message' => 'Invalid credentials'], 401);
            }
            return response()->json(['message' => 'Login successful', 'token' => $token], 200);

        }catch (JWTException $e){
            return response()->json
            (['error' => 'Could not create token', 'message' => $e->getMessage()], 500);


        }
    }

    public function getUser(){
        // Get the authenticated user
        $user = auth()->user();

        return response()->json
        ([
        'message'=>'User retrieved succesfully',
        'data' => $user], 200);
    }


    public function logout()
    {
        try{
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json(['message' => 'User logged out successfully'], 200);
        }catch (JWTException $e){
            return response()->json(['message' => 'Could not log out', 500]);
        }
    }
}
