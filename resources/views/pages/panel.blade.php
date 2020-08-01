@extends('layout')

@section('titulo')
    Panel | Grupo Verfrut
@endsection

@section('contenido')
    <div class="container p-5 text-center">
        <h3>¿Á que módulo deseas entrar?</h3>
        <div class="py-5">
            <div class="row">
                <div class="col-md-6">
                    <a class="btn btn-block btn-light" href="/" {{ $data['usuario']->ingresos === 0 ? 'disabled' : '' }}>
                        <i class="fas fa-arrow-up"></i> Ingresos Personal
                    </a>
                </div>
                <div class="col-md-6">
                    <a class="btn btn-block btn-light" href="/cuentas" {{ $data['usuario']->cuentas === 0 ? 'disabled' : '' }}>
                        <i class="fas fa-money-check"></i> Cambios/Aperturas Cuentas
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <a class="btn btn-block btn-light" href="/formularios-permisos" {{ $data['usuario']->permisos === 0 ? 'disabled' : '' }}>
                        <i class="fas fa-file-powerpoint"></i> Formularios de Permisos
                    </a>
                </div>
                <div class="col-md-6">
                    <a class="btn btn-block btn-light" href="/eleccion-afp" {{ $data['usuario']->afp === 0 ? 'disabled' : '' }}>
                        <i class="fas fa-file-alt"></i> Elección AFP
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <a class="btn btn-block btn-light" href="/atencion-cambio-clave" {{ $data['usuario']->reseteo_clave === 0 ? 'disabled' : '' }}>
                        <i class="fas fa-lock"></i> Cambio Clave TU RECIBO
                    </a>
                </div>
            </div>
        </div>
        <br />
        <form class="form-inline m-auto" method="POST" action="/logout">
            @csrf
            <button class="btn btn-outline-danger m-auto" type="submit">Cerrar Sesión</button>
        </form>
        <script>
            console.log(@json($data['usuario']));
        </script>
    </div>
@endsection
