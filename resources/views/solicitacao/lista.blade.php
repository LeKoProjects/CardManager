@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Solicitações </h6>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr style="text-align: center">
                                <th>#</th>
                                <th>Data/Hora</th>
                                <th>Usuário</th>
                                <th>Título</th>
                                <th>Mensagem</th>
                                <th>Responder</th>
                                <th>Excluir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($solicitacoes as $solicitacao)
                                <tr style="text-align: center">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div>
                                            <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $item->id }}">
                                                Editar
                                            </button>
                                        </div>
                                    </td>
                                    <td>
                                        <form action="{{ route('solicitacao.destroy', $item->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
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
                                                    <input name="codigo"
                                                        id="codigo{{ $item->id }}"
                                                        class="form-control" type="text"
                                                        placeholder="" value="{{ $item->codigo }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-3 col-md-4">
                                                    <label class="form-label">Moeda</label>
                                                    <select class="form-control"
                                                        id="moeda_id{{ $item->id }}"
                                                        name="moeda_id">
                                                        <option selected></option>
                                                        @foreach ($moeda as $moedas)
                                                            <option value="{{ $moedas->id }}"
                                                                {{ $item->moeda_id == $moedas->id ? 'selected' : '' }}>
                                                                {{ $moedas->moeda }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3 col-md-4">
                                                    <label class="form-label">Valor</label>
                                                    <input name="valor" id="valor{{ $item->id }}"
                                                        class="form-control valor" type="text"
                                                        placeholder="" value="{{ $item->valor }}">
                                                </div>
                                                <div class="mb-3 col-md-4">
                                                    <label class="form-label">Tipo</label>
                                                    <select class="form-control"
                                                        id="tipo_id{{ $item->id }}" name="tipo_id">
                                                        <option selected></option>
                                                        @foreach ($tipo as $tipos)
                                                            <option value="{{ $tipos->id }}"
                                                                {{ $item->tipo_id == $tipos->id ? 'selected' : '' }}>
                                                                {{ $tipos->nome }}</option>
                                                        @endforeach
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
                                                                {{ $statuss->nome }}</option>
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
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
