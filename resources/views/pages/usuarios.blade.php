@extends('home-layout')

@section('titulo')
    Usuarios | Grupo Verfrut
@endsection

@section('contenido')
    <div id="usuarios-layout" data-props="{{ json_encode($data) }}"></div>
@endsection
