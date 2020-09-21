@extends('layout')

@section('titulo')
    Cuentas | Grupo Verfrut
@endsection

@section('contenido')
    <div id="cuentas"></div>
    <script>
        sessionStorage.setItem('data', JSON.stringify(@json($data)) );
    </script>
@endsection
