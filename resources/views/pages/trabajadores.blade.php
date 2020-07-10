@extends('home-layout')

@section('titulo')
    Trabajadores | Grupo Verfrut
@endsection

@section('contenido')
    <div id="trabajadores-layout" data-props="{{ json_encode($data) }}"></div>
@endsection
