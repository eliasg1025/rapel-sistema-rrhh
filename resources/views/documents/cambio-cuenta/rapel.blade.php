@extends('pdf-layout')

@section('titulo')
    CAMBIO CUENTA RAPEL
@endsection


<style>
    * {
        font-family: Arial, Helvetica, sans-serif;
    }
</style>

@section('contenido')
    <section style="border: 2px solid black; padding: 15px">
        <div style="text-align: center">
            <img src="{{ public_path() . '/img/Logo Documentos2.jpg' }}" alt="" width="300px">
        </div>
        <br />
        <h3 style="text-align: center">INFORMACION PARA DEPOSITOS DE REMUNERACIONES</h3>
        <br />
        <div style="padding: 10px; padding-left: 25px">
            <p>NOMBRE: {{ $cuenta->trabajador->nombre_completo }}</p>
            <p>DNI: {{ $cuenta->trabajador->rut }}</p>
            <p>FECHA SOLICITUD: {{ $cuenta->fecha_format }}</p>
        </div>
        <br />
        <div style="text-align: center; font-weight: bold">
            SEÑORES<br/><br />
            SOCIEDAD AGRICOLA RAPEL S.A.C.<br /><br />
            AGREDECERÉ A USTEDES EFECTUAR EL PAGO DE MIS<br /><br />
            REMUNERACIONES A TRAVES DE DÉPOSITO EN:<br /><br />
        </div>
        <div style="padding: 10px; padding-left: 25px">
            <p>NOMBRE DE BANCO: {{ $cuenta->banco->name }}</p>
            <p>TIPO DE CUENTA:   SUELDO</p>
            <p>NUMERO DE CUENTA: {{ $cuenta->numero_cuenta }}</p>
        </div>
        <br />
        <table style="width: 90%; margin: auto">
            <tr>
                <td>
                    <p>
                        FIRMA: ___________________
                    </p>
                </td>
                <td>
                    <div style="border: 1px solid black; width: 100px; height: 150px; "></div><small>Huella Digital</small>
                </td>
            </tr>
        </table>
        <br /><br />
    </section>
@endsection
