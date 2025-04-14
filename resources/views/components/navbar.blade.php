<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold " href="{{ route('home') }}">Tickeasy</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTickeasy" aria-controls="navbarTickeasy" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTickeasy">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Inicio</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="categoriasDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Categorías
                    </a>
                    <ul class="footer dropdown-menu" aria-labelledby="categoriasDropdown">
                        @if(auth()->check() && auth()->user()->role == 1)
                            <li><a class="dropdown-item text-white text-start" href="{{ route('events.index') }}">Mostrar Todos</a></li>
                            @foreach($categories as $category)
                                <li><a class="dropdown-item text-white text-start" href="{{ route('events.index', ['category' => $category->id]) }}">{{ $category->name }}</a></li>
                            @endforeach
                        @else
                            <li><a class="dropdown-item text-white text-start" href="{{ route('events.public') }}">Mostrar Todos</a></li>
                            @foreach($categories as $category)
                                <li><a class="dropdown-item text-white text-start" href="{{ route('events.public', ['category' => $category->id]) }}">{{ $category->name }}</a></li>
                            @endforeach
                        @endif
                    </ul>
                </li>

                @auth
                    @if(auth()->user()->role == 1)
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.users.index') }}">Usuarios</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('events.index') }}">Eventos</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('categories.index') }}">Categorías</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('places.index') }}">Ubicaciones</a></li>
                    @endif
                @endauth
            </ul>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="perfilDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Perfil
                        </a>
                        <ul class="footer dropdown-menu dropdown-menu-end" aria-labelledby="perfilDropdown">
                            <li><a class="dropdown-item text-white text-start" href="{{ route('profile') }}">Mi Perfil</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-white text-start">Cerrar Sesión</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registrarse</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
