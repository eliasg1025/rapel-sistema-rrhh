@extends('layout')

@section('titulo')
    Elección AFP | Grupo Verfrut
@endsection

@section('contenido')
    <div class="container p-5">
        <div class="text-center">
            <h3>Elección de Sistema Pensionario</h3>
        </div>
        <span>{{ $data['usuario']['afp'] == 2 ? '(Administrador)' : '' }}</span>
        <div class="py-5">
            <div id="agregar-afp"></div>
        </div>
    </div>
    <script>
        sessionStorage.setItem('data', JSON.stringify(@json($data)) );
    </script>
@endsection
