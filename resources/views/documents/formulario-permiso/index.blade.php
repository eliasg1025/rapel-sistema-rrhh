@extends('pdf-layout')

@section('titulo')
    FORMULARIO DE PERMISO
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
</style>

@section('contenido')
    <section style="border: 2px solid black; padding: 15px">
        <table>
            <tr>
                <td>
                    <div style="text-align: center">
                        <img
                            src="{{ public_path() . '/img/Logo Documentos' . ($formulario->empresa_id == 9 ? '2' : '1') . '.jpg' }}"
                            alt="" width="100px"
                        >
                    </div>
                </td>
                <td>
                    <h2 style="text-align: center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FORMULARIO DE PERMISO</h2>
                </td>
                <td>
                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate($codigo)) !!}" />
                </td>
            </tr>
        </table>
        <div style="font-size: 12px">
            <table class="table" style="font-size: 12px;">
                <tr>
                    <td class="bold">NOMBRE TRABAJADOR:</td>
                    <td colspan="3">{{ $formulario->trabajador->apellido_paterno }} {{ $formulario->trabajador->apellido_materno }} {{ $formulario->trabajador->nombre }}</td>
                </tr>
                <tr>
                    <td class="bold">DNI:</td>
                    <td>{{ $formulario->trabajador->rut }}</td>
                    <td class="bold">COD:</td>
                    <td>{{ $formulario->trabajador->code }}</td>
                </tr>
                <tr>
                    <td class="bold">CARGO:</td>
                    <td colspan="3">{{ $formulario->oficio->name }}</td>
                </tr>
                <tr>
                    <td class="bold">NOMBRE JEFE ZONA/CAMPO:</td>
                    <td>{{ $formulario->jefe->nombre_completo }}</td>
                    <td class="bold">DNI:</td>
                    <td>{{ $formulario->jefe->rut }}</td>
                </tr>
                <tr>
                    <td class="bold">ZONA/FUNDO:</td>
                    <td>{{ $formulario->zona_labor->name }}</td>
                    <td class="bold">AREA/CAMPO:</td>
                    <td>{{ $formulario->cuartel->name }}</td>
                </tr>
                <tr>
                    <td class="bold">MOTIVO PERMISO:</td>
                    <td colspan="2">{{ $formulario->motivo_permiso->name }}</td>
                    <td>{{ $formulario->motivo_permiso->code }}</td>
                </tr>
            </table>
            <br />
            <span class="bold" style="font-size: 11px">* Solo debe ser llenado por el TOPICO</span>
            <br />
            <table class="table" style="font-size: 11px">
                <tr>
                    <td class="bold">Nombre del Jefe Inmediato<br/>(Supervisor, Jefe de Faena, y/o Área):</td>
                    <td style="width: 70%"></td>
                </tr>
                <tr>
                    <td class="bold">Labor que realizaba</td>
                    <td style="width: 70%; height: 40px;"></td>
                </tr>
            </table>
            <br /><br />
            <table class="table text-center">
                <tr>
                    <td>DESDE</td>
                    <td>{{ $formulario->dia_salida }}</td>
                    <td>de</td>
                    <td>{{ $formulario->mes_salida }}</td>
                    <td>de</td>
                    <td>{{ $formulario->anio_salida }}</td>
                </tr>
                <tr>
                    <td>HASTA</td>
                    <td>{{ $formulario->dia_regreso }}</td>
                    <td>de</td>
                    <td>{{ $formulario->mes_regreso }}</td>
                    <td>de</td>
                    <td>{{ $formulario->anio_regreso }}</td>
                </tr>
            </table>
            <br />
            <table style="width: 80%">
                <tr>
                    <td>HORA SALIDA:</td>
                    <td style="border: 1px solid black; text-align: center">{{ $formulario->hora_salida }}</td>
                    <td>HORA REGRESO:</td>
                    <td style="border: 1px solid black; text-align: center">{{ $formulario->hora_regreso }}</td>
                </tr>
                <tr>
                    <td>HORAS DE PERMISO:</td>
                    <td style="border: 1px solid black; text-align: center">
                        <b>{{ $formulario->total_horas }}</b>
                    </td>
                </tr>
            </table>
            <br />
            <span class="bold">TIPO DE TRABAJADOR:</span>
            <table style="width: 80%;">
                <tr>
                    <td>EMPLEADO:</td>
                    <td class="box">{{ ($formulario->regimen->id === 1 || $formulario->regimen->id === 2 || $formulario->regimen->id === 4) ? 'X' : ' ' }}</td>
                    <td></td>
                    <td>OBRERO:</td>
                    <td class="box">{{ $formulario->regimen->id === 3 ? 'X' : ' '  }}</td>
                </tr>
                @if (!in_array($formulario->motivo_permiso->code, [3, 4]))
                    <tr>
                        <td>CON GOCE DE SUELDO</td>
                        <td class="box">{{ 'X' }}</td>
                        <td></td>
                        <td>SIN GOCE DE SUELDO</td>
                        <td class="box">{{ ' ' }}</td>
                    </tr>
                @else
                <tr>
                    <td>CON GOCE DE SUELDO</td>
                    <td class="box">{{ ' ' }}</td>
                    <td></td>
                    <td>SIN GOCE DE SUELDO</td>
                    <td class="box">{{ ' ' }}</td>
                </tr>
                @endif
            </table>
            <br />
            <table>
                <tr>
                    <td class="bold">FECHA DE LA PRESENTACIÓN:</td>
                    <td>{{ $formulario->fecha_solicitud_format }}</td>
                </tr>
                <tr>
                    <td class="bold">OBSERVACIÓN:</td>
                    <td>{{ $formulario->observacion }}</td>
                </tr>
            </table>
            <br /><br />
            <table style="width: 100%; margin-top: 50px; text-align: center">
                <tr>
                    <td><b>___________________________<br>FIRMA DEL TRABAJADOR</b></td>
                    <td><b>___________________________<br>AUTORIZADO POR:<br />{{ $formulario->jefe->nombre_completo }}</b></td>
                </tr>
            </table>
            <br /><br /><br />
            <table style="width: 100%; margin-top: 50px; text-align: center">
                <tr>
                    <td><b>___________________________<br>V° B° RRHH</b></td>
                    <td><b>___________________________<br>V° B° ADMINISTRADOR/ANALISTA</b></td>
                </tr>
            </table>
        </div>
    </section>
@endsection
