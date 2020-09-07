@extends('layout')

@section('titulo')
    Estado de Documentos | Grupo Verfrut
@endsection

@section('contenido')
    <div id="estado-documentos"></div>
    <script>
        sessionStorage.setItem('data', JSON.stringify(@json($data)) );
    </script>
@endsection
