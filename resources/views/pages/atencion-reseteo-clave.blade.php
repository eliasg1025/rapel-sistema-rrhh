@extends('layout')

@section('titulo')
    Atención Reseteo Clave | Grupo Verfrut
@endsection

@section('contenido')
<div class="container p-5 text-center">
    <h3>Atención Reseteo Clave</h3>
    <div class="py-5">
        <div id="agregar-reseteo-clave"></div>
    </div>
</div>
<script>
    sessionStorage.setItem('data', JSON.stringify(@json($data)) );
</script>
@endsection
