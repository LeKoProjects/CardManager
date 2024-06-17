<?php

namespace App\Http\Controllers;

use App\Models\Solicitacoes;
use App\Models\Tipo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolicitacoesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipo = Tipo::all();
        $solicitacoes = Solicitacoes::with('user', 'tipo')->get();
        return view('solicitacao.lista', compact('solicitacoes', 'tipo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function criar()
    {
        $tipos = Tipo::where('id', '<>', 3)->get();
        return view('solicitacao.criar', compact('tipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'mensagem' => 'required|string',
            'tipo_id' => 'required|exists:tipos,id',
        ]);

        $solicitacao = new Solicitacoes();
        $solicitacao->user_id = Auth::id(); // Assumindo que o usuário está autenticado
        $solicitacao->titulo = $request->input('titulo');
        $solicitacao->mensagem = $request->input('mensagem');
        $solicitacao->tipo_id = $request->input('tipo_id');
        $solicitacao->save();

        return redirect()->route('solicitacoes.criar')->with('success', 'Solicitação salva com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(solicitacoes $solicitacoes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(solicitacoes $solicitacoes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, solicitacoes $solicitacoes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(solicitacoes $solicitacoes)
    {
        //
    }
}
