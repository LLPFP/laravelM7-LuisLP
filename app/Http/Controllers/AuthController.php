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
            'nombre' => 'required|string|max:100',
            'rol' => 'required|string|in:admin,usuari',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:5|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Create the User
        $usuari = User::create([
            'nombre' => $request->nombre,
            'rol' => $request->rol,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Return a success response
        return response()->json(['message' => 'User registered successfully', 'data' => $usuari], 201);

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
        // Attempt to log the User in
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

    public function logout()
    {
        try{
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json(['message' => 'User logged out successfully'], 200);
        }catch (JWTException $e){
            return response()->json(['message' => 'Could not log out', 500]);
        }
    }

    public function getUserById($id)
    {
        // Buscar el Usero por ID
        $usuari = User::find($id);

        if (!$usuari) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'message' => 'User retrieved successfully',
            'data' => $usuari
        ], 200);
    }

    public function getAllUsers()
    {
        // Obtener todos los Useros
        $usuaris = User::all();

        return response()->json([
            'message' => 'All Users retrieved successfully',
            'data' => $usuaris
        ], 200);
    }


    public function updateUser(Request $request, $id)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'nombre' => 'string|max:100',
            'rol' => 'string|in:admin,usuari',
            'email' => 'string|email|max:255|unique:users,email,' . $id,
            'password' => 'string|min:5|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Find the User
        $usuari = User::find($id);

        if (!$usuari) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        // Update the User
        $usuari->update($request->all());

        return response()->json([
            'message' => 'User updated successfully',
            'data' => $usuari
        ], 200);
    }

    public function deleteUser($id)
    {
        // Find the User
        $usuari = User::find($id);

        if (!$usuari) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        // Delete the User
        $usuari->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ], 200);
    }



}
