@extends('layout')

@section('titulo')
    Cuentas | Grupo Verfrut
@endsection

@section('contenido')
    <div class="container p-5">
        <div class="text-center">
            <h3>Cuentas</h3>
        </div>
        <div class="py-5">
            <div id="agregar-cuenta"></div>
            <script>
                const data = @json($data);
                console.log(data);
                sessionStorage.setItem('data', JSON.stringify(data) );
            </script>
        </div>
        <hr />
        @yield('tabla')
    </div>
@endsection
