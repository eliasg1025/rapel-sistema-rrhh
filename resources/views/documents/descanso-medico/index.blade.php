@extends('pdf-layout')

@section('titulo')
    INFORME DESCANSO MÉDICO
@endsection

<style>
    * {
        font-family: Arial, Helvetica, sans-serif
    }

    .table {
        border-collapse: collapse;
        width: 100%;
    }

    .table th, .table td {
        border: 1px solid black;
        padding: 5px;
    }

    .text-center {
        text-align: center;
    }

    .bold {
        font-weight: bold;
    }

    .w-100 {
        width: 100%;
    }

    .box {
        border: 1px black solid;
        height: 15px;
        width: 15px;
        margin: auto;
    }

    .justify {
        text-align: justify;
    }
</style>


@section('contenido')
    <section style="font-size: 13px">
        <table>
            <tr>
                <td>
                    <div style="text-align: center">
                        <img
                            src="{{ public_path() . '/img/Logo Documentos' . ($informe->empresa_id == 9 ? '2' : '1') . '.jpg' }}"
                            alt="" width="100px"
                        >
                    </div>
                </td>
            </tr>
        </table>
        <div style="text-align: center">
            <u><b>{{ $informe->informe }}/BS/{{ $informe->empresa }}</b></u>
        </div>
        <br /><br />
        <table class="w-100">
            <tr>
                <td><b>PARA:</b></td>
                <td>
                    <b>FEDERICO CARRILLO CURAY</b><br />
                    Jefe de RRHH -  Sociedad Agrícola Rapel SAC
                </td>
            </tr>
            <tr>
                <td><b>DE:</b></td>
                <td>
                    <b>{{ $informe->trabajador }}</b><br />
                    Asistente(a) Social - Sociedad Agrícola Rapel SAC
                </td>
            </tr>
            <tr>
                <td><b>ASUNTO:</b></td>
                <td>
                    Informe de Justificaciones - Descansos Médicos
                </td>
            </tr>
            <tr>
                <td><b>FECHA:</b></td>
                <td><b>{{ $informe->fecha_inicio }}</b></td>
            </tr>
        </table>
        <hr />
        <p>
            A través del presente informe se da a conocer la relación de descansos médicos y justificaciones de los trabajadores de Sociedad Agrícola Rapel SAC
        </p>
        <br />
        <table style="font-size: 10.5px" class="table">
            <thead>
                <tr>
                    <th>COD.</th>
                    <th>DNI</th>
                    <th>APELLIDOS Y NOMBRES</th>
                    <th>CONTINGENCIA</th>
                    <th>FUNDO</th>
                    <th>DEL</th>
                    <th>AL</th>
                    <th>TOTAL</th>
                    <th>OBSERVACIONES</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($informe->registros as $item)
                    <tr>
                        <td>{{ $item->code }}</td>
                        <td>{{ $item->rut }}</td>
                        <td>{{ $item->nombre_completo_trabajador }}</td>
                        <td>{{ $item->contingencia }}</td>
                        <td>{{ $item->zona_labor }}</td>
                        <td>{{ $item->fecha_inicio }}</td>
                        <td>{{ $item->fecha_fin }}</td>
                        <td>{{ $item->total_dias }}</td>
                        <td>{{ $item->observacion }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
@endsection
