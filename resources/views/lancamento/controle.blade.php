@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <form method="GET" action="{{ route('lancamento.controle') }}" class="mb-2">
            <div class="row">
                <div class="col-md-3">
                    <label for="status_id" class="form-label">Status</label>
                    <select name="status_id" id="status_id" class="form-control">
                        <option value="">Todos</option>
                        @foreach ($status as $statusItem)
                            <option value="{{ $statusItem->id }}">{{ $statusItem->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="tipo_id" class="form-label">Tipo</label>
                    <select name="tipo_id" id="tipo_id" class="form-control">
                        <option value="">Todos</option>
                        @foreach ($tipos as $tipoItem)
                            <option value="{{ $tipoItem->id }}">{{ $tipoItem->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="user_id" class="form-label">Usuário</label>
                    <select name="user_id" id="user_id" class="form-control">
                        <option value="">Todos</option>
                        @foreach ($user as $userItem)
                            <option value="{{ $userItem->id }}">{{ $userItem->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </div>
        </form>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Controle dos Lançamentos</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr style="text-align: center">
                                <th>#</th>
                                <th>Data/Hora</th>
                                <th>Código</th>
                                <th>Valor</th>
                                <th>Tipo</th>
                                <th>Solicitante</th>
                                <th>Numero</th>
                                <th>Porcentagem</th>
                                <th>Lucro (USD)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalLucro = 0;
                            @endphp
                            @foreach ($lancamentos as $item)
                            <tr style="text-align: center">
                                <td>{{$item->id}}</td>
                                <td>{{$item->created_at}}</td>
                                @if ($item->status_id == 4)
                                    <td>{{ $item->codigo }}</td>
                                @else
                                    <td class="codigo-cell">{{ $item->codigo }}</td>
                                @endif
                                @php
                                    $abreviacao = $item->moeda->abreviacao;
                                    $valor = floatval($item->valor);

                                    // Converter o valor para USD se a moeda for BRL
                                    if ($abreviacao == 'BRL') {
                                        $valorConvertido = $valor * $cotacaoBRLtoUSD;
                                    } else {
                                        $valorConvertido = $valor; // Mantém o valor inalterado se não for BRL
                                    }

                                    // Calcular o lucro em USD
                                    $porcentagem = floatval($item->tipo->porcentagem);
                                    $lucro = $valorConvertido - ($valorConvertido * ($porcentagem / 100));

                                    // Acumular lucro total
                                    $totalLucro += $lucro;
                                @endphp
                                <td>{{ $abreviacao }} {{ number_format($valor, 2, ',', '.') }}</td>
                                <td>
                                    @if($item->imagem)
                                    <img src="images/{{ optional($item->tipo)->nome }}" alt="{{ optional($item->tipo)->nome }}"> {{ optional($item->tipo)->nome }}
                                    @else
                                    {{ optional($item->tipo)->nome }}
                                    @endif
                                </td>
                                <td>{{ $item->user ? $item->user->name : 'Usuário não encontrado' }}</td>
                                <td>{{ $item->user ? $item->user->celular : 'Celular não encontrado' }}</td>
                                <td>{{ $item->tipo->porcentagem }}%</td>
                                <td>
                                    @if(is_numeric($lucro))
                                        {{ number_format($lucro, 2, ',', '.') }} USD
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Mostrar o total dos lucros -->
                    <div class="mt-3">
                        <h5>Total dos Lucros: {{ number_format($totalLucro, 2, ',', '.') }} USD</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection




