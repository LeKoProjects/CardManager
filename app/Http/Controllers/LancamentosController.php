<?php

namespace App\Http\Controllers;

use App\Models\Lancamentos;
use App\Models\Moedas;
use App\Models\Status;
use App\Models\Tipo;
use Illuminate\Http\Request;

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
        // Capitalize the input
        $codigo = $request->input('codigo');
        $moeda = $request->input('moeda_id');
        $valor = $request->input('valor');
        $tipo = $request->input('tipo_id');

        // Check if the permission already exists
        $existeLancamento = Lancamentos::where('codigo', $codigo)->first();

        if ($existeLancamento) {
            return redirect()->back()->with('error', 'Lançamento já existe!');
        }

        // Create a new permission
        Lancamentos::create([
            'codigo' => $codigo,
            'moeda_id' => $moeda,
            'valor' => $valor,
            'tipo_id' => $tipo,
            'status_id' => 1,
        ]);

        return redirect()->back()->with('success', 'Lançamento cadastrado!');
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

        if ($lancamento) {

            if (auth()->user()->tipo = 2 && $request->status_id != 2) {
                return response()->json(['error' => 'Você não tem permissão para alterar para este status'], 403);
            }

            if ($lancamento->user_id) {
                return response()->json(['error' => 'Lançamento já alterado'], 403);
            }

            $lancamento->status_id = $request->status_id;
            $lancamento->user_id = auth()->user()->id; // Assumindo que você tem uma coluna 'updated_by' para armazenar o ID do usuário que fez a atualização
            $lancamento->save();

            return response()->json(['success' => 'Status atualizado com sucesso']);
        }

        return response()->json(['error' => 'Lançamento não encontrado'], 404);
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
