@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="container-fluid">
            <!-- DataTales Example -->
            <div class="row">
                <!-- Lista dos Tipos Card -->
                <div class="col-md-12">
                    <div class="card shadow mb-7">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Lista dos Lançamentos</h6>
                            <div>
                                <button type="button" class="btn btn-info" id="selectAllButton">Selecionar Tudo</button>
                                <button type="button" class="btn btn-warning" id="reserveButton"
                                    style="display: none;">Reservar</button>
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
                                            <th>Status</th>
                                            <th>Editar</th>
                                            <th>Excluir</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-body">
                                        @foreach ($lancamento as $item)
                                            <tr style="text-align: center"
                                                class="{{ $item->valido == 'N' ? 'red-row' : '' }}">
                                                <td><input type="checkbox" class="selectRow" data-id="{{ $item->id }}">
                                                </td>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->created_at }}</td>
                                                <td>{{ $item->codigo }}</td>
                                                <td>{{ $item->moeda->moeda }}</td>
                                                <td>{{ $item->valor }}</td>
                                                <td>
                                                    <img src="images/{{ optional($item->tipo)->imagem }}">
                                                    {{ optional($item->tipo)->nome }}
                                                </td>
                                                <td>
                                                    @if ($item->status_id == 1)
                                                        <span style="color: blue">Novo</span>
                                                    @elseif ($item->status_id == 2)
                                                        <span style="color: red">Pendente</span>
                                                    {{-- @elseif ($item->status_id == 3)
                                                        <span style="color: orange">Aguardando Liberação</span> --}}
                                                    @elseif ($item->status_id == 4)
                                                        <span style="color: green">Finalizado</span>
                                                    @elseif ($item->status_id == 5)
                                                        <span style="color: purple">Reservado</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div>
                                                        <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                                            data-bs-target="#editModal{{ $item->id }}">
                                                            Editar
                                                        </button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <form action="{{ route('lancamento.destroy', $item->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Excluir</button>
                                                    </form>
                                                </td>
                                            </tr>

                                            <!-- Modal for Editing -->
                                            <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
                                                aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel{{ $item->id }}">
                                                                Editar
                                                                Lançamento</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST"
                                                                action="{{ route('lancamento.update', $item->id) }}"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="row">
                                                                    <div class="mb-3 col-md-12">
                                                                        <label class="form-label">Código</label>
                                                                        <input name="codigo"
                                                                            id="codigo{{ $item->id }}"
                                                                            class="form-control" type="text"
                                                                            placeholder="" value="{{ $item->codigo }}">
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="mb-3 col-md-3">
                                                                        <label class="form-label">Moeda</label>
                                                                        <select class="form-control"
                                                                            id="moeda_id{{ $item->id }}"
                                                                            name="moeda_id">
                                                                            <option selected></option>
                                                                            @foreach ($moeda as $moedas)
                                                                                <option value="{{ $moedas->id }}"
                                                                                    {{ $item->moeda_id == $moedas->id ? 'selected' : '' }}>
                                                                                    {{ $moedas->moeda }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3 col-md-3">
                                                                        <label class="form-label">Valor</label>
                                                                        <input name="valor"
                                                                            id="valor{{ $item->id }}"
                                                                            class="form-control valor" type="text"
                                                                            placeholder="" value="{{ $item->valor }}">
                                                                    </div>
                                                                    <div class="mb-3 col-md-3">
                                                                        <label class="form-label">Tipo</label>
                                                                        <select class="form-control"
                                                                            id="tipo_id{{ $item->id }}"
                                                                            name="tipo_id">
                                                                            <option selected></option>
                                                                            @foreach ($tipo as $tipos)
                                                                                <option value="{{ $tipos->id }}"
                                                                                    {{ $item->tipo_id == $tipos->id ? 'selected' : '' }}>
                                                                                    {{ $tipos->nome }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3 col-md-3">
                                                                        <label class="form-label">Válido</label>
                                                                        <select class="form-control"
                                                                            id="valido{{ $item->id }}"
                                                                            name="valido">
                                                                            <option value="S"
                                                                                {{ $item->valido == 'S' ? 'selected' : '' }}>
                                                                                Sim</option>
                                                                            <option value="N"
                                                                                {{ $item->valido == 'N' ? 'selected' : '' }}>
                                                                                Não</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="mb-3 col-md-12"
                                                                        style="text-align: center">
                                                                        <label class="form-label">Status</label>
                                                                        <select class="form-control"
                                                                            id="status_id{{ $item->id }}"
                                                                            name="status_id" style="text-align: center">
                                                                            <option selected></option>
                                                                            @foreach ($status as $statuss)
                                                                                <option value="{{ $statuss->id }}"
                                                                                    {{ $item->status_id == $statuss->id ? 'selected' : '' }}>
                                                                                    {{ $statuss->nome }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancelar</button>
                                                            <button type="submit" class="btn btn-primary">Salvar</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function() {
                // Defina o token CSRF para todas as solicitações AJAX
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // Aplica a máscara aos inputs de valor
                applyMask();

                function applyMask() {
                    $('.valor').mask('000.000.000.000.000.00', {
                        reverse: true
                    });
                }

                // Função para verificar se é dívida e mostrar campo de usuário
                window.checkDivida = function(element) {
                    const usuarioCell = element.closest('tr').querySelector('.usuario-cell');
                    const usuarioHeader = document.querySelector('.usuario-header');
                    const usuarioSelect = usuarioCell.querySelector('select');

                    if (element.value == '3') {
                        usuarioCell.style.display = '';
                        usuarioHeader.style.display = '';
                        usuarioSelect.setAttribute('required', 'required');
                    } else {
                        usuarioCell.style.display = 'none';
                        usuarioSelect.value = '';
                        usuarioSelect.removeAttribute('required');

                        // Verifica se há outras linhas com tipo de dívida para mostrar o cabeçalho
                        const anyDivida = [...document.querySelectorAll('.tipo-select')].some(select => select
                            .value == '3');
                        if (!anyDivida) {
                            usuarioHeader.style.display = 'none';
                        }
                    }
                }


                // Função para adicionar um novo lançamento
                window.addLancamento = function() {
                    const tableBody = document.querySelector('#lancamentos tbody');
                    const newRow = tableBody.querySelector('.lancamento').cloneNode(true);
                    newRow.querySelectorAll('input').forEach(input => input.value = '');
                    newRow.querySelectorAll('select').forEach(select => select.value = '');
                    newRow.querySelector('.usuario-cell').style.display = 'none';
                    tableBody.appendChild(newRow);

                    applyMask();
                }

                // Função para remover um lançamento
                window.removeLancamento = function(button) {
                    const row = button.closest('tr');
                    const tableBody = document.querySelector('#lancamentos tbody');
                    if (tableBody.querySelectorAll('.lancamento').length > 1) {
                        row.remove();

                        // Verifica se há outras linhas com tipo de dívida para mostrar o cabeçalho
                        const anyDivida = [...document.querySelectorAll('.tipo-select')].some(select => select
                            .value == '3');
                        if (!anyDivida) {
                            document.querySelector('.usuario-header').style.display = 'none';
                        }
                    }
                }

                // Select all rows
                $('#selectAllButton').on('click', function() {
                    const isChecked = $('.selectRow').length !== $('.selectRow:checked').length;
                    $('.selectRow').prop('checked', isChecked);
                    toggleReserveButton();
                });

                // Toggle reserve button based on checkbox selection
                $('.selectRow').on('change', function() {
                    toggleReserveButton();
                });

                function toggleReserveButton() {
                    if ($('.selectRow:checked').length > 0) {
                        $('#reserveButton').show();
                    } else {
                        $('#reserveButton').hide();
                    }
                }

                // Reserve button click event
                $('#reserveButton').on('click', function() {
                    reserveSelected();
                });

                function reserveSelected() {
                    const selectedIds = $('.selectRow:checked').map(function() {
                        return $(this).data('id');
                    }).get();

                    if (selectedIds.length > 0) {
                        $.ajax({
                            url: '{{ route('lancamentos.update-status3') }}',
                            method: 'POST',
                            data: {
                                status_id: 5,
                                lancamento_ids: selectedIds // Sending array of selected IDs
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

                // Função para verificar o campo de código
                $(document).on('input', '.codigo-input', function() {
                    const value = $(this).val();
                    if (/^\d{14}$/.test(value)) {
                        const row = $(this).closest('tr');
                        row.find('select[name="moeda_id[]"]').val('1');
                        row.find('input[name="valor[]"]').val('200,00');
                        row.find('select[name="tipo_id[]"]').val('4');
                    } else if (/^\d{25}$/.test(value)) {
                        const row = $(this).closest('tr');
                        row.find('select[name="moeda_id[]"]').val('1');
                        row.find('input[name="valor[]"]').val('500,00');
                        row.find('select[name="tipo_id[]"]').val('2');
                    }
                });
            });
        </script>
    @endsection
