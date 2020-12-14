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
    <section style="font-size: 14px; padding: -25px 25px 25px 25px;">
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
                    <h3 class="text-center">CARTA DE RENUNCIA</h3>
                </td>
                <td style="text-align: center">
                    
                </td>
            </tr>
        </table>
{{--         <table style="width: 100%;">
            <td style="text-align: center">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </td>
            <td style="text-align: center">
                <h2 class="text-center">CARTA DE RENUNCIA</h2>
            </td>
            <td style="text-align: center">
                <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate($codigo)) !!}" />
            </td>
        </table> --}}
        <br /><br />
        @if ($finiquito->empresa->shortname == 'RAPEL')
            <div>
                Señor:<br />
                Federico Carrillo Curay<br />
                Jefe de Recursos Humanos<br />
                {{ $finiquito->empresa->name }}<br />
                Presente   .-<br />
            </div>
        @else
            <div>
                Señores de :<br />
                Recursos Humanos<br />
                {{ $finiquito->empresa->name }}<br />
                Presente   .-<br />
            </div>
        @endif
        <br />
        <div class="justify">
            <p>De mi especial consideración:</p>
            <br />
            <p>
                Sirve la presente para hacer de su conocimiento mi renuncia irrevocable al puesto de trabajo de&nbsp;&nbsp;<b>{{ $finiquito->oficio->name }}</b>, que vengo desempeñando en la empresa. El motivo al cual obedece esta decisión es por razones estrictamente personales.
            </p>
            <p>
                Deseo agradecer la responsabilidad asignada a mi persona, así como la colaboración de todos mis compañeros de trabajo durante mi permanencia en la empresa. Asimismo, le agradeceré instruir a quien corresponda se sirva exonerarme de los 30 días de preaviso conforme a ley, considerando que el día&nbsp;&nbsp;<b>{{ $finiquito->fecha_finiquito_larga }}</b>, fue mi último día de trabajo.
            </p>
            <p>
                Adicionalmente, solicito se le indique a quien le corresponda se me autorice hacer efectivo mi último sueldo junto con los beneficios de ley y mi certificado de trabajo.
            </p>
            <p>
                Sin otro particular, me despido de usted muy cordialmente.
            </p>
            <br />
            <p>
                Atentamente,
            </p>
        </div>
        <br />
        <div class="text-center" style="margin-top: 120px">
            ___________________________________<br /><br />
            <b>{{ $finiquito->persona->nombre_completo }}</b><br />
            <b>DNI: {{ $finiquito->persona_id }}</b>
        </div>
        <br />
        <div style="margin-top: 80px">
            <b>El Papayo, {{ $finiquito->fecha_finiquito_larga }}</b>
        </div>
    </section>
@endsection
