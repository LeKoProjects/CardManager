@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                                <th>Responsável</th>
                                <th>Data/Hora</th>
                                <th>Título</th>
                                <th>Tipo</th>
                                <th>Responder</th>
                                <th>Status</th>
                                <th>Excluir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($solicitacoes as $solicitacao)
                                <tr style="text-align: center">
                                    <td>{{ $solicitacao->id }}</td>
                                    <td>{{ $solicitacao->user->name }}</td>
                                    <td>{{ $solicitacao->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $solicitacao->titulo }}</td>
                                    <td>{{ $solicitacao->tipo->nome }}</td>
                                    <td>
                                        @if ($solicitacao->resposta)
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal" data-id="{{ $solicitacao->id }}"
                                                data-titulo="{{ $solicitacao->titulo }}"
                                                data-resposta="{{ $solicitacao->resposta }}">Respondido <i
                                                    class="fas fa-solid fa-comment"></i></button>
                                        @else
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal" data-id="{{ $solicitacao->id }}"
                                                data-titulo="{{ $solicitacao->titulo }}"
                                                data-resposta="{{ $solicitacao->resposta }}">Responder <i
                                                    class="fas fa-solid fa-comment"></i></button>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('solicitacoes.updateStatus', $solicitacao->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            @if($solicitacao->status == 'Pago')
                                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#statusModal" data-id="{{ $solicitacao->id }}" data-status="Pago">
                                                    Pago
                                                </button>
                                            @elseif($solicitacao->status == 'Em andamento')
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#statusModal" data-id="{{ $solicitacao->id }}" data-status="Em andamento">
                                                    Em andamento
                                                </button>
                                            @elseif($solicitacao->status == 'Devendo')
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#statusModal" data-id="{{ $solicitacao->id }}" data-status="Devendo">
                                                    Devendo
                                                </button>
                                            @endif
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('solicitacoes.destroy', $solicitacao->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"><i
                                                    class="fas fa-solid fa-trash"></i></button>
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
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Responder Solicitação</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="solicitacao_id" name="id">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Quantidade:</label>
                            <input class="form-control" readonly value="{{ $solicitacao->quantidade ?? ''}}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Tipo:</label>
                            <input type="text" class="form-control" value="{{ $solicitacao->tipo->nome ?? ''}}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Mensagem</label>
                        <input class="form-control" readonly value="{{ $solicitacao->mensagem ?? ''}}">
                    </div>
                    <form id="respostaForm" method="POST" action="{{ route('solicitacoes.update', $solicitacao->id ?? '') }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3 col-md-12">
                            <label class="form-label">Responder</label>
                            <textarea class="form-control" id="resposta" name="resposta" rows="3" required></textarea>
                            <br>
                            <button type="submit" class="btn btn-primary">Enviar Resposta <i class="fas fa-solid fa-check"></i></button>
                        </div>
                    </form>
                    <hr>
                    <form id="lancamentoForm" method="POST" action="{{ route('solicitacoes.store2') }}">
                        @csrf
                        <div class="mb-3 col-md-12">
                            <label class="form-label">Lançamento</label>
                            <div class="table-responsive">
                                <table class="table" id="lancamentos">
                                    <thead>
                                        <tr>
                                            <th>Código</th>
                                            <th>Moeda</th>
                                            <th>Valor</th>
                                            <th>Tipo</th>
                                            <th class="usuario-header" style="display: none;">Usuário</th>
                                            <th class="solicitacao-header" style="display: none;">Solicitação</th>
                                            <th>Adicionar</th>
                                            <th>Excluir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="lancamento">
                                            <td><input name="codigo[]" class="form-control codigo-input" type="text" required></td>
                                            <td>
                                                <select class="form-control" name="moeda_id[]" required>
                                                    <option value="">Selecione a Moeda</option>
                                                    @foreach ($moeda as $item)
                                                        <option value="{{ $item->id }}">{{ $item->moeda }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input name="valor[]" class="form-control valor" type="text" required></td>
                                            <td>
                                                <select class="form-control tipo-select" name="tipo_id[]" onchange="checkDivida(this)" required>
                                                    <option value="">Selecione o Tipo</option>
                                                    @foreach ($tipos as $item)
                                                        <option value="{{ $item->id }}">{{ $item->nome }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="usuario-cell" style="display:none;">
                                                <input name="user_id[]" class="form-control user_id" type="text" value="{{ $solicitacao->user_id ?? '' }}">
                                            </td>
                                            <td class="solicitacao-cell" style="display:none;">
                                                <input name="solicitacao_id[]" class="form-control solicitacao_id" type="text" value="{{ $solicitacao->id ?? '' }}">
                                            </td>
                                            <td><button type="button" class="btn btn-success" onclick="addLancamento()"><i class="fas fa-plus"></i></button></td>
                                            <td><button type="button" class="btn btn-danger" onclick="removeLancamento(this)"><i class="fas fa-minus"></i></button></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="submit" class="btn btn-primary">Salvar <i class="fas fa-solid fa-check"></i></button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Lançamentos Enviados</label>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Moeda</th>
                                        <th>Valor</th>
                                        <th>Tipo</th>
                                    </tr>
                                </thead>
                                @foreach ($lancamentos as $item)
                                    @if ($item->solicitacao_id == $solicitacao->id)
                                        <tr>
                                            <td><input class="form-control codigo-input" type="text" value="{{ $item->codigo }}"></td>
                                            <td><input class="form-control codigo-input" type="text" value="{{ $item->moeda->moeda }}"></td>
                                            <td><input class="form-control codigo-input" type="text" value="{{ $item->valor }}"></td>
                                            <td><input class="form-control codigo-input" type="text" value="{{ $item->tipo->nome }}"></td>
                                        </tr>
                                    @endif
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Modal para alterar status -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="statusModalLabel">Alterar Status</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="statusForm" method="POST" action="">
                    @csrf
                    <!-- Aqui utilizamos o método POST, sem PUT -->
                    <input type="hidden" id="solicitacao_id" name="id">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-control" name="status" id="statusSelect" required>
                            <option value="Pago">Pago</option>
                            <option value="Em andamento">Em andamento</option>
                            <option value="Devendo">Devendo</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Atualizar Status</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var statusModal = document.getElementById('statusModal');
    statusModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget; // Botão que acionou o modal
        var id = button.getAttribute('data-id'); // Obtém o ID da solicitação
        var status = button.getAttribute('data-status'); // Obtém o status atual

        // Atualizar a ação do formulário com a URL correta
        var form = document.getElementById('statusForm');
        form.action = '/solicitacoes/updateStatus/' + id;
        
        // Atualizar o valor do select com o status atual
        var statusSelect = document.getElementById('statusSelect');
        statusSelect.value = status;
    });
});


    $(document).ready(function() {
        $('#respostaForm').on('submit', function(event) {
            event.preventDefault();

            var form = $(this);
            var url = form.attr('action');
            var data = form.serialize();

            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function(response) {
                    // Exibe uma mensagem de sucesso (pode ser um alerta ou qualquer outro elemento)
                    alert('Resposta atualizada com sucesso!');
                    // Você pode atualizar a página ou partes específicas dela aqui, se necessário
                },
                error: function(xhr) {
                    // Exibe uma mensagem de erro
                    alert('Ocorreu um erro ao atualizar a resposta.');
                }
            });
        });
    });
