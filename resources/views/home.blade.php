@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Lançamentos </h6>
                    <div class="mb-3 text-right">
                        <div class="d-inline-block" id="adquirir-button-container" style="display: none;">
                            <button id="adquirir-button" class="btn btn-primary">Adquirir</button>
                        </div>
                        <button id="select-all-button" class="btn btn-secondary d-inline-block ml-2">Selecionar Tudo</button>
                    </div>
                </div>
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
                                <th>Selecionar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lancamento as $lancamento)
                                <tr style="text-align: center">
                                    <td>{{$lancamento->id}}</td>
                                    <td>{{$lancamento->created_at}}</td>
                                    <td class="codigo-cell">{{ $lancamento->codigo }}</td>
                                    <td>{{ $lancamento->moeda->moeda }}</td>
                                    <td>{{ $lancamento->moeda->abreviacao }} {{ $lancamento->valor }}</td>
                                    <td>
                                        <img src="{{ asset('images/' . optional($lancamento->tipo)->imagem) }}"> {{ optional($lancamento->tipo)->nome }}
                                    </td>
                                    <td>
                                        <input type="checkbox" class="select-lancamento"
                                            data-lancamento-id="{{ $lancamento->id }}">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmação -->
    <div class="modal fade" id="confirmarModal" tabindex="-1" role="dialog" aria-labelledby="confirmarModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmarModalLabel">Confirmar Lançamentos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja adquirir os lançamentos selecionados?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary btn-confirmar-adquirir">Confirmar</button>
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

            // Ação para o botão Selecionar Tudo
            $('#select-all-button').click(function() {
                var allSelected = $('.select-lancamento').length === $('.select-lancamento:checked').length;
                $('.select-lancamento').prop('checked', !allSelected).trigger('change');
            });

            // Ação para abrir o modal de confirmação ao clicar em Adquirir
            $('#adquirir-button').click(function() {
                $('#confirmarModal').modal('show');
            });

            // Ação para confirmar adquirir os lançamentos
            $('.btn-confirmar-adquirir').click(function() {
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
                        //alert(response.success);
                        location.reload(); // Recarrega a página para refletir as alterações
                    },
                    error: function(xhr) {
                        alert('Erro ao adquirir os lançamentos.');
                    }
                });

                // Fecha o modal após a ação ser completada
                $('#confirmarModal').modal('hide');
            });
        });
    </script>
@endsection
