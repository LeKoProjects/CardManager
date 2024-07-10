<?php

namespace App\Jobs;

use App\Models\Transfer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
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
        Log::info('Iniciando processamento do job para a transferência ID: ' . $this->transfer->id);
        $endTime = Carbon::now()->addMinutes(10);
        $transferCreatedAt = $this->transfer->created_at;
        $validEndTime = $transferCreatedAt->copy()->addMinutes(10);

        while (Carbon::now()->lessThan($endTime)) {
            $transactions = app('App\Http\Controllers\TransferController')->getTrc20Transactions2();

            foreach ($transactions as $transaction) {
                $transactionTime = Carbon::parse($transaction['time']);

                if ($transaction['to'] === $this->transfer->to_address &&
                    $transaction['from'] === $this->transfer->from_address &&
                    $transaction['amount'] == $this->transfer->valor &&
                    $transactionTime->between($transferCreatedAt, $validEndTime)) {
                    $this->transfer->update(['status' => 'Disponível']);
                    Log::info('Transação encontrada e status atualizado para Disponível para a transferência ID: ' . $this->transfer->id);
                    return;
                }
            }

            sleep(30); // Espera 30 segundos antes de verificar novamente
        }

        $this->transfer->update(['status' => 'Indisponível']);
        Log::info('Tempo esgotado. Status atualizado para Indisponível para a transferência ID: ' . $this->transfer->id);
    }
}
