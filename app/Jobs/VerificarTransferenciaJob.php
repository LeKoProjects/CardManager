<?php

namespace App\Jobs;

use App\Models\Transfer;
use App\Http\Controllers\YourController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class VerificarTransferenciaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $transfer;

    public function __construct(Transfer $transfer)
    {
        $this->transfer = $transfer;
    }

    public function handle()
    {
        $endTime = now()->addMinutes(1);

        while (now()->lessThan($endTime)) {
            $transactions = app('App\Http\Controllers\TransferController')->getTrc20Transactions2();

            foreach ($transactions as $transaction) {
                if ($transaction['to'] === $this->transfer->to_address &&
                    $transaction['from'] === $this->transfer->from_address &&
                    $transaction['amount'] == $this->transfer->valor) {
                    $this->transfer->update(['status' => 'Disponível']);
                    return;
                }
            }

            sleep(30); // Espera 30 segundos antes de verificar novamente
        }

        $this->transfer->update(['status' => 'Indisponível']);
    }
}
