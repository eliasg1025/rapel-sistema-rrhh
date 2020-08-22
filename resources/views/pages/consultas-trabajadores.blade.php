@extends('layout')

@section('titulo')
    Consulta de Trabajadores | Grupo Verfrut
@endsection

@section('contenido')
    <div id="consulta-trabajadores"></div>
<script>
    sessionStorage.setItem('data', JSON.stringify(@json($data)) );
</script>
@endsection
