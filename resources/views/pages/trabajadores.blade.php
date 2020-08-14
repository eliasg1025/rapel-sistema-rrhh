@extends('layout')

@section('titulo')
    Ingresos | Grupo Verfrut
@endsection

@section('contenido')
    <div id="trabajadores-layout" data-props="{{ json_encode($data) }}"></div>
@endsection
