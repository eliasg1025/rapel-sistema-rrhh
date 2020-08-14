@extends('layout')

@section('titulo')
    Grupo Verfrut
@endsection

@section('contenido')
    <div id="main-layout" data-props="{{ json_encode($data) }}"></div>
@endsection
