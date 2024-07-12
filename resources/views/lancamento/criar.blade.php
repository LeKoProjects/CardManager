@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="container-fluid">
            <!-- DataTales Example -->
            <div class="row">
                <!-- Novo Status Card -->
                <div class="col-md-12">
                    <div class="card shadow mb-5">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Novo Lançamento</h6>
                        </div>
                        <div class="card-body">
                            <div class="tile-body">
                                <form method="POST" action="{{ route('lancamento.store') }}">
                                    @csrf
                                    <div class="table-responsive">
                                        <table class="table" id="lancamentos">
                                            <thead>
                                                <tr>
                                                    <th>Código</th>
                                                    <th>Moeda</th>
                                                    <th>Valor</th>
                                                    <th>Tipo</th>
                                                    <th class="usuario-header" style="display: none;">Usuário</th>
                                                    <th>Adicionar</th>
                                                    <th>Excluir</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="lancamento">
                                                    <td><input name="codigo[]" class="form-control codigo-input"
                                                            type="text" required></td>
                                                    <td>
                                                        <select class="form-control" name="moeda_id[]" required>
                                                            <option>Selecione a Moeda</option>
                                                            @foreach ($moeda as $item)
                                                                <option value="{{ $item->id }}">{{ $item->moeda }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input name="valor[]" class="form-control valor" type="text"
                                                            required>
                                                    </td>
                                                    <td>
                                                        <select class="form-control tipo-select" name="tipo_id[]"
                                                            onchange="checkDivida(this)" required>
                                                            <option value="">Selecione o Tipo</option>
                                                            @foreach ($tipo as $item)
                                                                <option value="{{ $item->id }}">{{ $item->nome }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td class="usuario-cell" style="display:none;">
                                                        <select class="form-control" name="user_id[]" id="user_id">
                                                            <option value="">Selecione o Usuário</option>
                                                            @foreach ($users as $usuario)
                                                                <option value="{{ $usuario->id }}">{{ $usuario->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-success"
                                                            onclick="addLancamento()"><i class="fas fa-plus"></i></button>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger"
                                                            onclick="removeLancamento(this)"><i
                                                                class="fas fa-minus"></i></button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                    </div>
                                </form>
                            </div>
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
