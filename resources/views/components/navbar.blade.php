<nav class="navbar">
    <div class="logo">
        <a href="{{ route('home') }}" class="logo-text">Tickeasy</a>
    </div>
    <div class="nav-links">
        <a href="{{ route('home') }}">Inicio</a>

        <!-- MENU -->
        <div class="dropdown">
            <button class="dropbtn">Categorías</button>
            <div class="dropdown-content">
                @if(auth()->check() && auth()->user()->role == 1)
                    <!-- Opciones para administradores -->
                    <a href="{{ route('events.index') }}">Mostrar Todos</a>
                    @foreach($categories as $category)
                        <a href="{{ route('events.index', ['category' => $category->id]) }}">{{ $category->name }}</a>
                    @endforeach
                @else
                    <!-- Opciones para usuarios normales -->
                    <a href="{{ route('events.public') }}">Mostrar Todos</a>
                    @foreach($categories as $category)
                        <a href="{{ route('events.public', ['category' => $category->id]) }}">{{ $category->name }}</a>
                    @endforeach
                @endif
            </div>
        </div>


        <!-- OPCIONES ADMIN -->
        @auth
            @if(auth()->user()->role == 1) <!-- Si el usuario es admin -->
                <a href="{{ route('admin.users.index') }}">Administrar Usuarios</a>
                <a href="{{ route('events.index') }}">Eventos <span> </span></a>
                <a href="{{ route('categories.index') }}">Categorías <span> </span></a>
                <a href="{{ route('places.index') }}">Ubicaciones</a>
            @endif

            <!-- Menú de perfil -->
            <div class="dropdown">
                <button class="dropbtn">Perfil <span> </span></button>
                <div class="dropdown-content">
                    <a href="{{ route('profile') }}">Ver Perfil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Cerrar Sesión</button>
                    </form>
                </div>
            </div>
        @else
            <a href="{{ route('register') }}">Unirse <span> </span></a>
        @endauth
    </div>
</nav>
