@extends('layout')

@section('titulo')
    Atención Cambio Clave | Grupo Verfrut
@endsection

@section('contenido')
    <div id="reseteo-clave"></div>
    <script>
        sessionStorage.setItem('data', JSON.stringify(@json($data)) );
    </script>
@endsection
