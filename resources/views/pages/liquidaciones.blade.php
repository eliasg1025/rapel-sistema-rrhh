@extends('layout')

@section('titulo')
    Liquidaciones | Grupo Verfrut
@endsection

@section('contenido')
    @if( $data['usuario']['liquidaciones'] == 1 )
        <div class="container p-5">
            <div class="text-center">
                <h3>Pago de Liquidaciones y Utilidades</h3>
                <span>{{ $data['usuario']['liquidaciones'] == 2 ? '(Modo Administrador)' : '' }}</span>
            </div>

            <div class="py-5">
                <div id="consultar-estado-liquidacion"></div>
            </div>
        </div>
    @else
        <div id="admin-liquidaciones"></div>
    @endif

    <script>
        sessionStorage.setItem('data', JSON.stringify(@json($data)) );
    </script>
@endsection
