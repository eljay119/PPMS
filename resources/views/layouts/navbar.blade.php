<nav class="sb-topnav navbar navbar-expand navbar-light" style="background-color: #0d6efd;">
    <a class="navbar-brand ps-3 d-flex align-items-center text-white" href="{{ route('dashboard') }}">
        <img src="{{ asset('img/bisu.png') }}" alt="BISU Logo" style="width: 40px; height: 40px; margin-right: 10px;">
        @if(Auth::check())
            <span class="text-white">
                {{ Auth::user()->role->name ?? 'Guest' }}
            </span>
        @else
            <span class="text-white">Guest</span>
        @endif
    </a>
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle">
        <i class="fas fa-bars text-white"></i>
    </button>
    <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown">
                <i class="fas fa-user fa-fw text-white"></i> 
                @auth
                    <span class="text-white">{{ Auth::user()->name }}</span>
                @else
                    <span class="text-white">Guest</span>
                @endauth
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#!">Settings</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item">Logout</button>
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>
