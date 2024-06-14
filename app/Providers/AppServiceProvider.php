<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Lancamentos;
use App\Models\Moedas;
use Illuminate\Support\Facades\Http;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer('layouts.header', function ($view) {
            $user = Auth::user();
            $valorTotalUSD = 0;
            $moeda = Moedas::all();
            
            if ($user) {
                $lancamentos = Lancamentos::where('user_id', $user->id)
                    ->where('status_id', '!=', 4) // Supondo que o status 'Adquirido' tem o ID 4
                    ->get();

                $valorTotalRS = $lancamentos->where('moeda.moeda', 'Real')->sum('valor');
                $valorTotalUSD = $lancamentos->where('moeda.moeda', 'Dolar')->sum('valor');

                // Buscar a cotação do dólar
                $url = 'https://economia.awesomeapi.com.br/last/USD-BRL';
                $response = Http::get($url);

                if ($response->successful()) {
                    $cotacao = $response->json()['USDBRL']['bid'];

                    // Converter o valor em reais para dólares
                    if ($valorTotalRS > 0) {
                        $valorTotalUSD += $valorTotalRS / $cotacao;
                    }
                }
            }

            $view->with(compact('valorTotalUSD'));
        });
    }
    }
