<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function index()
    {
    return Category::with('cards')->get(); // opcional
    }

    public function store(Request $request)
    {
        if (!$request->has('name') || empty($request->input('name'))) {
            return response()->json(['error' => 'El campo name es obligatorio'], 422);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:100'
        ]);

        return Category::create([
            'name' => $validated['name']
        ]);
    }


    public function update(Request $request, Category $category)
    {
        try {
            $request->validate(['name' => 'required|string|max:100']);
            $category->update($request->only('name'));
            return response()->json($category, 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar la categoría'], 500);
        }
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return response()->json(['message' => 'Categoria eliminada'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar la categoría'], 500);
        }
    }


}
