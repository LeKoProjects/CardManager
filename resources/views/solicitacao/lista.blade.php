@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
@section('content')
    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Solicitações</h6>
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
                                <th>Tipo</th>
                                <th>Responder</th>
                                <th>Excluir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($solicitacoes as $solicitacao)
                                <tr style="text-align: center">
                                    <td>{{ $solicitacao->id }}</td>
                                    <td>{{ $solicitacao->created_at }}</td>
                                    <td>{{ $solicitacao->user->name }}</td>
                                    <td>{{ $solicitacao->titulo }}</td>
                                    <td>{{ $solicitacao->mensagem }}</td>
                                    <td>{{ $solicitacao->tipo->nome }}</td>
                                    <td>
                                        @if ($solicitacao->resposta)
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="{{ $solicitacao->id }}" data-titulo="{{ $solicitacao->titulo }}" data-resposta="{{ $solicitacao->resposta }}">Respondido</button>
                                        @else
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="{{ $solicitacao->id }}" data-titulo="{{ $solicitacao->titulo }}" data-resposta="{{ $solicitacao->resposta }}">Responder</button>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('solicitacoes.destroy', $solicitacao->id) }}" method="POST">
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

<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Responder Solicitação</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="respostaForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="solicitacao_id" name="id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="resposta">Resposta</label>
                            <textarea class="form-control" id="resposta" name="resposta" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar Resposta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    var exampleModal = document.getElementById('exampleModal');
    exampleModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Button that triggered the modal
        var id = button.getAttribute('data-id');
        var resposta = button.getAttribute('data-resposta');

        var modalTitle = exampleModal.querySelector('.modal-title');
        var modalBodyInput = exampleModal.querySelector('.modal-body textarea');
        var modalForm = exampleModal.querySelector('form');
        var modalIdInput = exampleModal.querySelector('input#solicitacao_id');

        modalTitle.textContent = 'Responder Solicitação #' + id;
        modalBodyInput.value = resposta;
        modalForm.action = '/solicitacoes/' + id;
        modalIdInput.value = id;
    });
});

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@endsection
