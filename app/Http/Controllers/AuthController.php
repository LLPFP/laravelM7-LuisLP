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

    public function getUser(Request $request)
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'message' => 'User retrieved successfully',
            'data' => $user
        ], 200);
    }

    public function getUserById($id)
    {
        // Buscar el usuario por ID
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'message' => 'User retrieved successfully',
            'data' => $user
        ], 200);
    }

    public function getAllUsers()
    {
        // Obtener todos los usuarios
        $users = User::all();

        return response()->json([
            'message' => 'All users retrieved successfully',
            'data' => $users
        ], 200);
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

    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'role' => 'required|string|in:admin,user',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|string|min:5|confirmed',]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->has('name')) {
            $user->name = $request->get('name');
        }
        if ($request->has('role')) {
            $user->role = $request->get('role');
        }
        if ($request->has('email')) {
            $user->email = $request->get('email');
        }
        if ($request->has('password')) {
            $user->password = bcrypt($request->get('password'));
        }

        $user->save();

        return response()->json([
            'message' => 'User updated successfully',
            'data' => $user
        ], 200);
    }

    public function updateUserPartial(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:100',
            'role' => 'sometimes|string|in:admin,user',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|string|min:5|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->has('name')) {
            $user->name = $request->get('name');
        }
        if ($request->has('role')) {
            $user->role = $request->get('role');
        }
        if ($request->has('email')) {
            $user->email = $request->get('email');
        }
        if ($request->has('password')) {
            $user->password = bcrypt($request->get('password'));
        }

        $user->save();

        return response()->json([
            'message' => 'User partially updated successfully',
            'data' => $user
        ], 200);
    }

    public function deleteUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
