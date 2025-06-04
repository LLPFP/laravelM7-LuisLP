<?php

namespace App\Http\Controllers;

use App\Models\Joc;
use Illuminate\Http\Request;

class JocController extends Controller
{
    /**
     * Mostrar tots els jocs.
     * GET /jocs
     */
    public function index()
    {
        $jocs = Joc::all();
        return view('jocs.index', compact('jocs'));
    }

    /**
     * Mostrar el formulari per afegir joc.
     * GET /jocs/create
     */
    public function create()
    {
        return view('jocs.create');
    }

    /**
     * Guardar el nou joc a BBDD.
     * POST /jocs
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'descripcio' => 'nullable|string',
            'genere' => 'required|string|max:255',
            'any_llancament' => 'required|integer',
            'desenvolupador' => 'required|string|max:255',
        ]);

        Joc::create($request->all());
        return redirect()->route('jocs.index')->with('success', 'Joc creat correctament!');
    }

    /**
     * Mostrar un joc concret.
     * GET /jocs/{joc}
     */
    public function show(Joc $joc)
    {
        return view('jocs.show', compact('joc'));
    }

    /**
     * Formulari per editar un joc.
     * GET /jocs/{joc}/edit
     */
    public function edit(Joc $joc)
    {
        return view('jocs.edit', compact('joc'));
    }

    /**
     * Guardar l’edició d’un joc.
     * PUT/PATCH /jocs/{joc}
     */
    public function update(Request $request, Joc $joc)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'descripcio' => 'nullable|string',
            'genere' => 'required|string|max:255',
            'any_llancament' => 'required|integer',
            'desenvolupador' => 'required|string|max:255',
        ]);

        $joc->update($request->all());
        return redirect()->route('jocs.index')->with('success', 'Joc actualitzat correctament!');
    }

    /**
     * Esborrar un joc.
     * DELETE /jocs/{joc}
     */
    public function destroy(Joc $joc)
    {
        $joc->delete();
        return redirect()->route('jocs.index')->with('success', 'Joc eliminat correctament!');
    }
}
