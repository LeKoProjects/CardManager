<?php

namespace App\Http\Controllers;

use App\Jobs\CheckTransactionStatus;
use App\Jobs\VerificarTransferenciaJob;
use App\Models\Transfer;
use App\Models\Wallet;
use BaconQrCode\Encoder\QrCode;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Response;

class TransferController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $destino = Wallet::first();
        $transfers = Transfer::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        $lastTransfer = Transfer::where('user_id', $user->id)->orderBy('created_at', 'desc')->first();

        $remainingTime = 0;

        if ($lastTransfer) {
            $lastTransferTime = $lastTransfer->created_at;
            $now = now();
            $elapsedTime = $now->diffInSeconds($lastTransferTime);
            $remainingTime = max(0, 600 - $elapsedTime); // 600 seconds = 10 minutes
        }

        $destinoAddress = $destino->address;

        return view('transferencia.transferenciaindex', compact('transfers', 'destinoAddress', 'remainingTime'));
    }

    public function generateQRCode($address)
    {
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($address)
            ->build();

        // Retornar a imagem do QR code como resposta
        return Response::make($result->getString(), 200, ['Content-Type' => 'image/png']);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $to_address = $request->input('to_address');
        $from_address = $request->input('from_address');
        $valor = $request->input('valor');
        $createdAt = now();
    
        // Verificar se a transferência já existe com os mesmos valores e created_at
        $existeTransfer = Transfer::where('valor', $valor)
            ->where('to_address', $to_address)
            ->where('from_address', $from_address)
            ->where('created_at', $createdAt)
            ->first();
    
        if ($existeTransfer) {
            return redirect()->back()->with('error', 'Transferência já existe!');
        }
    
        // Criar uma nova transferência
        $transfer = Transfer::create([
            'to_address' => $to_address,
            'from_address' => $from_address,
            'valor' => $valor,
            'user_id' => $user->id,
            'status' => 'Em Andamento',
            'created_at' => $createdAt,
        ]);
    
        // Despachar o job para verificar a transação
        VerificarTransferenciaJob::dispatch($transfer);
    
        return redirect()->back()->with('success', 'Transferência cadastrada! Efetue a tranferência para o destinário informado e dentro de 10 minutos o valor será creditado.');
    }
    
    public function getTrc20Transactions2()
    {
        $num = 0;
        $wallet = Wallet::first();
        $accountId = $wallet->address;
        $url = "https://api.trongrid.io/v1/accounts/{$accountId}/transactions/trc20";
        $pages = 3;
    
        $params = [
            'only_confirmed' => true,
            'limit' => 20,
        ];
    
        $client = new Client([
            'headers' => ['accept' => 'application/json'],
            'verify' => false,
        ]);
    
        $transactions = [];
    
        for ($i = 0; $i < $pages; $i++) {
            $response = $client->get($url, ['query' => $params]);
            $responseBody = json_decode($response->getBody(), true);
    
            if (!isset($responseBody['data'])) {
                break;
            }
    
            $params['fingerprint'] = $responseBody['meta']['fingerprint'] ?? null;
    
            foreach ($responseBody['data'] as $tr) {
                $num++;
                $symbol = $tr['token_info']['symbol'] ?? '';
                $from = $tr['from'] ?? '';
                $to = $tr['to'] ?? '';
                $value = $tr['value'] ?? '';
                $decimals = -1 * intval($tr['token_info']['decimals'] ?? '6');
                $amount = floatval(substr($value, 0, $decimals) . '.' . substr($value, $decimals));
                $timestamp = floatval($tr['block_timestamp'] ?? '') / 1000;
                $time = Carbon::createFromTimestamp($timestamp);
    
                $transactions[] = [
                    'num' => $num,
                    'time' => $time->toDateTimeString(),
                    'amount' => $amount,
                    'symbol' => $symbol,
                    'from' => $from,
                    'to' => $to,
                ];
            }
    
            if (empty($params['fingerprint'])) {
                break;
            }
        }
    
        return $transactions;
    }
    
    // public function store(Request $request)
    // {
    //     $user = Auth::user();

    //     // Obter o endereço da carteira com ID 1 (exemplo)
    //     $wallet = Wallet::find(1);

    //     // Verificar se o endereço na requisição corresponde ao endereço na tabela Wallet
    //     if ($wallet && $wallet->address !== $request->to_address) {
    //         return response()->json(['message' => 'Endereço de destino inválido'], 400);
    //     }

    //     // Criar uma nova instância de Transfer e salvar no banco de dados
    //     try {
    //         $transaction = new Transfer();
    //         $transaction->tx_id = $request->tx_id;
    //         $transaction->from_address = $request->from_address;
    //         $transaction->to_address = $request->to_address;
    //         $transaction->valor = $request->valor;
    //         $transaction->status = $request->status;
    //         $transaction->user_id = $user->id;
    //         $transaction->save();

    //         return response()->json(['message' => 'Transação armazenada com sucesso'], 200);
    //     } catch (\Exception $e) {
    //         return response()->json(['message' => 'Erro ao salvar transação: ' . $e->getMessage()], 500);
    //     }
    // }


    public function index2()
    {
        $transfers = Transfer::all(); // Busca as transferências do usuário autenticado
        return view('transferencia.transferenciauser', compact('transfers'));
    }

    public function index3()
    {
        $wallet = Wallet::find(1); // Assumindo que você está pegando o primeiro registro. Ajuste conforme necessário.

        if ($wallet) {
            $transactions = $this->getTrc20Transactions($wallet->address);
            return view('transferencia.buscar', ['transactions' => $transactions, 'wallet' => $wallet]);
        } else {
            return view('transferencia.buscar', ['transactions' => [], 'wallet' => null]);
        }
    }

    private function getTrc20Transactions($accountId)
    {
        $num = 0;
        $url = "https://api.trongrid.io/v1/accounts/{$accountId}/transactions/trc20";
        $pages = 3;

        $params = [
            'only_confirmed' => true,
            'limit' => 20,
        ];

        $client = new Client([
            'headers' => ['accept' => 'application/json'],
            'verify' => false,
        ]);

        $transactions = [];

        for ($i = 0; $i < $pages; $i++) {
            $response = $client->get($url, ['query' => $params]);
            $responseBody = json_decode($response->getBody(), true);

            if (!isset($responseBody['data'])) {
                break;
            }

            $params['fingerprint'] = $responseBody['meta']['fingerprint'] ?? null;

            foreach ($responseBody['data'] as $tr) {
                $num++;
                $symbol = $tr['token_info']['symbol'] ?? '';
                $from = $tr['from'] ?? '';
                $to = $tr['to'] ?? '';
                $value = $tr['value'] ?? '';
                $decimals = -1 * intval($tr['token_info']['decimals'] ?? '6');
                $amount = floatval(substr($value, 0, $decimals) . '.' . substr($value, $decimals));
                $timestamp = floatval($tr['block_timestamp'] ?? '') / 1000;
                $time = Carbon::createFromTimestamp($timestamp);

                $transactions[] = [
                    'num' => $num,
                    'time' => $time->toDateTimeString(),
                    'amount' => $amount,
                    'symbol' => $symbol,
                    'from' => $from,
                    'to' => $to,
                ];
            }

            if (empty($params['fingerprint'])) {
                break;
            }
        }

        return $transactions;
    }

    

}

