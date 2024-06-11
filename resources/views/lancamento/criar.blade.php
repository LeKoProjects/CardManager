@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="row">
            <!-- Novo Status Card -->
            <div class="col-md-4">
                <div class="card shadow mb-5">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Novo Lançamento</h6>
                    </div>
                    <div class="card-body">
                        <div class="tile">
                            <div class="tile-body">
                                <form method="POST" action="{{ route('lancamento.store') }}" class="form-horizontal">
                                    @csrf
                                    <div class="row">
                                        <div class="mb-3 col-md-12">
                                            <label class="form-label">Código</label>
                                            <input name="codigo" id="codigo" class="form-control" type="text"
                                                placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Moeda</label>
                                            <select class="form-control" id="moeda_id" name="moeda_id">
                                                <option>Selecione a Moeda</option>
                                                @foreach ($moeda as $item)
                                                    <option value="{{ $item->id }}">
                                                        {{ $item->moeda }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Valor</label>
                                            <input name="valor" id="valor" class="form-control" type="text"
                                                placeholder="" required>
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Tipo</label>
                                            <select class="form-control" id="tipo_id" name="tipo_id">
                                                <option value="">Selecione o Tipo
                                                </option>
                                                @foreach ($tipo as $item)
                                                    <option value="{{ $item->id }}">
                                                        {{ $item->nome }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="tile-footer">
                                        <div class="row">
                                            <div class="col-md-12 col-md-offset-3">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="bi bi-check-circle-fill me-2"></i>Criar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lista dos Tipos Card -->
            <div class="col-md-8">
                <div class="card shadow mb-7">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Lista dos Lançamentos</h6>
                    </div>
                    <div class="card-body">
                        <div class="tile">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Moeda</th>
                                        <th>Valor</th>
                                        <th>Tipo</th>
                                        <th>Editar</th>
                                        <th>Excluir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lancamento as $item)
                                        <tr>
                                            <td>{{ $item->codigo }}</td>
                                            <td>{{ $item->moeda->moeda }}</td>
                                            <td>{{ $item->valor }}</td>
                                            <td>{{ $item->tipo->nome }}</td>
                                            <td>
                                                <div>
                                                    <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $item->id }}">
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
                                        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
                                            aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel{{ $item->id }}">
                                                            Editar Lançamento</h5>
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
                                                                    <input name="codigo" id="codigo{{ $item->id }}"
                                                                        class="form-control" type="text" placeholder=""
                                                                        value="{{ $item->codigo }}">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Moeda</label>
                                                                    <select class="form-control" id="moeda_id{{ $item->id }}" name="moeda_id">
                                                                        <option selected></option>
                                                                        @foreach ($moeda as $moedas)
                                                                            <option value="{{ $moedas->id }}" {{ $item->moeda_id == $moedas->id ? 'selected' : '' }}>{{ $moedas->moeda }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Valor</label>
                                                                    <input name="valor"
                                                                        id="valor{{ $item->id }}"
                                                                        class="form-control" type="text"
                                                                        placeholder="" value="{{ $item->valor }}">
                                                                </div>
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Tipo</label>
                                                                    <select class="form-control" id="tipo_id{{ $item->id }}" name="tipo_id">
                                                                        <option selected></option>
                                                                        @foreach ($tipo as $tipos)
                                                                            <option value="{{ $tipos->id }}" {{ $item->tipo_id == $tipos->id ? 'selected' : '' }}>{{ $tipos->nome }}</option>
                                                                        @endforeach
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
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancelar</button>
                                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                                    </div>
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

    <script>
        <!-- Inclua o JavaScript do Bootstrap no final do body para melhorar o desempenho 
        -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    </script>
@endsection
