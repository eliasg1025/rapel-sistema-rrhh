@extends('layout')

@section('titutlo')
    Elección AFP | Grupo Verfrut
@endsection

@section('contenido')
    <div class="container p-5 text-center">
        <h3>Elección de Sistema Pensionario</h3>
        <div class="py-5">
            <script>
                const data = @json($data);
                console.log(data);
                sessionStorage.setItem('data', JSON.stringify(data) );
            </script>
        </div>
    </div>
@endsection
