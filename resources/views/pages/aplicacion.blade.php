@extends('layout')

@section('titulo')
    Controlador Aplicación Movil | Verfrut
@endsection

@section('contenido')
    <div id="controlador-aplicacion"></div>
    <script>
        sessionStorage.setItem('data', JSON.stringify(@json($data)))
    </script>
@endsection
