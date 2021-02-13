@extends('layout')

@section('titulo')
    Programación de Retornos | Grupo Verfrut
@endsection

@section('contenido')
    <div id="retorno-vacaciones"></div>
    <script>
        sessionStorage.setItem('data', JSON.stringify(@json($data)) );
    </script>
@endsection
