@extends('layout')

@section('titulo')
    Mi Perfil | Grupo Verfrut
@endsection

@section('contenido')
    <div id="perfil"></div>
    <script>
        sessionStorage.setItem('data', JSON.stringify(@json($data)));
    </script>
@endsection
