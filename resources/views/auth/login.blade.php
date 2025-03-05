<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,600,800" rel="stylesheet">
</head>
<body>
    <div class="container-login">
        <form class="form-login" action="{{ route('login.post') }}" method="POST">
            @csrf
            <h1>Iniciar Sesión</h1>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Iniciar Sesión</button>

            <div class="register-link">
                ¿No tiene una cuenta? <a href="{{ route('register') }}">Regístrese</a>
            </div>

            @if ($errors->any())
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </form>

        <div class="image-login">
            <img src="{{ asset('img/login_image.png') }}" alt="Imagen Login">
        </div>
    </div>
</body>
</html>
