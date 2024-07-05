<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use App\Models\Wallet;
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
        $user = Auth::user(); // Obtém o usuário autenticado
        $destino = Wallet::first(); // Obtém o primeiro endereço da tabela Wallet
        $transfers = Transfer::where('user_id', $user->id)->get(); // Busca as transferências do usuário autenticado
        return view('transferencia.transferenciaindex', compact(['transfers', 'destino']));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Obter o endereço da carteira com ID 1 (exemplo)
        $wallet = Wallet::find(1);

        // Verificar se o endereço na requisição corresponde ao endereço na tabela Wallet
        if ($wallet && $wallet->address !== $request->to_address) {
            return response()->json(['message' => 'Endereço de destino inválido'], 400);
        }

        // Criar uma nova instância de Transfer e salvar no banco de dados
        try {
            $transaction = new Transfer();
            $transaction->tx_id = $request->tx_id;
            $transaction->from_address = $request->from_address;
            $transaction->to_address = $request->to_address;
            $transaction->valor = $request->valor;
            $transaction->status = $request->status;
            $transaction->user_id = $user->id;
            $transaction->save();

            return response()->json(['message' => 'Transação armazenada com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao salvar transação: ' . $e->getMessage()], 500);
        }
    }


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

public function generateQRCode($address)
{
    $result = Builder::create()
        ->writer(new PngWriter())
        ->data($address)
        ->build();

    // Retornar a imagem do QR code como resposta
    return Response::make($result->getString(), 200, ['Content-Type' => 'image/png']);
}

}

