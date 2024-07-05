@extends('layouts.app')

@section('content')
<body>
    <div class="container-fluid">
        {{-- @if(isset($wallet))
            <h3>Endereço: {{ $wallet->address }}</h3>
        @endif --}}
        <div class="row">
            <!-- Lista dos Tipos Card -->
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Transações</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            @if(isset($transactions))
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Time</th>
                                            <th>Amount</th>
                                            <th>Symbol</th>
                                            <th>From</th>
                                            <th>To</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($transactions as $transaction)
                                            <tr>
                                                <td>{{ $transaction['num'] }}</td>
                                                <td>{{ $transaction['time'] }}</td>
                                                <td>{{ $transaction['amount'] }}</td>
                                                <td>{{ $transaction['symbol'] }}</td>
                                                <td>{{ $transaction['from'] }}</td>
                                                <td>{{ $transaction['to'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
