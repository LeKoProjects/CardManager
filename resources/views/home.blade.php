@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Lançamentos</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr style="text-align: center">
                                <th>Código</th>
                                <th>Moeda</th>
                                <th>Valor</th>
                                <th>Tipo</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lancamento as $item)
                                <tr style="text-align: center">
                                    <td class="codigo-cell">{{ $item->codigo }}</td>
                                    <td>{{ $item->moeda->moeda }}</td>
                                    <td>{{ $item->moeda->abreviacao }} {{ $item->valor }}</td>
                                    <td>{{ $item->tipo->nome }}</td>
                                    <td>
                                        <button class="btn btn-danger change-status" data-lancamento-id="{{ $item->id }}">
                                            Adquirir
                                        </button>
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
                        status_id: 2,
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
