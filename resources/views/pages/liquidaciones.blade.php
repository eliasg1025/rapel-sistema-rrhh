@extends('layout')

@section('titulo')
    Liquidaciones | Grupo Verfrut
@endsection

@section('contenido')
    <div id="liquidaciones"></div>

    <script>
        sessionStorage.setItem('data', JSON.stringify(@json($data)) );
    </script>
@endsection
