<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,600,800" rel="stylesheet">
</head>
<body>
    <div class="container-register">
        <div class="image-register">
            <img src="{{ asset('img/register-image.png') }}" alt="Imagen Registro">
        </div>

        <form class="form-register" action="{{ route('register.post') }}" method="POST">
            @csrf
            <h1>Registro</h1>

            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" required>

            <label for="last_name">Apellidos:</label>
            <input type="text" id="last_name" name="last_name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Registrarse</button>

            <div class="login-link">
                ¿Tiene una cuenta? <a href="{{ route('login') }}">Inicie Sesión</a>
            </div>

            @if ($errors->any())
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </form>
    </div>
</body>
</html>
