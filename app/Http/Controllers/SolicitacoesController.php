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
        $solicitacoes = Solicitacoes::with('user', 'tipo')->get();
        return view('solicitacao.lista', compact('solicitacoes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function criar()
    {
        $tipos = Tipo::where('id', '<>', 3)->get();
        $solicitacoes = Solicitacoes::where('user_id', Auth::id())->with('tipo')->get();
        return view('solicitacao.criar', compact('tipos', 'solicitacoes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'mensagem' => 'required|string',
            'tipo_id' => 'required|exists:tipos,id',
        ]);

        $solicitacao = new Solicitacoes();
        $solicitacao->user_id = Auth::id();
        $solicitacao->titulo = $request->input('titulo');
        $solicitacao->mensagem = $request->input('mensagem');
        $solicitacao->tipo_id = $request->input('tipo_id');
        $solicitacao->save();

        return redirect()->route('solicitacoes.criar')->with('success', 'Solicitação salva com sucesso!');
    }

    /**
     * Update the specified resource in storage.
     */

     public function update(Request $request, $id)
     {
         $solicitacao = Solicitacoes::find($id);
 
         if (!$solicitacao) {
             return redirect()->back()->with('error', 'lançamento não encontrado!');
         }
 
         $solicitacao->resposta = $request->input('resposta');

 
         $solicitacao->save();
 
         return redirect()->back()->with('success', 'Resposta Atualizado com sucesso!');
     }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Solicitacoes $solicitacao)
    {
        $solicitacao->delete();
        return redirect()->route('solicitacoes.lista')->with('success', 'Solicitação excluída com sucesso!');
    }
}
