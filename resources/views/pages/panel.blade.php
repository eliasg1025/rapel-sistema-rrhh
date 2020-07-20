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
                    <a class="btn btn-block" href="/" {{ $data['usuario']->ingresos === 0 ? 'disabled' : '' }}>Ingresos</a>
                </div>
                <div class="col-md-6">
                    <a class="btn btn-block" href="/cuentas" {{ $data['usuario']->cuentas === 0 ? 'disabled' : '' }}>Cuentas</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <a class="btn btn-block" href="#" {{ $data['usuario']->permisos === 0 ? 'disabled' : '' }}>Formularios de Permisos</a>
                </div>
                <div class="col-md-6">
                    <a class="btn btn-block" href="#" {{ $data['usuario']->afp === 0 ? 'disabled' : '' }}>AFP</a>
                </div>
            </div>
        </div>
        <br />
        <form class="form-inline my-2 my-lg-0" method="POST" action="/logout">
            @csrf
            <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Cerrar Sesión</button>
        </form>
        <script>
            console.log(@json($data['usuario']));
        </script>
    </div>
@endsection
