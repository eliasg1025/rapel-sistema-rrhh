@extends('layout')

@section('titulo')
    Planillas Manuales | Grupo Verfrut
@endsection

@section('contenido')
    <div id="planillas-manuales"></div>
<script>
    sessionStorage.setItem('data', JSON.stringify(@json($data)) );
</script>
@endsection
