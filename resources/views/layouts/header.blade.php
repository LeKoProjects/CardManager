<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <div class="topbar-divider d-none d-sm-block"></div>
        <!-- Demais itens -->
        <li class="nav-item dropdown no-arrow" id="walletDropdownMenu">
            <a class="nav-link dropdown-toggle" href="{{ route('lancamento.usuario') }}" id="walletDropdown" role="button"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-wallet fa-sm fa-fw mr-2 text-gray-600"></i>
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    @if ($valorTotalUSD > 0)
                        USD | {{ number_format($valorTotalUSD, 2, ',', '.') }}
                    @else
                        USD | 0.00
                    @endif
                </span>
            </a>
        </li>
        

        <!-- User -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Sair
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-warning">
        {{ session('error') }}
    </div>
@endif

