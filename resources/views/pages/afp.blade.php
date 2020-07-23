@extends('layout')

@section('titutlo')
    Elección AFP | Grupo Verfrut
@endsection

@section('contenido')
    <div class="container p-5 text-center">
        <h3>Elección de Sistema Pensionario</h3>
        <div class="py-5">
            <div id="agregar-afp"></div>
            <script>
                sessionStorage.setItem('data', JSON.stringify(@json($data)) );
            </script>
        </div>
    </div>
@endsection
