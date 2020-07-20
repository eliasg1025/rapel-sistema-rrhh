@extends('layout')

@section('titulo')
    Grupo Verfrut
@endsection

@section('contenido')
    <div class="container p-5 text-center">
        <div class="py-5">
            <h4>No tiene acceso al módulo de <u style="text-transform: uppercase">{{ $nombre_modulo }}</u></h4>
        </div>
        <br />
        <a href="/panel"><i class="fas fa-long-arrow-alt-left"></i> Regresar</a>
    </div>
@endsection
