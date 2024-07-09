<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function showDashboard(){
        $userId = Auth::user();
        //ADMIN
            $totalUsers = DB::table('users')->count();
            $totalGiftsNaoComprados = DB::table('lancamentos')->where('status_id', 1)->count();
            $totalGifts = DB::table('lancamentos')->count();
            $totalGiftsComprados1 = DB::table('lancamentos')->where('status_id', 4)->count();
            $totalGiftsReservados1 = DB::table('lancamentos')->where('status_id', 5)->count();
            $totalGiftsDividas1 = DB::table('lancamentos')
                ->join('users', 'lancamentos.user_id', '=', 'users.id')
                ->select('users.name', DB::raw('SUM(CAST(lancamentos.valor AS NUMERIC)) as total'))
                ->where('lancamentos.tipo_id', 3)
                ->groupBy('users.name')
                ->get();
            $totalGiftsCompradosPorMes1 = DB::table('lancamentos')
                ->select(DB::raw('EXTRACT(MONTH FROM created_at) as month'), DB::raw('SUM(CAST(valor AS NUMERIC)) as total'))
                ->where('status_id', 4)
                ->groupBy(DB::raw('EXTRACT(MONTH FROM created_at)'))
                ->orderBy(DB::raw('EXTRACT(MONTH FROM created_at)'))
                ->pluck('total', 'month')
                ->toArray();
            $countByTipo1 = DB::table('lancamentos')
                ->join('tipos', 'lancamentos.tipo_id', '=', 'tipos.id')
                ->select('tipos.nome', DB::raw('count(*) as total'))
                ->groupBy('tipos.id', 'tipos.nome')
                ->pluck('total', 'tipos.nome')
                ->toArray();
        //ENDADMIN
        
        //USER
            $totalGiftsComprados = DB::table('lancamentos')->where('status_id', 4)->where('user_id', $userId->id)->count();
            $totalGiftsReservados = DB::table('lancamentos')->where('status_id', 5)->where('user_id', $userId->id)->count();
            $totalGiftsDividas = DB::table('lancamentos')->where('tipo_id', 3)->where('user_id', $userId->id)->sum(DB::raw('CAST(valor AS NUMERIC)'));
            $totalGiftsCompradosPorMes = DB::table('lancamentos')
                ->select(DB::raw('EXTRACT(MONTH FROM created_at) as month'), DB::raw('SUM(CAST(valor AS NUMERIC)) as total'))
                ->where('status_id', 4)
                ->where('user_id', $userId->id)
                ->groupBy(DB::raw('EXTRACT(MONTH FROM created_at)'))
                ->orderBy(DB::raw('EXTRACT(MONTH FROM created_at)'))
                ->pluck('total', 'month')
                ->toArray();
            $countByTipo = DB::table('lancamentos')
                ->join('tipos', 'lancamentos.tipo_id', '=', 'tipos.id')
                ->select('tipos.nome', 'tipos.porcentagem', DB::raw('count(*) as total'))
                ->where('lancamentos.user_id', $userId->id)
                ->groupBy('tipos.id', 'tipos.nome', 'tipos.porcentagem')
                ->pluck('total', 'tipos.nome')
                ->toArray();
        //ENDUSER


        return view('dashboard.dashboard', compact([
            'totalGiftsNaoComprados',
            'totalGiftsComprados1',
            'totalGiftsComprados',
            'totalGiftsReservados',
            'totalGiftsDividas',
            'totalGiftsReservados1',
            'totalGiftsDividas1',
            'totalGiftsCompradosPorMes',
            'countByTipo',
            'totalGiftsCompradosPorMes1',
            'countByTipo1',
            'totalGifts',
            'totalUsers',
            'totalGiftsComprados',
            'totalGiftsReservados',
            'totalGiftsDividas',
            'totalGiftsCompradosPorMes',
            'countByTipo',
        ]));
    }
}
