<?php

namespace App\Http\Controllers;

use App\Models\Lancamentos;
use App\Models\Moedas;
use App\Models\Status;
use App\Models\Tipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LancamentosExport;

class LancamentosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lancamento = Lancamentos::all();
        $moeda = Moedas::all();
        $tipo = Tipo::all();
        $status = Status::all();

        return view('lancamento.criar', compact(['lancamento', 'moeda', 'tipo', 'status']));
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
    $codigos = $request->input('codigo');
    $moedas = $request->input('moeda_id');
    $valores = $request->input('valor');
    $tipos = $request->input('tipo_id');

    foreach ($codigos as $index => $codigo) {
        $moeda = $moedas[$index];
        $valor = $valores[$index];
        $tipo = $tipos[$index];

        // Check if the lancamento already exists
        $existeLancamento = Lancamentos::where('codigo', $codigo)->first();

        if ($existeLancamento) {
            continue; // Skip existing lancamentos
        }

        // Create a new lancamento
        Lancamentos::create([
            'codigo' => $codigo,
            'moeda_id' => $moeda,
            'valor' => $valor,
            'tipo_id' => $tipo,
            'status_id' => 1,
        ]);
    }

    return redirect()->back()->with('success', 'Lançamentos cadastrados!');
}


    /**
     * Display the specified resource.
     */
    public function show(Lancamentos $lancamentos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lancamentos $lancamentos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $lancamento = Lancamentos::find($id);

        if (!$lancamento) {
            return redirect()->back()->with('error', 'lançamento não encontrado!');
        }

        $lancamento->codigo = $request->input('codigo');
        $lancamento->moeda_id = $request->input('moeda_id');
        $lancamento->tipo_id = $request->input('tipo_id');
        $lancamento->valor = $request->input('valor');
        $lancamento->status_id = $request->input('status_id');

        $lancamento->save();

        return redirect()->back()->with('success', 'Lançamento Atualizado com sucesso!');
    }

    public function updateStatus(Request $request)
    {
        $lancamento = Lancamentos::find($request->lancamento_id);

        $lancamento->status_id = $request->status_id;
        $lancamento->user_id = auth()->user()->id;
        $lancamento->save();

        return response()->json(['success' => 'Status atualizado com sucesso']);
    }

    public function updateStatus1(Request $request)
    {
        foreach ($request->lancamento_ids as $lancamento_id) {
            $lancamento = Lancamentos::find($lancamento_id);
            $lancamento->status_id = $request->status_id;
            $lancamento->user_id = auth()->user()->id;
            $lancamento->save();
        }

        return response()->json(['success' => 'Status atualizado com sucesso']);
    }

    public function exportarSelecionadosParaExcel(Request $request)
    {
        // Obtém os IDs dos lançamentos selecionados
        $lancamentosSelecionados = explode(',', $request->query('lancamentos'));

        // Remove IDs vazios ou não numéricos e mantém apenas IDs válidos
        $lancamentosIds = array_filter($lancamentosSelecionados, function($id) {
            return is_numeric($id) && intval($id) > 0; // Verifica se é numérico e maior que zero
        });

        // Verifica se há IDs válidos para prosseguir
        if (empty($lancamentosIds)) {
            // Retorna uma resposta de erro ou faz outra ação adequada
            return response()->json(['error' => 'Nenhum lançamento válido selecionado.'], 400);
        }

        // Inicia o download do arquivo Excel com os dados dos lançamentos selecionados
        return Excel::download(new LancamentosExport($lancamentosIds), 'lancamentos_selecionados.xlsx');
    }

    public function controle(Request $request)
    {
        $status_id = $request->input('status_id');
        $tipo_id = $request->input('tipo_id');

        $query = Lancamentos::query();

        if ($status_id) {
            $query->where('status_id', $status_id);
        }

        if ($tipo_id) {
            $query->where('tipo_id', $tipo_id);
        }

        $lancamentos = $query->get();
        $status = Status::all();
        $tipos = Tipo::all();

        return view('lancamento.controle', compact('lancamentos', 'status', 'tipos'));
    }

    public function listaUser()
    {
        // Obtém o ID do usuário logado
        $userId = Auth::id();

        // Filtra os lançamentos pelo usuário logado e exclui aqueles com status_id igual a 2
        $lancamento = Lancamentos::where('user_id', $userId)
            ->where('status_id', '!=', 1)
            ->get();

        return view('lancamento.listauser', compact('lancamento'));
    }

    public function listaLiberar()
    {
        $lancamento = Lancamentos::whereIn('status_id', [3, 4])->get();

        return view('lancamento.liberar', compact('lancamento'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lancamento = Lancamentos::findOrFail($id);

        $lancamento->delete();

        return redirect()->back()->with('success', 'Lançamento excluído com sucesso!');
    }
}
