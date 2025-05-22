<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pet;
use Illuminate\Support\Facades\Auth;

class PetsController extends Controller
{
    public function getMyPets(Request $request)
    {
        $user = Auth::user();
        $pets = Pet::where('user_id', $user->id)->get();

            return response()->json([
                'success' => true,
                'data' => $pets,
                'message' => 'Pets retrieved successfully'
            ], 200);
        }

    public function createPet(Request $request){
        $user = Auth::user();
        $request->validate([
            'nombre' => 'required|string|max:100',
            'raza' => 'required|string|max:100',
            'edad' => 'required|integer|min:0',
        ]);
        $pet = new Pet();
        $pet->nombre = $request->nombre;
        $pet->raza = $request->raza;
        $pet->edad = $request->edad;
        $pet->user_id = $user->id;
        $pet->save();
        return response()->json([
            'success' => true,
            'data' => $pet,
            'message' => 'Pet created successfully'
        ], 201);

    }

    public function completeUpdatePet(Request $request, $id)
    {
        $user = Auth::user();
        $pet = Pet::where('id', $id)->first();

        if (!$pet) {
            return response()->json([
                'success' => false,
                'message' => 'Mascota no encontrada'
            ], 404);
        }

        if ($user->id !== $pet->user_id && $user->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'No autoritzat'
            ], 403);
        }

        $request->validate([
            'nombre' => 'required|string|max:100',
            'raza' => 'required|string|max:100',
            'edad' => 'required|integer|min:0',
        ]);

        $pet->nombre = $request->nombre;
        $pet->raza = $request->raza;
        $pet->edad = $request->edad;
        $pet->save();

        return response()->json([
            'success' => true,
            'data' => $pet,
            'message' => 'Pet complete updated successfully'
        ], 200);
    }

    public function partialUpdatePet(Request $request, $id)
    {
        $user = Auth::user();
        $pet = Pet::where('id', $id)->first();

        if (!$pet) {
            return response()->json([
                'success' => false,
                'message' => 'Mascota no encontrada'
            ], 404);
        }

        if ($user->id !== $pet->user_id && $user->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'No autoritzat'
            ], 403);
        }

        $request->validate([
            'nombre' => 'sometimes|required|string|max:100',
            'raza' => 'sometimes|required|string|max:100',
            'edad' => 'sometimes|required|integer|min:0',
        ]);

        if ($request->has('nombre')) {
            $pet->nombre = $request->nombre;
        }
        if ($request->has('raza')) {
            $pet->raza = $request->raza;
        }
        if ($request->has('edad')) {
            $pet->edad = $request->edad;
        }
        $pet->save();

        return response()->json([
            'success' => true,
            'data' => $pet,
            'message' => 'Pet partial updated successfully'
        ], 200);
    }

    public function deletePet(Request $request, $id)
    {
        $user = Auth::user();
        $pet = Pet::where('id', $id)->first();

        if (!$pet) {
            return response()->json([
                'success' => false,
                'message' => 'Mascota no encontrada'
            ], 404);
        }

        if ($user->id !== $pet->user_id && $user->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'No autoritzat'
            ], 403);
        }

        $pet->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pet deleted successfully'
        ], 200);
    }

}
