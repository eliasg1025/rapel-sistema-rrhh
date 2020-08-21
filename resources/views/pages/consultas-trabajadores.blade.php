@extends('layout')

@section('titulo')
    Consulta de Trabajadores | Grupo Verfrut
@endsection

@section('contenido')
<div class="container p-5">
    <div class="text-center">
        <h3>Consulta de Trabajadores</h3>
        <span>{{ $data['usuario']['consultas_trabajadores'] == 2 ? '(Modo Administrador)' : '' }}</span>
    </div>
    <div class="py-5">
        <div id="consulta-trabajadores"></div>
    </div>
</div>
<script>
    sessionStorage.setItem('data', JSON.stringify(@json($data)) );
</script>
@endsection
