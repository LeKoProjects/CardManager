@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <form method="GET" action="{{ route('lancamento.controle') }}" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <label for="status_id" class="form-label">Status</label>
                    <select name="status_id" id="status_id" class="form-control">
                        <option value="">Todos</option>
                        @foreach ($status as $statusItem)
                            <option value="{{ $statusItem->id }}">{{ $statusItem->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="tipo_id" class="form-label">Tipo</label>
                    <select name="tipo_id" id="tipo_id" class="form-control">
                        <option value="">Todos</option>
                        @foreach ($tipos as $tipoItem)
                            <option value="{{ $tipoItem->id }}">{{ $tipoItem->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
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
                            <tr>
                                <th>Código</th>
                                <th>Valor</th>
                                <th>Tipo</th>
                                <th>Solicitante</th>
                                <th>Numero</th>
                                <th>Porcentagem</th>
                                <th>Lucro</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lancamentos as $item)
                                <tr>
                                    <td>{{ $item->codigo }}</td>
                                    <td>{{ $item->moeda->abreviacao }} {{ $item->valor }}</td>
                                    <td>{{ $item->tipo->nome }}</td>
                                    <td>{{ $item->user ? $item->user->name : 'Usuário não encontrado' }}</td>
                                    <td>{{ $item->user ? $item->user->celular : 'Celular não encontrado' }}</td>
                                    <td>{{ $item->tipo->porcentagem }}%</td>
                                    <td>
                                        @php
                                            $valor = floatval($item->valor);
                                            $porcentagem = floatval($item->tipo->porcentagem);
                                        @endphp
                                        @if(is_numeric($valor) && is_numeric($porcentagem))
                                            {{ $valor + ($valor * ($porcentagem / 100)) }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
