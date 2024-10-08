<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/home">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-solid fa-gift"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Manager<br>Gift Card</div>
        {{-- <sup>2</sup> --}}
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <!-- <a class="nav-link" href="/home">
            <i class="fas fa-fw fa-table"></i>
            <span>Home</span></a> -->
        <!-- <a class="nav-link" href="{{ route('dashboard') }}">
            <i class=" fas fa-solid fa-chart-pie"></i>
            <span>Dashboard</span>
        </a> -->
        <!-- <a class="nav-link" href="{{route('lancamento.usuario')}}">
            <i class="fas fa-solid fa-store"></i>
            <span>Minhas Compras</span></a> -->
        <a class="nav-link" href="{{ route('solicitacoes.criar') }}">
            <i class="fas fa-solid fa-envelope"></i>
            <span>Solicitar Códigos</span></a>
        {{-- <a class="nav-link" href="{{route('transferencia.index')}}">
            <i class="fas fa-solid fa-wallet"></i>
            <span>Transferências</span></a> --}}
    </li>

    
    <!-- Nav Item - Pages Collapse Menu -->
    @if (auth()->user()->tipo == 1)
        <!-- Divider -->
        <hr class="sidebar-divider">

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Lançamentos</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('lancamento.index') }}">Criar</a>
                    <a class="collapse-item" href="{{ route('lancamento.indexLista') }}">Lista de Lançamentos</a>
                    <a class="collapse-item" href="{{ route('lancamento.controle') }}">Controle</a>
                    <a class="collapse-item" href="{{ route('lancamento.liberar') }}">Liberar</a>
                </div>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('solicitacoes.lista') }}">
                <i class="fas fa-envelope"></i>
                <span>Solicitações</span>
            </a>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link" href="{{route('transferencia.index2')}}">
                <i class="fas fa-solid fa-wallet"></i>
                <span>Transferências</span></a>
        </li> --}}
        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Utilidades</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Cadastros:</h6>
                    <a class="collapse-item" href="{{ route('tipo.index') }}">Tipo Gift Card</a>
                    <a class="collapse-item" href="{{ route('status.index') }}">Status</a>
                    <a class="collapse-item" href="{{ route('moedas.index') }}">Moedas</a>
                    <a class="collapse-item" href="{{ route('usuario.index') }}">Usuários</a>
                </div>
            </div>
        </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
<script>
        $(document).ready(function() {
        $('#sidebarToggle').on('click', function() {
            $('#accordionSidebar').toggleClass('sidebar-visible sidebar-hidden');
        });
    });
</script>
<style>
    .sidebar-hidden {
        transform: translateX(-250px); /* Esconder o sidebar para a esquerda */
        transition: transform 0.3s ease-in-out; /* Duração e tipo da animação */
    }

    .sidebar-visible {
        transform: translateX(0); /* Mostrar o sidebar */
        transition: transform 0.3s ease-in-out; /* Duração e tipo da animação */
    }
</style>