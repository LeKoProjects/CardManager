@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Minhas Compras</h6>
            <div>
                <button class="btn btn-primary btn-selecionar-todos">Selecionar Tudo</button>
                <button class="btn btn-danger btn-pagar" data-toggle="modal" data-target="#confirmarModal">Desativar</button>
                <a href="{{ route('exportar.lancamentos.selecionados.excel') }}" class="btn btn-success btn-exportar-excel"><i class="fas fa-solid fa-file-excel"></i></a>
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
                            <th>Status</th>
                            <th>Selecionar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lancamento as $lancamento)
                        <tr style="text-align: center" class="{{ $lancamento->valido == 'N' ? 'red-row' : '' }}">
                            <td>{{ $lancamento->id }}</td>
                            <td>{{ $lancamento->created_at }}</td>
                            <td>
                                @if ($lancamento->status_id != 4)
                                    {{ substr($lancamento->codigo, 0, 5) . str_repeat('*', strlen($lancamento->codigo) - 5) }}
                                @else
                                    {{ $lancamento->codigo }}
                                @endif
                            </td>
                            <td>{{ $lancamento->moeda->moeda }}</td>
                            <td>{{ $lancamento->moeda->abreviacao }} {{ $lancamento->valor }}</td>
                            <td>
                                <img src="{{ asset('images/' . optional($lancamento->tipo)->imagem) }}"> {{ optional($lancamento->tipo)->nome }}
                            </td>
                            <td>
                                @if ($lancamento->valido == 'N')
                                <span style="color: red">Desativado</span>
                                @elseif ($lancamento->valido == 'S')
                                <span style="color: green">Ativado</span>
                                @endif
                            </td> 
                            <td>
                                <input type="checkbox" class="checkbox-select" data-lancamento-id="{{ $lancamento->id }}" data-status-id="{{ $lancamento->status_id }}">
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
                <h5 class="modal-title" id="confirmarModalLabel">Confirmar Invalidez</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Tem certeza que este(s) lançamento(s) já foram usados?
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
                return {
                    id: $(this).data('lancamento-id'),
                    status: $(this).data('status-id')
                };
            }).get();
        });

        // Ação para o botão Confirmar dentro do modal
        $('.btn-pagar-confirmar').click(function() {
            // Filtrar lançamentos com status 4
            var lancamentosParaAtualizar = lancamentosSelecionados.filter(function(lancamento) {
                return lancamento.status == 4;
            }).map(function(lancamento) {
                return lancamento.id;
            });

            if (lancamentosParaAtualizar.length > 0) {
                $.ajax({
                    url: '{{ route('lancamentos.update-status1') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        valido: 'N', // Status 3 = Aguardando Liberação
                        lancamento_ids: lancamentosParaAtualizar
                    },
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr) {
                        alert('Erro ao atualizar o status do lançamento.');
                    }
                });
            } else {
                alert('Nenhum lançamento válido selecionado para atualização.');
                $('#confirmarModal').modal('hide');
            }
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
