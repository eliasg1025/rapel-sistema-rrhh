@extends('layout')

@section('titulo')
    Registro Fotocheck | Grupo Verfrut
@endsection

@section('contenido')
    <div id="registro-fotochecks"></div>
<script>
    sessionStorage.setItem('data', JSON.stringify(@json($data)) );
</script>
@endsection
