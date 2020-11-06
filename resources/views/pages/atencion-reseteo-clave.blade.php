@extends('layout')

@section('titulo')
    Atención Cambio Clave | Grupo Verfrut
@endsection

@section('contenido')
    {{-- <div class="container p-5">
        <div class="text-center">
            <h3>Atención Cambio Clave</h3>
            <span>{{ $data['usuario']['reseteo_clave'] == 2 ? '(Modo Administrador)' : '' }}</span>
        </div>
        <div class="py-5">
            <div id="agregar-reseteo-clave"></div>
        </div>
    </div> --}}
    <div id="reseteo-clave"></div>
    <script>
        sessionStorage.setItem('data', JSON.stringify(@json($data)) );
    </script>
@endsection
