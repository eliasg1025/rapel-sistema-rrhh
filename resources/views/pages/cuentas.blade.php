@extends('layout')

@section('titutlo')
    Cuentas | Grupo Verfrut
@endsection

@section('contenido')
    <div class="container p-5 text-center">
        <h3>Cuentas</h3>
        <div class="py-5">
            <div id="agregar-cuenta" data-props="{{ json_encode($data) }}"></div>
        </div>
        <hr />
        <div class="pt-2">
            <h4>Registrados del {{ date('d/m/Y') }}</h4>
            <br />
            <table class="table">
                <thead>
                    <tr>
                        <th>Fecha de solicitud</th>
                        <th>DNI</th>
                        <th>Trabajador</th>
                        <th>Banco</th>
                        <th>Cuenta</th>
                        <th>Empresa</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['cuentas'] as $cuenta)
                        <tr>
                            <td>{{ $cuenta->fecha_format }}</td>
                            <td>{{ $cuenta->trabajador->rut }}</td>
                            <td>{{ $cuenta->trabajador->nombre_completo }}</td>
                            <td>{{ $cuenta->banco->name }}</td>
                            <td>{{ $cuenta->numero_cuenta }}</td>
                            <td>{{ $cuenta->empresa->id === 9 ? 'RAPEL' : 'VERFRUT' }}</td>
                            <td>
                                <a href="/ficha/cambio-cuenta/{{ $cuenta->id }}" target="_blank">
                                    Ver
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
