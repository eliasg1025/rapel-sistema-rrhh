@extends('layout')

@section('titulo')
    Finiquitos Masivos | Grupo Verfrut
@endsection

@section('contenido')
    <div id="finiquitos"></div>
    <script>
        sessionStorage.setItem('data', JSON.stringify(@json($data)) );
    </script>
@endsection
