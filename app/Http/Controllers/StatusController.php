<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $status = Status::all();

        return view('cadastro.status', compact('status'));
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
        $status = ucfirst(trim($request->input('nome')));

        // Check if the permission already exists
        $existeStatus = Status::where('nome', $status)->first();

        if ($existeStatus) {
            return redirect()->route('status.index')->with('error', 'Status já existe!');
        }

        // Create a new permission
        Status::create([
            'nome' => $status,
        ]);

        return redirect()->route('status.index')->with('success', 'Status cadastrado!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Status $status)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Status $status)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $status = Status::find($id);

        if (!$status) {
            return redirect()->back()->with('error', 'Status não encontrada!');
        }

        $status->nome = ucfirst(trim($request->input('nome')));

        $status->save();

        return redirect()->back()->with('success', 'Status Atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $status = Status::findOrFail($id);

        $status->delete();

        return redirect()->route('status.index')->with('success', 'Status excluída com sucesso!');
    }
}
