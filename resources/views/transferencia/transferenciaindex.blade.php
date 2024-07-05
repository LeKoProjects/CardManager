@extends('layouts.app')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
    .qr-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        margin-bottom: 20px;
    }
</style>
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-6">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Transferências</h6>
                </div>
                <div class="card-body">
                    <div class="tile">
                        <div class="tile-body">
                            <form id="transferForm">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 qr-container">
                                        <label class="form-label">Destinatário</label>
                                        <img src="{{ route('qrcode.generate', ['address' => $destino->address]) }}" alt="QR Code">
                                        <div class="input-group mt-3">
                                            <input type="text" id="destinoAddress" class="form-control" value="{{ $destino->address }}" readonly>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-secondary" id="copyButton" onclick="copyAddress()">
                                                    <i class="fa fa-copy"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Remetente</label>
                                        <input name="to_address" id="to_address" class="form-control" type="text" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Valor</label>
                                        <input name="valor" id="valor" class="form-control" type="text" required>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-3">
                                        <button type="button" onclick="transfer()" class="btn btn-primary">Transferir</button>
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
                    <h6 class="m-0 font-weight-bold text-primary">Lista das Transferências</h6>
                </div>
                <div class="card-body">
                    <div class="tile">
                        <div class="table-responsive">
                            @if ($transfers->isEmpty())
                                <p>Sem transferências.</p>
                            @else
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Valor</th>
                                            <th>Remetente</th>
                                            <th>Destinatário</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transfers as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->valor }}</td>
                                                <td>{{ $item->from_address }}</td>
                                                <td>{{ $item->to_address }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    function copyAddress() {
        const addressInput = document.getElementById('destinoAddress');
        const copyButton = document.getElementById('copyButton');

        addressInput.select();
        addressInput.setSelectionRange(0, 99999); // Para dispositivos móveis
        document.execCommand('copy');

        copyButton.title = 'Copiado';

        // Atualiza o título do botão
        copyButton.setAttribute('title', 'Copiado');
        copyButton.classList.add('btn-success');
        setTimeout(() => {
            copyButton.classList.remove('btn-success');
            copyButton.setAttribute('title', '');
        }, 2000);
    }
</script>
@endsection
