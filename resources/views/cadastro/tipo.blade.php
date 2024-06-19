@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow mb-6">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Novo Tipo</h6>
                    </div>
                    <div class="card-body">
                        <div class="tile">
                            <div class="tile-body">
                                <form method="POST" action="{{ route('tipo.store') }}" class="form-horizontal" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Nome do Tipo</label>
                                            <input name="nome" id="nome" class="form-control" type="text"
                                                placeholder="" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Porcentagem</label>
                                            <div class="input-group mb-3">
                                                <input type="text" name="porcentagem" id="porcentagem"
                                                    class="form-control" placeholder="" aria-describedby="basic-addon2" required>
                                                <span class="input-group-text" id="basic-addon2">%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-label">Logo</label>
                                            <input name="imagem" id="imagem" class="form-control" type="file"
                                                placeholder="">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="tile-footer">
                                        <div class="row">
                                            <div class="col-md-12 col-md-offset-3">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="bi bi-check-circle-fill me-2"></i>Novo
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

            <div class="col-md-6">
                <div class="card shadow mb-6">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Lista dos Tipos</h6>
                    </div>
                    <div class="card-body">
                        <div class="tile">
                            <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Logo</th>
                                        <th>Tipo</th>
                                        <th>Porcentagem</th>
                                        <th>Editar</th>
                                        <th>Excluir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tipo as $item)
                                        <tr>
                                            <td>
                                                @if($item->imagem)
                                                    <img src="images/{{ $item->imagem }}">
                                                @else
                                                    Sem imagem
                                                @endif
                                            </td>
                                            <td>{{ $item->nome }}</td>
                                            <td>{{ $item->porcentagem }}%</td>
                                            <td>
                                                <div>
                                                    <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $item->id }}">
                                                        Editar
                                                    </button>
                                                </div>
                                            </td>
                                            <td>
                                                <form action="{{ route('tipo.destroy', $item->id) }}" method="POST">
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
                                                            Editar Tipo</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" action="{{ route('tipo.update', $item->id) }}"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label for="nome{{ $item->id }}"
                                                                        class="form-label">Nome</label>
                                                                    <input type="text" class="form-control"
                                                                        id="nome{{ $item->id }}" name="nome"
                                                                        value="{{ $item->nome }}">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="porcentagem{{ $item->id }}"
                                                                        class="form-label">Porcentagem</label>
                                                                    <div class="input-group mb-3">
                                                                        <input type="text" name="porcentagem"
                                                                            id="porcentagem{{ $item->id }}"
                                                                            class="form-control" placeholder=""
                                                                            aria-describedby="basic-addon2"
                                                                            value="{{ $item->porcentagem }}">
                                                                        <span class="input-group-text"
                                                                            id="basic-addon2">%</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label class="form-label">Logo</label>
                                                                    <input name="imagem" id="imagem" class="form-control" type="file"
                                                                        placeholder="" >
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancelar</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Salvar</button>
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
    </div>
    <script>
        < script src = "https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" >
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    </script>
@endsection
