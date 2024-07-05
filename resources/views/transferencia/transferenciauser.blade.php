@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="row">
            <!-- Lista dos Tipos Card -->
            <div class="col-md-12">
                <div class="card shadow mb-7">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Transferências</h6>
                    </div>
                    <div class="card-body">
                        <div class="tile">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr style="text-align: center">
                                            <th>#</th>
                                            <th>Valor</th>
                                            <th>Remetente</th>
                                            <th>Destinatário</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transfers as $item)
                                            <tr style="text-align: center">
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->valor }}</td>
                                                <td>{{ $item->to_address }}</td>
                                                <td>{{ $item->from_address }}</td>
                                            </tr>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
@endsection
