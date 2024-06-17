@extends('layouts.app')

@section('content')
<body>
    <h1>Lista de Solicitações</h1>
    @if($solicitacoes->isEmpty())
        <p>Nenhuma solicitação encontrada.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuário</th>
                    <th>Título</th>
                    <th>Mensagem</th>
                    <th>Data de Criação</th>
                </tr>
            </thead>
            <tbody>
                @foreach($solicitacoes as $solicitacao)
                    <tr>
                        <td>{{ $solicitacao->id }}</td>
                        <td>{{ $solicitacao->user->name }}</td>
                        <td>{{ $solicitacao->titulo }}</td>
                        <td>{{ $solicitacao->mensagem }}</td>
                        <td>{{ $solicitacao->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <a href="{{ route('solicitacoes.criar') }}">Criar Nova Solicitação</a>
</body>
@endsection