@extends('layout')

@section('titulo')
    Formularios de permisos | Grupo Verfrut
@endsection

@section('contenido')
    <div class="container p-5">
        <div class="text-center">
            <h3>Formularios de Permisos</h3>
            <span>{{ $data['usuario']['permisos'] == 2 ? '(Modo Administrador)' : '' }}</span>
        </div>
        <div class="py-5">
            <div id="agregar-permiso"></div>
            <script>
                sessionStorage.setItem('data', JSON.stringify(@json($data)) );
            </script>
        </div>
    </div>
@endsection
