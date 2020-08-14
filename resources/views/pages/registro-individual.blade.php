@extends('layout')

@section('titulo')
    Ingresos | Grupo Verfrut
@endsection

@section('contenido')
    <div id="registro-individual-layout" data-props="{{ json_encode($data) }}"></div>
@endsection
