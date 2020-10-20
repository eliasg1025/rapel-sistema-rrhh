@extends('layout')

@section('titulo')
    Descansos Médicos | Grupo Verfrut
@endsection

@section('contenido')
    <div id="descansos-medicos"></div>
    <script>
        sessionStorage.setItem('data', JSON.stringify(@json($data)) );
    </script>
@endsection
