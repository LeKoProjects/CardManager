@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Lançamentos</h6>
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
                            @foreach ($lancamento as $item)
                                <tr>
                                    <td>{{ $item->codigo }}</td>
                                    <td>{{ $item->moeda->abreviacao }} {{ $item->moeda->moeda }}</td>
                                    <td>{{ $item->valor }}</td>
                                    <td>{{ $item->tipo->nome }}</td>
                                    <td>
                                        @if(auth()->user()->tipo == 1)
                                            <select class="form-control status-select" data-lancamento-id="{{ $item->id }}" style="text-align: center">
                                                <option selected></option>
                                                @foreach ($status as $statuss)
                                                    <option value="{{ $statuss->id }}" {{ $item->status_id == $statuss->id ? 'selected' : '' }}>{{ $statuss->nome }}</option>
                                                @endforeach
                                            </select>
                                        @elseif(auth()->user()->tipo != 1 && $item->status_id == 2)
                                            {{ $item->status->nome }}
                                        @else
                                            @if(!$item->user_id)
                                                <select class="form-control status-select" data-lancamento-id="{{ $item->id }}" style="text-align: center">
                                                    <option selected></option>
                                                    @foreach ($status as $statuss)
                                                        @if ($statuss->id == 2)
                                                            <option value="{{ $statuss->id }}" {{ $item->status_id == $statuss->id ? 'selected' : '' }}>{{ $statuss->nome }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            @else
                                                {{ $item->status->nome }}
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.status-select').change(function() {
                var status_id = $(this).val();
                var lancamento_id = $(this).data('lancamento-id');

                $.ajax({
                    url: '{{ route('lancamentos.update-status') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status_id: status_id,
                        lancamento_id: lancamento_id
                    },
                    success: function(response) {
                        alert(response.success);
                        location.reload(); // Reload the page to reflect the changes
                    },
                    error: function(xhr) {
                        alert('Erro: ' + xhr.responseJSON.error);
                    }
                });
            });
        });
    </script>
@endsection