</script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var exampleModal = document.getElementById('exampleModal');
            exampleModal.addEventListener('show.bs.modal', function(event) {
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function addLancamento() {
        var newRow = `
            <tr class="lancamento">
                <td><input name="codigo[]" class="form-control codigo-input" type="text" required></td>
                <td>
                    <select class="form-control" name="moeda_id[]" required>
                        <option value="">Selecione a Moeda</option>
                        @foreach ($moeda as $item)
                            <option value="{{ $item->id }}">{{ $item->moeda }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input name="valor[]" class="form-control valor" type="text" required></td>
                <td>
                    <select class="form-control tipo-select" name="tipo_id[]" onchange="checkDivida(this)" required>
                        <option value="">Selecione o Tipo</option>
                        @foreach ($tipos as $item)
                            <option value="{{ $item->id }}">{{ $item->nome }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="usuario-cell" style="display:none;">
                    <input name="user_id[]" class="form-control user_id" type="text" value="{{ $solicitacao->user_id ?? ''}}">
                </td>
                <td class="solicitacao-cell" style="display:none;">
                    <input name="solicitacao_id[]" class="form-control solicitacao_id" type="text" value="{{ $solicitacao->id ?? ''}}">
                </td>
                <td><button type="button" class="btn btn-success" onclick="addLancamento()"><i class="fas fa-plus"></i></button></td>
                <td><button type="button" class="btn btn-danger" onclick="removeLancamento(this)"><i class="fas fa-minus"></i></button></td>
            </tr>
        `;
        $('#lancamentos tbody').append(newRow);
    }

    function removeLancamento(button) {
        $(button).closest('tr').remove();
    }

    $(document).ready(function() {
        $('#lancamentoForm').on('submit', function(event) {
            event.preventDefault();

            var form = $(this);
            var url = form.attr('action');
            var data = form.serialize();

            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function(response) {
                    // Exibe uma mensagem de sucesso (pode ser um alerta ou qualquer outro elemento)
                    alert('Lançamentos cadastrados com sucesso!');
                    // Você pode limpar o formulário ou atualizar a tabela aqui, se necessário
                },
                error: function(xhr) {
                    // Exibe uma mensagem de erro
                    alert('Ocorreu um erro ao cadastrar os lançamentos.');
                }
            });
        });
    });
</script>
@endsection
