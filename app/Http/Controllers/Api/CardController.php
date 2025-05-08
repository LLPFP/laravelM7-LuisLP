<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


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
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'imatge' => 'required|string|max:255', // podrías validar como URL si es necesario
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $card = Card::create($request->all());
        return response()->json(['card' => $card], 201);
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
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $card->update($request->all());
        return response()->json(['card' => $card], 200);
    }

    public function destroy($id)
    {
        $card = Card::find($id);
        if (!$card) {
            return response()->json(['error' => 'Card not found'], 404);
        }

        $card->delete();
        return response()->json(['message' => 'Card deleted successfully'], 200);
    }


}
