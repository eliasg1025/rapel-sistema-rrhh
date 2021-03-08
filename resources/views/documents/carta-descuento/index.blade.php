@extends('pdf-layout')

@section('titulo')
    CARTA DESCUENTO
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

    .b-none {
        border: none !important;
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

    .page-break {
        page-break-after: always;
    }
</style>

@section('contenido')
    <section style="font-size: 14px; padding: 25px;">
        <img style="float: right;" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate($codigo)) !!}" />
        <div >
            Piura, {{ $renovacion->fecha_solicitud_larga }}
        </div>
        <br /><br />
        <div style="font-weight: bold;">
            Señores:<br />
            {{ $renovacion->empresa->name }}<br />
            {{ $renovacion->empresa_id == 14 ? 'EYHERALDE MUNITA DANIEL JOSE' : 'CARRILLO CURAY FEDERICO' }}<br />
            Atte   .-<br />
        </div>
        <br /><br />
        <div class="justify">
            <p>Estimado (a) Sr. (a) (ita):</p>
            <p>
                Me dirijo a usted a fin de comunicarle que en el cumplimiento de mis funciones y debido a una falla personal he ocasionado los siguientes daños:
            </p>
            <p>
                <ul>
                    <li><b>Perdida de Fotochek</b></li>
                </ul>
            </p>
            <p>
                En tal sentido, por medio del presente acepto mi responsabilidad por los daños indicados, e igualmente autorizo se realice el descuento en mi remuneración mensual, cuyo importe asciende a S/. {{ $renovacion->motivo->costo }} (CINCO CON 00/100 SOLES), lo que significa la reparación de los daños antes mencionados.
            </p>
            <p>
                El referido descuento se realizará en 1 cuota(s) de S/. {{ $renovacion->motivo->costo }} (CINCO CON 00/100 SOLES) a partir del mes de {{ $renovacion->mes_pago }}.
            </p>
            <p>
                Así las cosas, en caso se termine la relación laboral y no se hubiese completado con el pago de la(s) cuota(s) indicada(s), autorizo se realice el cobro del saldo faltante de mi liquidación de beneficios sociales.
            </p>
            <p>
                Atentamente,
            </p>
        </div>
        <br />
        <div style="margin-left: -280">
            <br />
            <div class="text-center" style="margin-top: 60px">
                ___________________________________<br /><br />
                <b>FIRMA DEL TRABAJADOR</b><br />
                {{ $renovacion->trabajador->apellido_paterno . ' ' . $renovacion->trabajador->apellido_materno . ' ' . $renovacion->trabajador->nombre }}<br />
                DNI: {{ $renovacion->trabajador->rut }}
            </div>
        </div>
    </section>
@endsection
