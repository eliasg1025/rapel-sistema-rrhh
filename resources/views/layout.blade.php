<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('titulo')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">
            <img src="/img/logo-grupo-verfrut.png" alt="" width="100px">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="/perfil">{{ $data['usuario']->trabajador->nombre_completo ?? '' }}</span></a>
                </li>
            </ul>
            @if (Request::path() === '/')
                <form class="form-inline my-2 my-lg-0" method="POST" action="/logout">
                    @csrf
                    <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Cerrar Sesión</button>
                </form>
            @else
                <form class="form-inline my-2 my-lg-0" method="POST" action="/logout">
                    <a class="btn btn-outline-danger my-2 my-sm-0" href="/">Salir</a>
                </form>
            @endif
        </div>
    </nav>
    @yield('contenido')
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
