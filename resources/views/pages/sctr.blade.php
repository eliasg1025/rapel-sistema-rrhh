@extends('layout')

@section('titulo')
    SCTR | Grupo Verfrut
@endsection

@section('contenido')
    <div id="sctr"></div>
    <script>
        sessionStorage.setItem('data', JSON.stringify(@json($data)) );
    </script>
@endsection
