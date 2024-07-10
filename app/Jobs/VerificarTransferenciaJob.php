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
        \Log::info('Iniciando processamento do job...');
        
        $endTime = now()->addMinutes(10);
        \Log::info('Verificação de transações até: ' . $endTime->toDateTimeString());
    
        while (now()->lessThan($endTime)) {
            \Log::info('Verificando transações...');
    
            $transactions = app('App\Http\Controllers\TransferController')->getTrc20Transactions2();
            \Log::info('Total de transações recuperadas: ' . count($transactions));
    
            foreach ($transactions as $transaction) {
                \Log::info('Verificando transação: ', $transaction);
    
                if ($transaction['to'] === $this->transfer->to_address &&
                    $transaction['from'] === $this->transfer->from_address &&
                    $transaction['amount'] == $this->transfer->valor) {
                    
                    \Log::info('Transação encontrada. Atualizando status para "Disponível"');
                    $this->transfer->update(['status' => 'Disponível']);
                    return;
                }
            }
    
            \Log::info('Nenhuma transação encontrada. Aguardando 30 segundos antes de verificar novamente...');
            sleep(30); // Espera 30 segundos antes de verificar novamente
        }
    
        \Log::info('Tempo limite atingido. Atualizando status para "Indisponível".');
        $this->transfer->update(['status' => 'Indisponível']);
        \Log::info('Job processado com sucesso!');
    }
    
}
