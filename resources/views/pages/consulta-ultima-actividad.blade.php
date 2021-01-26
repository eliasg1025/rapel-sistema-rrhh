@extends('layout')

@section('titulo')
    Consulta Ultima Actividad | Grupo Verfrut
@endsection

@section('contenido')
    <div id="consulta-ultima-actividad"></div>
<script>
    sessionStorage.setItem('data', JSON.stringify(@json($data)) );
</script>
@endsection
