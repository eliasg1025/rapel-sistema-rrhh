@extends('layout')

@section('titulo')
    Sanciones | Grupo Verfrut
@endsection

@section('contenido')
    <div class="container p-5">
        <div class="text-center">
            <h3>Sanciones</h3>
            <span>{{ $data['usuario']['sanciones'] == 2 ? '(Modo Administrador)' : '' }}</span>
        </div>
        <div class="py-5">
            <div id="agregar-sancion"></div>
            <script>
                sessionStorage.setItem('data', JSON.stringify(@json($data)) );
            </script>
        </div>
    </div>
@endsection
