@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Minhas Compras</h6>
            <div>
                <button class="btn btn-primary btn-selecionar-todos">Selecionar Tudo</button>
                <button class="btn btn-danger btn-pagar" data-toggle="modal" data-target="#confirmarModal">Pagar</button>
                <a href="{{ route('exportar.lancamentos.selecionados.excel') }}" class="btn btn-success btn-exportar-excel"><i class="fas fa-solid fa-file-excel"></i></a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr style="text-align: center">
                            <th>Selecionar</th>
                            <th>Código</th>
                            <th>Moeda</th>
                            <th>Valor</th>
                            <th>Tipo</th>
                            <th>Status</th> <!-- Adicionei Status como cabeçalho da coluna -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lancamento as $lancamento)
                        <tr style="text-align: center">
                            <!-- Mostra checkbox apenas se o status permitir -->
                            @if ($lancamento->status_id != 3 && $lancamento->status_id != 4)
                            <td>
                                <input type="checkbox" class="checkbox-select" data-lancamento-id="{{ $lancamento->id }}">
                            </td>
                            @else
                            <td></td>
                            @endif
                            <td>{{ $lancamento->codigo }}</td>
                            <td>{{ $lancamento->moeda->moeda }}</td>
                            <td>{{ $lancamento->moeda->abreviacao }} {{ $lancamento->valor }}</td>
                            <td>{{ $lancamento->tipo->nome }}</td>
                            <td>
                                @if ($lancamento->status_id == 2)
                                Aguardando Pagamento
                                @elseif ($lancamento->status_id == 3)
                                Aguardando Liberação
                                @elseif ($lancamento->status_id == 4)
                                Adquirido
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

<!-- Modal -->
<div class="modal fade" id="confirmarModal" tabindex="-1" role="dialog" aria-labelledby="confirmarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmarModalLabel">Confirmar Pagamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Tem certeza que deseja pagar este lançamento?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success btn-pagar-confirmar">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {

        var lancamentosSelecionados = []; // Variável global para armazenar IDs selecionados

        // Ação para o botão Pagar dentro do modal
        $('.btn-pagar').click(function() {
            lancamentosSelecionados = $('.checkbox-select:checked').map(function() {
                return $(this).data('lancamento-id');
            }).get();

            $('#confirmarModal').modal('show');
            $('#confirmarModal').data('lancamento-id', lancamentosSelecionados);
        });

        // Ação para o botão Confirmar dentro do modal
        $('.btn-pagar-confirmar').click(function() {
            var lancamento_id = $('#confirmarModal').data('lancamento-id');

            $.ajax({
                url: '{{ route('lancamentos.update-status1') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status_id: 3, // Status 3 = Aguardando Liberação
                    lancamento_ids: lancamento_id
                },
                success: function(response) {
                    alert(response.success);
                    location.reload();
                },
                error: function(xhr) {
                    alert('Erro ao atualizar o status do lançamento.');
                }
            });
        });

        // Ação para o botão Selecionar Tudo
        $('.btn-selecionar-todos').click(function() {
            $('.checkbox-select').prop('checked', true);
            atualizarLinkExportacao();
        });

        // Ação para desmarcar todos os checkboxes
        $('.checkbox-select').change(function() {
            atualizarLinkExportacao();
        });

        // Função para atualizar o link do botão de exportar Excel com os IDs selecionados
        function atualizarLinkExportacao() {
            lancamentosSelecionados = $('.checkbox-select:checked').map(function() {
                return $(this).data('lancamento-id');
            }).get();

            var linkExportacao = '{{ route("exportar.lancamentos.selecionados.excel") }}';

            if (lancamentosSelecionados.length > 0) {
                linkExportacao += '?lancamentos=' + lancamentosSelecionados.join(',');
            }

            $('.btn-exportar-excel').attr('href', linkExportacao);
        }

    });
</script>
@endsection
