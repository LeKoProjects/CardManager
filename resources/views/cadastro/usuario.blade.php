@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="row">
            <!-- Novo Status Card -->
            <div class="col-md-6">
                <div class="card shadow mb-6">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Novo Usuário</h6>
                    </div>
                    <div class="card-body">
                        <div class="tile">
                            <div class="tile-body">
                                <form method="POST" action="{{ route('usuario.store') }}" class="form-horizontal">
                                    @csrf
                                    <div class="row">
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Nome</label>
                                            <input name="name" id="name" class="form-control" type="text"
                                                placeholder="" required>
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">E-mail</label>
                                            <input name="email" id="email" class="form-control" type="email"
                                                placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Senha</label>
                                            <input name="password" id="password" class="form-control" type="password"
                                                placeholder="" required>
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <div class="mb-3 col-md-2">
                                                <label class="form-label">Tipo</label>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="tipo"
                                                            value="1">Admin
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="tipo"
                                                            value="2">User
                                                    </label>
                                                </div>
                                            </div>
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

            <!-- Lista dos Tipos Card -->
            <div class="col-md-6">
                <div class="card shadow mb-6">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Lista dos Usuários</h6>
                    </div>
                    <div class="card-body">
                        <div class="tile">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>E-mail</th>
                                        <th>Tipo</th>
                                        <th>Editar</th>
                                        <th>Excluir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($usuario as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->tipo == 1 ? 'Admin' : ($item->tipo == 2 ? 'User' : 'Desconhecido') }}</td>

                                            <td>
                                                <div>
                                                    <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $item->id }}">
                                                        Editar
                                                    </button>
                                                </div>
                                            </td>
                                            <td>
                                                <form action="{{ route('usuario.destroy', $item->id) }}" method="POST">
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
                                                            Editar Moeda</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST"
                                                            action="{{ route('usuario.update', $item->id) }}"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="row">
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Nome</label>
                                                                    <input name="name" id="name{{ $item->id }}"
                                                                        class="form-control" type="text" placeholder=""
                                                                        value="{{ $item->name }}">
                                                                </div>
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">E-mail</label>
                                                                    <input name="email" id="email{{ $item->id }}"
                                                                        class="form-control" type="email" placeholder=""
                                                                        value="{{ $item->email }}">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Senha</label>
                                                                    <input name="password" id="password{{ $item->id }}"
                                                                        class="form-control" type="password"
                                                                        placeholder="" value="{{ $item->email }}">
                                                                </div>
                                                                <div class="mb-3 col-md-4">
                                                                    <div class="mb-3 col-md-2">
                                                                        <label
                                                                            class="form-label">Tipo</label>
                                                                        <div class="form-check">
                                                                            <label class="form-check-label">
                                                                                <input class="form-check-input"
                                                                                    type="radio" name="tipo"
                                                                                    value="1"{{ $item->tipo == '1' ? 'checked' : '' }}>Admin
                                                                            </label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <label class="form-check-label">
                                                                                <input class="form-check-input"
                                                                                    type="radio" name="tipo"
                                                                                    value="2"{{ $item->tipo == '2' ? 'checked' : '' }}>User
                                                                            </label>
                                                                        </div>
                                                                    </div>
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
