@extends('pdf-layout')

@section('titulo')
    {{ $finiquito->tipoCese->name }}
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
    <section style="font-size: 14.5px; padding: -25px 25px 25px 25px;">
        <table style="width: 100%;">
            <tr>
                <td style="text-align: center">
                    
                </td>
                <td style="text-align: center">
                    
                </td>
                <td style="text-align: right">
                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate($codigo)) !!}" />
                </td>
            </tr>
            <tr>
                <td style="text-align: center">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </td>
                <td style="text-align: center">
                    <h3 class="text-center">CARTA POR TERMINO DE CONTRATO</h3>
                </td>
                <td style="text-align: center">
                    
                </td>
            </tr>
        </table>
        <br />
        <div style="float: right;">
            El Papayo, {{ $finiquito->fecha_finiquito_larga }}
        </div>
        <br /><br />
        <div style="font-weight: bold;">
            SEÑOR (A)(ITA):<br />
            {{ $finiquito->persona->nombre_completo }}<br />
            DNI: {{ $finiquito->persona_id }}<br />
            {{ $finiquito->persona->direccion }}<br />
            Presente   .-<br />
        </div>
        <br />
        <div class="justify">
            <p>Estimado señor(a):</p>
            <br />
            <p>
                Comunico  a Ud. que con fecha <b>{{ $finiquito->fecha_finiquito_larga }}</b>,  culminará su contrato  por lo que se ha visto conveniente poner término al vínculo laboral que mantenía  con la empresa, habiendo optado por no renovarlo; por lo que nuestra empresa agradece sus servicios prestados.
            </p>
            <p>
                Debo indicarle  que le estaremos comunicando a la brevedad la fecha de pago  que corresponde de acuerdo a ley, a fin de que previa comunicación se apersone a nuestras oficinas.
            </p>
            <p>
                Por lo antes expuesto damos  término a la relación laboral de manera armoniosa.
            </p>
        </div>
        <br />
        <div class="text-center">
            <img src="{{public_path() . '/img/PostFirma - Daniel E  ' . $finiquito->empresa->shortname . ' SAC.jpg'}}" width="200"  alt="logo empresa"><br />
            ___________________________________<br /><br />
            <b>{{ $finiquito->empresa->name }}</b><br />
            <b>{{ $finiquito->empresa->ruc }}</b>
        </div>
        <br />
        <p class="text-center">Recibí copia de la presente carta:</p>
        <br />
        <div class="text-center" style="margin-top: 100px">
            ___________________________________<br /><br />
            <b>FIRMA DEL TRABAJADOR</b>
        </div>
    </section>
@endsection
