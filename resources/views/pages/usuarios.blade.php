@extends('layout')

@section('titulo')
    Usuarios | Grupo Verfrut
@endsection

@section('contenido')
    <div id="usuarios"></div>

    <script>
        sessionStorage.setItem('data', JSON.stringify(@json($data)) );
    </script>
@endsection
