@extends('layouts.app')
<style>
    .actions {
        display: flex;
        gap: 5px;
    }
</style>
@section('content')
    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 action">
                <h6 class="m-0 font-weight-bold text-primary">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
                        <i class="fas fa-solid fa-plus"></i>
                    </button> Lançamentos
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Moeda</th>
                                <th>Valor</th>
                                <th>Tipo</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Tiger Nixon</td>
                                <td>System Architect</td>
                                <td>Edinburgh</td>
                                <td>61</td>
                                <td>2011/04/25</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Editing -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Novo Lançamento</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="#" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Nome</label>
                                <input name="name" id="name" class="form-control" type="text" placeholder="" value="">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">E-mail</label>
                                <input name="email" id="email" class="form-control" type="email" placeholder="" value="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Senha</label>
                                <input name="password" id="password" class="form-control" type="password" placeholder="" value="">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Tipo</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipo" id="admin" value="1">
                                    <label class="form-check-label" for="admin">
                                        Admin
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipo" id="user" value="2">
                                    <label class="form-check-label" for="user">
                                        User
                                    </label>
                                </div>
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
    <scripts>
        <!-- Inclua o JavaScript do Bootstrap no final do body para melhorar o desempenho -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    </scripts>
@endsection