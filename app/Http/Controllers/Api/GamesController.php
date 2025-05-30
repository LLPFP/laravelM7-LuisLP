<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\AuthController;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Support\Facades\Auth;



class GamesController extends Controller
{
    //
    public function index()
    {
        $userId = Auth::id();
        $games = Game::where('user_id', $userId)->get();
        return response()->json(['games' => $games], 200);
    }

    public function show($id)
    {
        $game = Game::find($id);
        if (!$game) {
            return response()->json(['error' => 'Game not found'], 404);
        }
        if ($game->user_id !== Auth::id()) {
            return response()->json(['error' => 'No tienes permiso para ver esta partida'], 403);
        }
        return response()->json(['game' => $game], 200);
    }


   public function store(Request $request)
    {
            $game = Game::create([
            'user_id' => Auth::id(),
            'puntuació' => 0,
            'clics' => 0,
            'duració' => 0,
            ]);



       return response()->json([
        'message' => 'Partida creada',
        'data' => $game
    ], 201);

    }


    public function update(Request $request, $id)
    {
        $game = Game::find($id);
        if (!$game) {
            return response()->json(['error' => 'Game not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'duració' => 'required|integer|min:0',
            'puntuació' => 'required|integer|min:0',
            'clics' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $game->update($request->all());

        return response()->json(['message' => 'Game updated successfully', 'game' => $game], 200);
    }

   public function destroy($id)
    {
        $game = Game::find($id);
        if (!$game) {
            return response()->json(['error' => 'Game not found'], 404);
        }

        $user = Auth::user();
        // Permitir solo si es propietario o admin
        if ($game->user_id !== $user->id && $user->role !== 'admin') {
            return response()->json(['error' => 'No tienes permiso para eliminar esta partida'], 403);
        }

        $game->delete();

        return response()->json(['message' => 'Game deleted successfully'], 200);
    }


    public function ranking()
    {
        $users = Game::select('user_id')
            ->groupBy('user_id')
            ->get();

        $ranking = [];

        foreach ($users as $user) {
            $bestGame = Game::where('user_id', $user->user_id)
                ->orderBy('duració')
                ->orderBy('clics')
                ->orderByDesc('puntuació')
                ->first();

            if ($bestGame) {
                $bestGame->load('user:id,name');
                $ranking[] = $bestGame;
            }
        }

        // Ordena el ranking final
        $ranking = collect($ranking)
            ->sortBy([
                ['duració', 'asc'],
                ['clics', 'asc'],
                ['puntuació', 'desc'],
            ])
            ->take(5)
            ->values();

        return response()->json([
            'message' => 'Top 5 jugadors',
            'data' => $ranking
        ], 200);
    }


    public function getGamesByUserId($id)
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            return response()->json(['error' => 'Només per admins'], 403);
        }

        $games = Game::where('user_id', $id)->get();

        return response()->json([
            'message' => "Partides de l’usuari $id",
            'data' => $games
        ]);
    }

    public function showAllGames()
    {
        $games = Game::with('user:id,name')->get();

        return response()->json([
            'message' => 'Totes les partides',
            'data' => $games
        ], 200);
    }


}
