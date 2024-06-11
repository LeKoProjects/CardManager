<?php

namespace App\Http\Controllers;

use App\Models\Tipo;
use Illuminate\Http\Request;

class TipoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipo = Tipo::all();

        return view('cadastro.tipo', compact('tipo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Capitalize the input
        $tipo = ucfirst(trim($request->input('nome')));

        // Check if the permission already exists
        $existeTipo = Tipo::where('nome', $tipo)->first();

        if ($existeTipo) {
            return redirect()->route('tipo.index')->with('error', 'Tipo já existe!');
        }

        // Create a new permission
        Tipo::create([
            'nome' => $tipo,
        ]);

        return redirect()->route('tipo.index')->with('success', 'Tipo cadastrado!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tipo $tipo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tipo $tipo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $tipo = Tipo::find($id);

        if (!$tipo) {
            return redirect()->back()->with('error', 'Tipo não encontrada!');
        }

        $tipo->nome = ucfirst(trim($request->input('nome')));

        $tipo->save();

        return redirect()->back()->with('success', 'Tipo Atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tipo = Tipo::findOrFail($id);

        $tipo->delete();

        return redirect()->route('tipo.index')->with('success', 'Tipo excluída com sucesso!');
    }
}
