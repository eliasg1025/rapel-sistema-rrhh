@extends('layout')

@section('titutlo')
    Formularios de permisos | Grupo Verfrut
@endsection

@section('contenido')
    <div class="container p-5 text-center">
        <h3>Formularios de permisos</h3>
        <div class="py-5">
            <div id="agregar-permiso"></div>
            <script>
                sessionStorage.setItem('data', JSON.stringify(@json($data)) );
            </script>
        </div>
    </div>
@endsection
