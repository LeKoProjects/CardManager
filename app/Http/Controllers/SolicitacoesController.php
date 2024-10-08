<?php

namespace App\Http\Controllers;

use App\Models\Lancamentos;
use App\Models\Moedas;
use App\Models\Solicitacoes;
use App\Models\Status;
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
        $lancamentos = Lancamentos::whereNotNull('solicitacao_id')->get(); // Pagina com 10 itens por página
        $moeda = Moedas::all();
        $status = Status::all();
        $users = User::all();
        $tipos = Tipo::where('id', '<>', 3, )->get();
        $solicitacoes = Solicitacoes::with('user', 'tipo')->orderBy('created_at', 'asc')->get();
        return view('solicitacao.lista', compact(['tipos', 'solicitacoes', 'lancamentos', 'moeda', 'status', 'users']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function criar()
    {
        $lancamentos = Lancamentos::whereNotNull('solicitacao_id')->get();
        $tipos = Tipo::where('id', '<>', 3)->get();
        $solicitacoes = Solicitacoes::where('user_id', Auth::id())->with('tipo')->get();
        return view('solicitacao.criar', compact('tipos', 'solicitacoes', 'lancamentos'));
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
        $solicitacao->quantidade = $request->input('quantidade');
        $solicitacao->tipo_id = $request->input('tipo_id');
        $solicitacao->save();

        return redirect()->route('solicitacoes.criar')->with('success', 'Solicitação salva com sucesso!');
    }

    /**
     * Update the specified resource in storage.
     */

     public function update(Request $request, $id)
     {
         // Atualiza a solicitação com a resposta
         $solicitacao = Solicitacoes::find($id);
         if (!$solicitacao) {
             return response()->json(['error' => 'Solicitação não encontrada!'], 404);
         }
     
         $solicitacao->resposta = $request->input('resposta');
         $solicitacao->save();
     
         // Agora trata os lançamentos
         $validatedData = $request->validate([
             'codigo.*' => 'required|string',
             'moeda_id.*' => 'required|integer|not_in:0',
             'valor.*' => 'required|string',
             'tipo_id.*' => 'required|integer|not_in:0',
         ]);
     
         $codigos = $validatedData['codigo'];
         $moedas = $validatedData['moeda_id'];
         $valores = $validatedData['valor'];
         $tipos = $validatedData['tipo_id'];
     
         foreach ($codigos as $index => $codigo) {
             $moeda = $moedas[$index];
             $valor = $valores[$index];
             $tipo = $tipos[$index];
     
             // Verificar se o lançamento já existe
             $existeLancamento = Lancamentos::where('codigo', $codigo)->first();
             if ($existeLancamento) {
                 return response()->json(['error' => 'Lançamento já existe!'], 400);
             }
     
             // Criar um novo lançamento
             Lancamentos::create([
                 'codigo' => $codigo,
                 'moeda_id' => $moeda,
                 'valor' => $valor,
                 'tipo_id' => $tipo,
                 'solicitacao_id' => $solicitacao->id,
                 'user_id' => $solicitacao->user_id,
             ]);
         }
     
         return redirect()->back()->with('success', 'Resposta e lançamentos salvos com sucesso!');
     }
     

    public function updateStatus(Request $request, $id)
    {
        // Encontre a solicitação pelo ID
        $solicitacao = Solicitacoes::find($id);
    
        if (!$solicitacao) {
            return response()->json(['error' => 'Solicitação não encontrada!'], 404);
        }
    
        // Atualiza o status com o valor recebido do request
        $solicitacao->status = $request->input('status');
        $solicitacao->save();
    
        // Redireciona de volta à página anterior com mensagem de sucesso
        return redirect()->back()->with('success', 'Status atualizado com sucesso!');
    }
    


    public function store2(Request $request)
    {
        $messages = [
            'codigo.*.required' => 'O campo código é obrigatório.',
            'moeda_id.*.required' => 'O campo moeda é obrigatório.',
            'moeda_id.*.integer' => 'O campo moeda deve ser selecionado.',
            'moeda_id.*.not_in' => 'Por favor, selecione uma moeda válida.',
            'valor.*.required' => 'O campo valor é obrigatório.',
            'valor.*.numeric' => 'O campo valor deve ser numérico.',
            'tipo_id.*.required' => 'O campo tipo é obrigatório.',
            'tipo_id.*.integer' => 'O campo tipo deve ser um número inteiro.',
            'tipo_id.*.not_in' => 'Por favor, selecione um tipo válido.',
            'user_id.*.integer' => 'O campo usuário deve ser um número inteiro.',
            'solicitacao_id.*.integer' => 'O campo usuário deve ser um número inteiro.',
        ];
    
        $validatedData = $request->validate([
            'codigo.*' => 'required|string',
            'moeda_id.*' => 'required|integer|not_in:0',
            'valor.*' => 'required|string',
            'tipo_id.*' => 'required|integer|not_in:0',
            'user_id.*' => 'nullable|integer',
            'solicitacao_id.*' => 'nullable|integer',
        ], $messages);
        $codigos = $validatedData['codigo'];
        $moedas = $validatedData['moeda_id'];
        $valores = $validatedData['valor'];
        $tipos = $validatedData['tipo_id'];
        $users = $validatedData['user_id'];
        $solicitacaos = $validatedData['solicitacao_id'];
    
        foreach ($codigos as $index => $codigo) {
            $moeda = $moedas[$index];
            $valor = $valores[$index];
            $tipo = $tipos[$index];
            $solicitacao = $solicitacaos[$index];
            $user = $users[$index]; // Verificar se o usuário está definido
    
            // Verificar se o lançamento já existe
            $existeLancamento = Lancamentos::where('codigo', $codigo)->first();
            if ($existeLancamento) {
                return response()->json(['error' => 'Lançamento já existe!'], 400);
            }
            // Create a new lancamento
            Lancamentos::create([
                'codigo' => $codigo,
                'moeda_id' => $moeda,
                'valor' => $valor,
                'tipo_id' => $tipo,
                'user_id' => $user,
                'solicitacao_id' => $solicitacao,
                'status_id' => 4,
                'valido' => 'S',
            ]);
        }
    
        return response()->json(['success' => 'Lançamentos cadastrados com sucesso!']);
    }
    
    public function getLancamentos($id)
    {
        $lancamentos = Lancamentos::where('solicitacao_id', $id)->get();
        return view('solicitacao.lista', compact(['lancamentos']));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Solicitacoes $solicitacao)
    {
        $solicitacao->delete();
        return redirect()->back()->with('success', 'Solicitação excluída com sucesso!');
    }
}
