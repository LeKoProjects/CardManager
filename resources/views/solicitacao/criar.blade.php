@extends('layouts.app')

@section('content')
<body>
    @if(session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif
<div class="container-fluid">
    <form method="POST" action="{{ route('solicitacoes.store') }}">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Nova Solicitação</h6>
            </div>
            @csrf
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título:</label>
                    <input id="titulo" name="titulo" class="form-control" type="text" placeholder="Digite o título" required>
                </div>
                <div class="mb-3">
                    <label for="mensagem" class="form-label">Mensagem:</label>
                    <textarea id="mensagem" name="mensagem" class="form-control" placeholder="Digite a mensagem" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="tipo_id" class="form-label">Tipo:</label>
                    <select id="tipo_id" name="tipo_id" class="form-control" required>
                        <option value="">Selecione um tipo</option>
                        @foreach($tipos as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->nome }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
    </form>
</div>
</body>
@endsection