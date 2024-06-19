<?php

namespace App\Http\Controllers;

use App\Models\Moedas;
use Illuminate\Http\Request;

class MoedasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $moeda = Moedas::orderBy('created_at', 'desc')->get();

        return view('cadastro.moeda', compact('moeda'));
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
        $moeda = ucfirst(trim($request->input('moeda')));
        $abreviacao = $request->input('abreviacao');

        // Check if the permission already exists
        $existeMoeda = Moedas::where('moeda', $moeda, 'abreviacao', $abreviacao)->first();

        if ($existeMoeda) {
            return redirect()->route('moedas.index')->with('error', 'Moeda já existe!');
        }

        // Create a new permission
        Moedas::create([
            'moeda' => $moeda,
            'abreviacao' => $abreviacao,
        ]);

        return redirect()->route('moedas.index')->with('success', 'Moeda cadastrado!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Moedas $moedas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Moedas $moedas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $moeda = Moedas::find($id);

        if (!$moeda) {
            return redirect()->back()->with('error', 'Moeda não encontrada!');
        }

        $moeda->moeda = ucfirst(trim($request->input('moeda')));
        $moeda->abreviacao = $request->input('abreviacao');

        $moeda->save();

        return redirect()->back()->with('success', 'Moeda Atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $moeda = Moedas::findOrFail($id);

        $moeda->delete();

        return redirect()->route('moedas.index')->with('success', 'Moeda excluída com sucesso!');
    }
}
