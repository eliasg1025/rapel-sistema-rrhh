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
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top" style="z-index: 2">
        <a class="navbar-brand" href="/">
            <img src="/img/logo-grupo-verfrut.png" alt="" width="100px">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link btn btn-light" style="border-radius: 5px;" href="/perfil">
                        <i class="fas fa-user"></i>&nbsp;&nbsp;{{ $data['usuario']->trabajador->nombre_completo ?? '' }}
                    </a>
                </li>
            </ul>
            @if (Request::path() === '/')
                <form class="form-inline my-2 my-lg-0" method="POST" action="/logout">
                    @csrf
                    <button class="btn btn-outline-danger my-2 my-sm-0" type="submit" style="border-radius: 5px;">
                        <i class="fas fa-power-off"></i> Cerrar Sesión
                    </button>
                </form>
            @else
                <form class="form-inline my-2 my-lg-0" method="POST" action="/logout">
                    <a class="btn btn-outline-warning my-2 my-sm-0" style="border-radius: 5px;" href="/">
                        <i class="fas fa-long-arrow-alt-left"></i> Atrás
                    </a>
                </form>
            @endif
        </div>
    </nav>
    @yield('contenido')
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        Pusher.logToConsole = true;

        let pusher = new Pusher('4bcc98f6c9321c69044d', {
            cluster: 'us2',
            encrypted: true
        });

        let channel = pusher.subscribe("notifications-{{ $data['usuario']->username  }}");

        channel.bind('notifications', function(data) {
            alert(JSON.stringify(data));
        })
    </script>
</body>
</html>
