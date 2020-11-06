@extends('layout')

@section('titulo')
    Elección AFP | Grupo Verfrut
@endsection

@section('contenido')
    <div id="afp"></div>
    <script>
        sessionStorage.setItem('data', JSON.stringify(@json($data)) );
    </script>
@endsection
