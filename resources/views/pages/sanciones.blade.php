@extends('layout')

@section('titulo')
    Sanciones | Grupo Verfrut
@endsection

@section('contenido')
    <div id="sanciones"></div>
    <script>
        sessionStorage.setItem('data', JSON.stringify(@json($data)) );
    </script>
@endsection
