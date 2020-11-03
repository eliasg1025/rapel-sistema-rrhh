@extends('layout')

@section('titulo')
    Ingresos | Grupo Verfrut
@endsection

@section('contenido')
    <div id="ingresos"></div>
    <script>
        sessionStorage.setItem('data', JSON.stringify(@json($data)));
    </script>
@endsection
