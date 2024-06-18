@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Liberar Compras</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr style="text-align: center">
                                <th>#</th>
                                <th>Data/Hora</th>
                                <th>Código</th>
                                <th>Moeda</th>
                                <th>Valor</th>
                                <th>Tipo</th>
                                <th>Solicitante</th>
                                <th>Numero</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lancamento as $item)
                                <tr style="text-align: center">
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->created_at}}</td>
                                    @if ($item->status_id == 4)
                                        <td>{{ $item->codigo }}</td>
                                    @else
                                        <td class="codigo-cell">{{ $item->codigo }}</td>
                                    @endif
                                    <td>{{ $item->moeda->moeda }}</td>
                                    <td>{{ $item->moeda->abreviacao }} {{ $item->valor }}</td>
                                    <td>
                                        @if($item->imagem)
                                        <img src="images/{{ optional($item->tipo)->nome }}" alt="{{ optional($item->tipo)->nome }}"> {{ optional($item->tipo)->nome }}
                                        @else
                                        {{ optional($item->tipo)->nome }}
                                        @endif
                                    </td>
                                    <td>{{ $item->user ? $item->user->name : 'Usuário não encontrado' }}</td>
                                    <td>{{ $item->user ? $item->user->celular : 'Celular não encontrado' }}</td>
                                    <td>
                                        @if ($item->status_id == 4)
                                            Liberado
                                        @else
                                            <button class="btn btn-success change-status"
                                                data-lancamento-id="{{ $item->id }}">
                                                Liberar
                                            </button>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.change-status').click(function() {
                var lancamento_id = $(this).data('lancamento-id');

                $.ajax({
                    url: '{{ route('lancamentos.update-status') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status_id: 4,
                        lancamento_id: lancamento_id
                    },
                    success: function(response) {
                        alert(response.success);
                        location.reload(); // Reload the page to reflect the changes
                    },
                    error: function(xhr) {
                        alert('Erro: ' + xhr.responseJSON.error);
                    }
                });
            });
        });
    </script>
@endsection
