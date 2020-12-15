@extends('layout')

@section('titulo')
    Seguros Vida Ley | Grupo Verfrut
@endsection

@section('contenido')
    <div id="seguros-vida"></div>
    <script>
        sessionStorage.setItem('data', JSON.stringify(@json($data)) );
    </script>
@endsection
