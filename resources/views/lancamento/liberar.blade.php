@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Liberar Compras</h6>
                <div>
                    <button type="button" class="btn btn-info" id="selectAllButton">Selecionar Tudo</button>
                    <button type="button" class="btn btn-success" id="liberarButton" style="display: none;">Liberar</button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr style="text-align: center">
                                <th>Selecionar</th>
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
                                    <td><input type="checkbox" class="selectRow" data-id="{{ $item->id }}"></td>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    @if ($item->status_id == 4)
                                        <td>{{ $item->codigo }}</td>
                                    @else
                                        <td class="codigo-cell">{{ $item->codigo }}</td>
                                    @endif
                                    <td>{{ $item->moeda->moeda }}</td>
                                    <td>{{ $item->moeda->abreviacao }} {{ $item->valor }}</td>
                                    <td>
                                        <img src="{{ asset('images/' . optional($item->tipo)->imagem) }}"> {{ optional($item->tipo)->nome }}
                                    </td>
                                    <td>{{ $item->user ? $item->user->name : 'Usuário não encontrado' }}</td>
                                    <td>{{ $item->user ? $item->user->celular : 'Celular não encontrado' }}</td>
                                    <td>
                                        @if ($item->status_id == 4)
                                            Liberado
                                        @else
                                            Pendente
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
            $('#selectAllButton').on('click', function() {
                const allChecked = $('.selectRow').length === $('.selectRow:checked').length;
                $('.selectRow').prop('checked', !allChecked);
                toggleLiberarButton();
            });

            $('.selectRow').on('change', function() {
                toggleLiberarButton();
            });

            function toggleLiberarButton() {
                if ($('.selectRow:checked').length > 0) {
                    $('#liberarButton').show();
                } else {
                    $('#liberarButton').hide();
                }
            }

            $('#liberarButton').on('click', function() {
                liberarSelecionados();
            });

            function liberarSelecionados() {
                const selectedIds = $('.selectRow:checked').map(function() {
                    return $(this).data('id');
                }).get();

                if (selectedIds.length > 0) {
                    $.ajax({
                        url: '{{ route('lancamentos.update-status') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            status_id: 4,
                            lancamento_ids: selectedIds
                        },
                        success: function(response) {
                            alert(response.success);
                            location.reload();
                        },
                        error: function(xhr) {
                            alert('Erro: ' + xhr.responseJSON.error);
                        }
                    });
                }
            }
        });
    </script>
@endsection
