<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $usuario = User::orderBy('created_at', 'desc')->get();
        return view('cadastro.usuario', compact('usuario'));
    }

    // Método store
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
        'tipo' => 'required|integer',
        'celular' => 'required|string|max:20',
    ]);

    User::create([
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
        'password' => Hash::make($validatedData['password']),
        'tipo' => $validatedData['tipo'],
        'celular' => $validatedData['celular'],
    ]);

    return redirect()->route('usuario.index')->with('success', 'Usuário criado com sucesso');
}


// Método update
public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:8|confirmed',
        'tipo' => 'required|integer',
        'celular' => 'required|string|max:255'
    ]);

    $user->name = $request->name;
    $user->celular = $request->celular;
    $user->email = $request->email;
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }
    $user->tipo = $request->tipo;
    $user->save();

    return redirect()->route('usuario.index')->with('success', 'Usuário atualizado com sucesso');
}

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('usuario.index')->with('success', 'Usuário excluído com sucesso');
    }
}

