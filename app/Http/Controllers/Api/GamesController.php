<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class GamesController extends Controller
{
    //
    public function index()
    {
        return response()->json(['games' => Game::all()], 200);
    }

    public function show($id)
    {
        $game = Game::find($id);
        if (!$game) {
            return response()->json(['error' => 'Game not found'], 404);
        }
        return response()->json(['game' => $game], 200);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:100',
            'usuari' => 'required|string|max:255',
            'data' => 'required|date',
            'hora' => 'required|date_format:H:i:s',
            'puntuació' => 'required|numeric',
            'clics' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $game = Game::create($request->all());
        return response()->json(['game' => $game], 201);
    }
}
