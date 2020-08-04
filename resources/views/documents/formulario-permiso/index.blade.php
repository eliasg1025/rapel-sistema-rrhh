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
    }

    .table th, .table td {
        border: 1px solid black;
        padding: 5px;
    }

    .bold {
        font-weight: bold;
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
                    <h2 style="text-align: center">FORMULARIO PERMISO</h2>
                </td>
            </tr>
        </table>
        <br /><br />
        <div style="font-size: 13px">
            <table class="table">
                <tr>
                    <td class="bold">NOMBRE TRABAJADOR:</td>
                    <td>{{ $formulario->trabajador->nombre_completo }}</td>
                </tr>
                <tr>
                    <td class="bold">DNI:</td>
                    <td>{{ $formulario->trabajador->rut }}</td>
                    <td class="bold">COD:</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="bold">CARGO:</td>
                    <td>{{ $formulario->oficio->name }}<td>
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
                    <td>{{ $formulario->motivo_permiso->name }}</td>
                    <td>{{ $formulario->motivo_permiso->code }}</td>
                </tr>
            </table>
            <br />
            <span class="bold">* Solo debe ser llenado por el TOPICO</span>
            <br />
            <table class="table">
                <tr>
                    <td class="bold">Nombre del Jefe Inmediato (Supervisor, Jefe de Faena, y/o Área):</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="bold">Labor que realizaba</td>
                    <td></td>
                </tr>
            </table>
            <br />
            <table class="table">
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
            <table>
                <tr>
                    <td>HORA SALIDA:</td>
                    <td>{{ $formulario->hora_salida }}</td>
                    <td>HORA REGRESO:</td>
                    <td>{{ $formulario->hora_regreso }}</td>
                    <td>HORAS DE PERMISO:</td>
                    <td>{{ $formulario->total_horas }}</td>
                </tr>
            </table>
            <br />
            <span class="bold">TIPO DE TRABAJADOR:</span>
            <table>
                <tr>
                    <td>EMPLEADO:</td>
                    <td>{{ $formulario->regimen->id === 1 || $formulario->regimen->id === 2 ? 'X' : '' }}</td>
                    <td>OBRERO:</td>
                    <td>{{ $formulario->regimen->id === 3 ? 'X' : ''  }}</td>
                </tr>
                <tr>
                    <td>CON GOCE DE SUELDO</td>
                    <td>{{ $formulario->goce === 1 ? 'X' : '' }}</td>
                    <td>SIN GOCE DE SUELDO</td>
                    <td>{{ $formulario->goce === 0 ? 'X' : '' }}</td>
                </tr>
            </table>
            <br />
            <table>
                <tr>
                    <td class="bold">FECHA DE LA PRESENTACION:</td>
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
        <br />
    </section>
@endsection
