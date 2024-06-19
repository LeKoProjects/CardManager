@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Novo Status Card -->
            <div class="col-md-6">
                <div class="card shadow mb-6">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Novo Usuário</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('usuario.store') }}" class="form-horizontal">
                            @csrf
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Nome</label>
                                    <input name="name" id="name" class="form-control" type="text" required>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">E-mail</label>
                                    <input name="email" id="email" class="form-control" type="email" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Senha</label>
                                    <input name="password" id="password" class="form-control" type="password" required>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Confirme a Senha</label>
                                    <input name="password_confirmation" id="password_confirmation" class="form-control" type="password" required>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Celular</label>
                                    <input name="celular" id="celular" class="form-control" type="text" required>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Tipo</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="tipo" value="1" required> Admin
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="tipo" value="2" required> User
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-check-circle-fill me-2"></i>Novo
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Lista de Usuários Card -->
            <div class="col-md-6">
                <div class="card shadow mb-6">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Lista de Usuários</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
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
                                            <td>{{ $item->tipo == 1 ? 'Admin' : 'User' }}</td>
                                            <td>
                                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                                    Editar
                                                </button>
                                            </td>
                                            <td>
                                                <form action="{{ route('usuario.destroy', $item->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Excluir</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            

            <!-- Modals for editing users -->
            @foreach ($usuario as $item)
                <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Editar Usuário</h5>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ route('usuario.update', $item->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Nome</label>
                                            <input name="name" class="form-control" type="text" value="{{ $item->name }}">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">E-mail</label>
                                            <input name="email" class="form-control" type="email" value="{{ $item->email }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Celular</label>
                                            <input name="celular" class="form-control" type="text" value="{{ $item->celular }}">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Tipo</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="tipo" value="1" {{ $item->tipo == 1 ? 'checked' : '' }}> Admin
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="tipo" value="2" {{ $item->tipo == 2 ? 'checked' : '' }}> User
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Senha</label>
                                            <input name="password" class="form-control" type="password">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Confirme a Senha</label>
                                            <input name="password_confirmation" id="password_confirmation" class="form-control" type="password">
                                        </div>
                                    </div>
                                    
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
@endsection
