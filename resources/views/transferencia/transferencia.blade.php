{{-- @extends('layouts.app')

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
                                        <div class="col-md-6">
                                            <label class="form-label">Valor</label>
                                            <input name="valor" id="valor" class="form-control" type="text" required>
                                        </div>
                                    </div>
                                    <div class="row mt-3" style="display: none">
                                        <div class="col-md-12">
                                            <label class="form-label">Moeda</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="currency" id="trx" value="trx">
                                                <label class="form-check-label" for="trx">TRX</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="currency" id="usdt" value="usdt" checked>
                                                <label class="form-check-label" for="usdt">USDT</label>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <button type="button" onclick="transfer()" class="btn btn-primary">Transferir</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-success" onclick="checkTronWeb()">Conectar a TronLink <i class="fas fa-solid fa-link"></i></button>
                                        </div>
                                    </div>
                                </form>
                                <input type="hidden" id="destino_address" value="{{ $destino->address }}">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tronweb/2.12.0/tronweb.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tronweb"></script>
    <script src="{{ asset('js/trx.js') }}"></script>

    <script>
        async function transfer() {
            const currency = document.querySelector('input[name="currency"]:checked').value;
            // const valor = document.getElementById('valor').value * 1e6; // Convertendo para Sun
            const valor = document.getElementById('valor').value; // Convertendo para Sun
            const to = document.getElementById('destino_address').value;

            if (currency === 'trx') {
                await transferTRX(to, valor);
            } else if (currency === 'usdt') {
                await transferUSDT(to, valor);
            } else {
                alert('Moeda selecionada é inválida.');
            }
        }

        async function checkTronWeb() {
            if (!window.tronWeb || !window.tronWeb.defaultAddress.base58) {
                alert('Please log in to TronLink first.');
                return;
            }
            alert('TronLink is connected');
        }
    </script>
@endsection --}}
