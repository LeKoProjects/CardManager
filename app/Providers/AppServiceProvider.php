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
        $valorTotalUSD = $this->getWalletValue();
        $view->with(compact('valorTotalUSD'));
    });
}


public function getWalletValue()
{
    $user = Auth::user();
    $valorTotalUSD = 0;

    if ($user) {
        // Filtrar transferências do usuário com status "Disponível"
        $transfers = Transfer::where('user_id', $user->id)
            ->where('status', 'Disponível')
            ->get();

        // Somar os valores em USD
        $valorTotalUSD = $transfers->filter(function ($item) {
            return is_numeric($item->valor);
        })->sum('valor');
    }

    return $valorTotalUSD;
}
}
