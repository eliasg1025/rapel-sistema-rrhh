@extends('layout')

@section('titulo')
    Formularios de Permisos | Grupo Verfrut
@endsection

@section('contenido')
    {{-- <div class="container">
        <div class="text-center">
            <h3>Formularios de Permisos</h3>
            <span>{{ $data['usuario']['permisos'] == 2 ? '(Modo Administrador)' : '' }}</span>
        </div>
        <div class="py-5" style="font-size: 10px;">
            <div id="agregar-permiso"></div>
        </div>
    </div> --}}
    <div id="formularios-permisos"></div>
    <script>
        sessionStorage.setItem('data', JSON.stringify(@json($data)) );
    </script>
@endsection
