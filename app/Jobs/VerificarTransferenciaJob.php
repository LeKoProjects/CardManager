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
        // Define o tempo máximo para verificar transações
        $endTime = now()->addMinutes(1);

        // Variável para rastrear se a transferência foi encontrada
        $transferenciaEncontrada = false;

        // Loop para verificar as transações durante o tempo definido
        while (now()->lessThan($endTime)) {
            // Obtém as transações TRC-20 através de um método do controlador TransferController
            $transactions = app('App\Http\Controllers\TransferController')->getTrc20Transactions2();
            
            // Obtém o momento de criação da transferência
            $transferCreatedAt = $this->transfer->created_at;
            
            // Define um tempo final válido para a transferência
            $validEndTime = $transferCreatedAt->copy()->addMinutes(10);

            // Log para verificar as transações obtidas
            Log::info('Transações obtidas:', $transactions);

            // Itera sobre as transações obtidas
            foreach ($transactions as $transaction) {
                $transactionTime = Carbon::parse($transaction['time']);
                
                // Verifica se a transação satisfaz os critérios de validação
                if ($transaction['to'] === $this->transfer->to_address &&
                    $transaction['from'] === $this->transfer->from_address &&
                    $transaction['amount'] == $this->transfer->valor &&
                    $transactionTime->between($transferCreatedAt, $validEndTime)) {
                    
                    // Atualiza o status da transferência para 'Disponível'
                    $this->transfer->update(['status' => 'Disponível']);
                    
                    // Log informando que a transferência foi atualizada para 'Disponível'
                    Log::info('Transferência atualizada para Disponível:', ['transfer_id' => $this->transfer->id]);
                    
                    // Marca que a transferência foi encontrada
                    $transferenciaEncontrada = true;
                    break 2; // Sai do loop foreach e do loop while
                }
            }
        }

        // Se não encontrar uma transação válida dentro do tempo, atualiza o status para 'Indisponível'
        if (!$transferenciaEncontrada) {
            $this->transfer->update(['status' => 'Indisponível']);
            
            // Log informando que a transferência foi atualizada para 'Indisponível'
            Log::info('Transferência atualizada para Indisponível:', ['transfer_id' => $this->transfer->id]);
        }
    }
}
