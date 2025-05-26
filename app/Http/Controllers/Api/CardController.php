<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;


class CardController extends Controller
{
    public function index()
    {
        return response()->json(['cards' => Card::all()], 200);
    }

    public function show($id)
    {
        $card = Card::find($id);
        if (!$card) {
            return response()->json(['error' => 'Card not found'], 404);
        }
        return response()->json(['card' => $card], 200);
    }



    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'message' => 'Usuari no autenticat'
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:100',
            'imatge' => 'required|url',
            'category_id' => 'required|exists:categories,id',
            'user_id' => [
                'nullable',
                'exists:users,id',
                Rule::in([$user->id]) // Permet només l'usuari autenticat
            ]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validació',
                'errors' => $validator->errors()
            ], 422);
        }

        $card = Card::create([
            'nom' => $request->nom,
            'imatge' => $request->imatge,
            'category_id' => $request->category_id,
            'user_id' => $user->id,
        ]);

        return response()->json([
            'message' => 'Targeta creada',
            'data' => $card
        ], 201);
    }

    public function myCards()
    {
        $cards = Card::where('user_id', Auth::id())->get();

        return response()->json([
            'message' => 'Les teves targetes',
            'data' => $cards
        ]);
    }

    public function publicCards()
    {
        $cards = Card::whereNull('user_id')->get();

        return response()->json([
            'message' => 'Targetes públiques',
            'data' => $cards
        ]);
    }


    public function update(Request $request, $id)
    {
        $card = Card::find($id);
        if (!$card) {
            return response()->json(['error' => 'Card not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'imatge' => 'required|string|max:255',
            'category_id' => 'required|integer|min:0'

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $card->update($request->all());
        return response()->json(['card' => $card], 200);
    }

    public function updatePartial(Request $request, $id)
    {
        $card = Card::find($id);
        if (!$card) {
            return response()->json(['error' => 'Card not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nom' => 'sometimes|string|max:255',
            'imatge' => 'sometimes|string|max:255',
            'category_id' => 'required|integer|min:0'

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $card->update($request->all());
        return response()->json(['card' => $card], 200);
    }

    public function destroy(Card $card)
    {
        $user = Auth::user();
        if ($card->user_id !== $user->id && $user->role !== 'admin') {
            return response()->json(['error' => 'No autoritzat'], 403);
        }

        $card->delete();
        return response()->json(['message' => 'Targeta eliminada']);
    }



}
