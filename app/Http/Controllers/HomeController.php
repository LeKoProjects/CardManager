<?php

namespace App\Http\Controllers;

use App\Models\Lancamentos;
use App\Models\Moedas;
use App\Models\Status;
use App\Models\Tipo;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $lancamento = Lancamentos::where('status_id', '=', 1)->get();
        $moeda = Moedas::all();
        $tipo = Tipo::all();
        $status = Status::all();

        return view('home', compact(['lancamento', 'moeda', 'tipo', 'status']));
    }
}
