<?php

namespace App\Providers;

use App\Models\Transfer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
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

        if ($user) {
            $transfers = Transfer::where('user_id', $user->id)->get();

            $valorTotalRS = $transfers->filter(function ($item) {
                return is_numeric($item->valor) && $item->moeda === 'Real';
            })->sum('valor');

            $valorTotalUSD = $transfers->filter(function ($item) {
                return is_numeric($item->valor) && $item->moeda === 'Dolar';
            })->sum('valor');

            // Buscar a cotação do dólar
            $url = 'https://economia.awesomeapi.com.br/last/USD-BRL';
            $response = Http::withOptions(['verify' => false])->get($url);

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
