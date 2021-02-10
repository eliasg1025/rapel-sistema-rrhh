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
    <section style="font-size: 12.5px; padding: 25px;">
        <img style="float: right;" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate($codigo)) !!}" />
        <div >
            Piura, {{ $finiquito->fecha_finiquito_larga }}
        </div>
        <br /><br />
        <div style="font-weight: bold;">
            SEÑOR (A)(ITA):<br />
            {{ $finiquito->persona->nombre_completo }}<br />
            DNI: {{ $finiquito->persona_id }}<br />
            {{ $finiquito->persona->direccion }}<br />
            Presente   .-<br />
        </div>
        <br /><br />
        <div class="justify">
            <p>Estimado señor(a):</p>
            <p>
                Por medio del presente documento comunicamos a Ud. que con fecha, <b>{{ $finiquito->fecha_inicio_periodo_larga }}</b>, inicio su relación laboral con nosotros, es en este sentido que usted se encuentra dentro del periodo de prueba y evaluación por parte de su empleador.
            </p>
            <p>
                Debemos indicar que hemos tomado la decisión de extinguir el vínculo laboral que usted mantenía  con la empresa. Nuestra decisión de extinguir el vínculo laboral se funda estrictamente en la política de  la empresa, luego de una evaluación  permanente que mantenemos con nuestro personal.
            </p>
            <p>
                Procedemos a resolver su contrato de trabajo de conformidad con lo establecido por el artículo 10 del T.U.O. de la Ley de Productividad y Competitividad Laboral aprobado por D.S. 03-97-TR, donde se establece que los primeros tres meses de labores constituyen período de prueba.
            </p>
            <p>
                Debemos indicarle que de corresponderle conforme a ley, le estaremos comunicando a la brevedad la fecha de pago de sus beneficios sociales, a fin de que previa comunicación con nosotros, se apersone a nuestras oficinas a recabarlos.
            </p>
            <p>
                Por lo antes expuesto, le comunicamos que a partir de la fecha de recepción del presente documento, se dará término a la relación laboral.
            </p>
            <p>
                Sin otro particular, quedamos de usted, agradeciéndole por los servicios prestados.
            </p>
        </div>
        <br />
        <div style="margin-left: -280">
            <div class="text-center">
                <img src="{{public_path() . '/img/PostFirma - Daniel E  ' . $finiquito->empresa->shortname . ' SAC.jpg'}}" width="180"  alt="logo empresa"><br />
                ___________________________________<br /><br />
                <b>{{ $finiquito->empresa->name }}</b><br />
                <b>{{ $finiquito->empresa->ruc }}</b>
            </div>
            <br />
            <p class="text-center">Recibí copia de la presente carta:</p>
            <br />
            <div class="text-center" style="margin-top: 60px">
                ___________________________________<br /><br />
                <b>FIRMA DEL TRABAJADOR</b>
            </div>
        </div>
    </section>
@endsection
