<?php

namespace App\Http\Controllers;

use App\Models\Tipo;
use Illuminate\Http\Request;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;


class TipoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipo = Tipo::orderBy('created_at', 'desc')->get();


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
    $tipo = ucfirst(trim($request->input('nome')));
    $porcentagem = $request->input('porcentagem');
    $imagem = $request->file('imagem');

    if ($imagem && $imagem->isValid()) {
        $filenameWithExt = $imagem->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $imagem->getClientOriginalExtension();
        $imageName = $filename . '.' . $extension;

        // Usando Imagine para redimensionar a imagem
        $imagine = new Imagine();
        $image = $imagine->open($imagem->getPathname());
        $image->resize(new Box(35, 35))
              ->save(public_path('images/') . $imageName);

        $tipo = Tipo::create([
            'nome' => $tipo,
            'porcentagem' => $porcentagem,
            'imagem' => $imageName,
        ]);
    } else {
        $tipo = Tipo::create([
            'nome' => $tipo,
            'porcentagem' => $porcentagem,
        ]);
    }

    return redirect()->route('tipo.index')->with('success', 'Tipo cadastrado!');
}

public function update(Request $request, $id)
{
    $tipo = Tipo::find($id);

    if (!$tipo) {
        return redirect()->back()->with('error', 'Tipo não encontrada!');
    }

    $nome = ucfirst(trim($request->input('nome')));
    $porcentagem = $request->input('porcentagem');
    $imagem = $request->file('imagem');

    if ($imagem && $imagem->isValid()) {
        $filenameWithExt = $imagem->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $imagem->getClientOriginalExtension();
        $imageName = $filename . '.' . $extension;

        // Usando Imagine para redimensionar a imagem
        $imagine = new Imagine();
        $image = $imagine->open($imagem->getPathname());
        $image->resize(new Box(35, 35))
              ->save(public_path('images/') . $imageName);

        // Remover a imagem antiga se existir
        if ($tipo->imagem && file_exists(public_path('images/') . $tipo->imagem)) {
            unlink(public_path('images/') . $tipo->imagem);
        }

        // Atualizar o tipo com a nova imagem
        $tipo->imagem = $imageName;
        $tipo->nome = $nome;
        $tipo->porcentagem = $porcentagem;
    } else {
        $tipo->nome = $nome;
        $tipo->porcentagem = $porcentagem;
    }

    $tipo->save();

    return redirect()->back()->with('success', 'Tipo atualizado com sucesso!');
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
