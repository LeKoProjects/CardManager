@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="row">
            <!-- Novo Status Card -->
            <div class="col-md-6">
                <div class="card shadow mb-6">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Nova Moeda</h6>
                    </div>
                    <div class="card-body">
                        <div class="tile">
                            <div class="tile-body">
                                <form method="POST" action="{{ route('moedas.store') }}" class="form-horizontal">
                                    @csrf
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Nome da Moeda</label>
                                            <input name="moeda" id="moeda" class="form-control" type="text" placeholder="" required>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Abreviação</label>
                                            <input name="abreviacao" id="abreviacao" class="form-control" type="text" placeholder="" required>
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
                        <h6 class="m-0 font-weight-bold text-primary">Lista dos Tipos</h6>
                    </div>
                    <div class="card-body">
                        <div class="tile">
                            <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Moeda</th>
                                        <th>Abreviação</th>
                                        <th>Editar</th>
                                        <th>Excluir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($moeda as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->moeda }}</td>
                                            <td>{{ $item->abreviacao }}</td>
                                            <td>
                                                <div>
                                                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                                        Editar
                                                    </button>
                                                </div>
                                            </td>
                                            <td>
                                                <form action="{{ route('moedas.destroy', $item->id) }}" method="POST">
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
                                                        <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Editar Moeda</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" action="{{ route('moedas.update', $item->id) }}" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="row">
                                                                <div class="mb-3 col-md-6">
                                                                    <label class="form-label">Nome do Tipo</label>
                                                                    <input name="moeda" id="moeda{{ $item->id }}" class="form-control" type="text" placeholder="" value="{{ $item->moeda }}">
                                                                </div>
                                                                <div class="mb-3 col-md-6">
                                                                    <label class="form-label">Abreviação</label>
                                                                    <input name="abreviacao" id="abreviacao{{ $item->id }}" class="form-control" type="text" placeholder="" value="{{ $item->abreviacao }}">
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
    <!-- Inclua o JavaScript do Bootstrap no final do body para melhorar o desempenho -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    </script>
@endsection
