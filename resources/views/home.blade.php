@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Lançamentos </h6>
                    <div id="adquirir-button-container" style="display: none;">
                        <button id="adquirir-button" class="btn btn-primary">Adquirir</button>
                    </div>
                </div>
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
                                <th>Selecionar</th> <!-- Adicionando uma nova coluna -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lancamento as $item)
                                <tr style="text-align: center">
                                    <td class="codigo-cell">{{ $item->codigo }}</td>
                                    <td>{{ $item->moeda->moeda }}</td>
                                    <td>{{ $item->moeda->abreviacao }} {{ $item->valor }}</td>
                                    <td>{{ $item->tipo->nome }}</td>
                                    <td> <!-- Adicionando uma nova coluna com a caixa de seleção -->
                                        <input type="checkbox" class="select-lancamento" data-lancamento-id="{{ $item->id }}">
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

            // Função para tratar a seleção/deseleção dos lançamentos
            $('.select-lancamento').change(function() {
                var checked = $('.select-lancamento:checked').length > 0;
                if (checked) {
                    $('#adquirir-button-container').show();
                } else {
                    $('#adquirir-button-container').hide();
                }
            });

            // Adiciona ação para o botão de adquirir
            $('#adquirir-button').click(function() {
                var lancamento_ids = $('.select-lancamento:checked').map(function() {
                    return $(this).data('lancamento-id');
                }).get();

                $.ajax({
                    url: '{{ route('lancamentos.update-status1') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status_id: 2,
                        lancamento_ids: lancamento_ids
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
