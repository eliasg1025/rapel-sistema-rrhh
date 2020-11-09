@extends('layout')

@section('titulo')
    Bonos | Grupo Verfrut
@endsection

@section('contenido')
    <div id="bonos"></div>
    <script>
        sessionStorage.setItem('data', JSON.stringify(@json($data)))
    </script>
@endsection
