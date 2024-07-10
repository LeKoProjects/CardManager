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
                            <div class="tile">
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
                                                                onclick="addLancamento()"><i
                                                                    class="fas fa-plus"></i></button>
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
                            <div class="tile">
                                <div class="d-flex justify-content-between mb-3">
                                    <input type="text" id="filter_input" class="form-control w-50" placeholder="Filtrar...">
                                    <select id="rows_per_page" class="form-control w-25">
                                        <option value="2">2 linhas por página</option>
                                        <option value="20" selected>20 linhas por página</option>
                                        <option value="30">30 linhas por página</option>
                                        <option value="40">40 linhas por página</option>
                                    </select>
                                </div>
                        
                                <div class="table-responsive">
                                    <table class="table table-bordered">
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
                                                <tr style="text-align: center" class="{{ $item->valido == 'N' ? 'red-row' : '' }}">
                                                    <td><input type="checkbox" class="selectRow" data-id="{{ $item->id }}"></td>
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
                                                            {{-- <span style="color: red">Aguardando Pagamento</span> --}}
                                                        @elseif ($item->status_id == 3)
                                                            <span style="color: orange">Aguardando Liberação</span>
                                                        @elseif ($item->status_id == 4)
                                                            <span style="color: green">Comprado</span>
                                                        @elseif ($item->status_id == 5)
                                                            <span style="color: purple">Reservado</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                                                Editar
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('lancamento.destroy', $item->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Excluir</button>
                                                        </form>
                                                    </td>
                                                </tr>
                        
                                                <!-- Modal for Editing -->
                                                <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Editar Lançamento</h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST" action="{{ route('lancamento.update', $item->id) }}" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="row">
                                                                        <div class="mb-3 col-md-12">
                                                                            <label class="form-label">Código</label>
                                                                            <input name="codigo" id="codigo{{ $item->id }}" class="form-control" type="text" placeholder="" value="{{ $item->codigo }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="mb-3 col-md-3">
                                                                            <label class="form-label">Moeda</label>
                                                                            <select class="form-control" id="moeda_id{{ $item->id }}" name="moeda_id">
                                                                                <option selected></option>
                                                                                @foreach ($moeda as $moedas)
                                                                                    <option value="{{ $moedas->id }}" {{ $item->moeda_id == $moedas->id ? 'selected' : '' }}>{{ $moedas->moeda }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="mb-3 col-md-3">
                                                                            <label class="form-label">Valor</label>
                                                                            <input name="valor" id="valor{{ $item->id }}" class="form-control valor" type="text" placeholder="" value="{{ $item->valor }}">
                                                                        </div>
                                                                        <div class="mb-3 col-md-3">
                                                                            <label class="form-label">Tipo</label>
                                                                            <select class="form-control" id="tipo_id{{ $item->id }}" name="tipo_id">
                                                                                <option selected></option>
                                                                                @foreach ($tipo as $tipos)
                                                                                    <option value="{{ $tipos->id }}" {{ $item->tipo_id == $tipos->id ? 'selected' : '' }}>{{ $tipos->nome }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="mb-3 col-md-3">
                                                                            <label class="form-label">Válido</label>
                                                                            <select class="form-control" id="valido{{ $item->id }}" name="valido">
                                                                                <option value="S" {{ $item->valido == 'S' ? 'selected' : '' }}>Sim</option>
                                                                                <option value="N" {{ $item->valido == 'N' ? 'selected' : '' }}>Não</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="mb-3 col-md-12" style="text-align: center">
                                                                            <label class="form-label">Status</label>
                                                                            <select class="form-control" id="status_id{{ $item->id }}" name="status_id" style="text-align: center">
                                                                                <option selected></option>
                                                                                @foreach ($status as $statuss)
                                                                                    <option value="{{ $statuss->id }}" {{ $item->status_id == $statuss->id ? 'selected' : '' }}>{{ $statuss->nome }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                                <button type="submit" class="btn btn-primary">Salvar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-center">
                                        <nav aria-label="Page navigation">
                                            <ul class="pagination pagination-sm" id="pagination"></ul>
                                        </nav>
                                    </div>
                        
                                </div>
                            </div>
                        </div>
                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
                        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
                        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                let rowsPerPage = parseInt(document.getElementById('rows_per_page').value);
                                let currentPage = 1;
                                const tableBody = document.getElementById('table-body');
                                const filterInput = document.getElementById('filter_input');
                                const pagination = document.getElementById('pagination');
                                const rowsPerPageSelect = document.getElementById('rows_per_page');
                        
                                function displayRows(filteredRows, page) {
                                    const start = (page - 1) * rowsPerPage;
                                    const end = start + rowsPerPage;
                                    tableBody.innerHTML = '';
                        
                                    filteredRows.slice(start, end).forEach(row => {
                                        tableBody.appendChild(row);
                                    });
                                }
                        
                                function createPageItem(page, isCurrent = false) {
                                    const li = document.createElement('li');
                                    li.className = `page-item ${isCurrent ? 'active' : ''}`;
                                    li.innerHTML = `<a class="page-link" href="#">${page}</a>`;
                                    li.addEventListener('click', function (e) {
                                        e.preventDefault();
                                        if (page !== '...') {
                                            currentPage = page;
                                            displayRows(filteredRows, currentPage);
                                            updatePagination(filteredRows);
                                        }
                                    });
                                    return li;
                                }
                        
                                function updatePagination(filteredRows) {
                                    pagination.innerHTML = '';
                        
                                    const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
                                    const maxPagesToShow = 7;
                                    const halfPagesToShow = Math.floor(maxPagesToShow / 2);
                        
                                    if (totalPages <= maxPagesToShow) {
                                        for (let i = 1; i <= totalPages; i++) {
                                            pagination.appendChild(createPageItem(i, i === currentPage));
                                        }
                                    } else {
                                        const pages = [];
                                        const startPage = Math.max(currentPage - halfPagesToShow, 1);
                                        const endPage = Math.min(startPage + maxPagesToShow - 1, totalPages);
                        
                                        if (startPage > 1) {
                                            pages.push(1);
                                            if (startPage > 2) {
                                                pages.push('...');
                                            }
                                        }
                        
                                        for (let i = startPage; i <= endPage; i++) {
                                            pages.push(i);
                                        }
                        
                                        if (endPage < totalPages) {
                                            if (endPage < totalPages - 1) {
                                                pages.push('...');
                                            }
                                            pages.push(totalPages);
                                        }
                        
                                        pages.forEach(page => {
                                            pagination.appendChild(createPageItem(page, page === currentPage));
                                        });
                                    }
                                }
                        
                                function updateFilteredRows() {
                                    const filterValue = filterInput.value.toLowerCase();
                                    const rows = Array.from(tableBody.children);
                        
                                    return rows.filter(row => {
                                        return row.textContent.toLowerCase().includes(filterValue);
                                    });
                                }
                        
                                let filteredRows = updateFilteredRows();
                                displayRows(filteredRows, currentPage);
                                updatePagination(filteredRows);
                        
                                filterInput.addEventListener('input', function () {
                                    filteredRows = updateFilteredRows();
                                    currentPage = 1;
                                    displayRows(filteredRows, currentPage);
                                    updatePagination(filteredRows);
                                });
                        
                                rowsPerPageSelect.addEventListener('change', function () {
                                    rowsPerPage = parseInt(this.value);
                                    filteredRows = updateFilteredRows();
                                    currentPage = 1;
                                    displayRows(filteredRows, currentPage);
                                    updatePagination(filteredRows);
                                });
                            });
                        </script>
                        
    @endsection
