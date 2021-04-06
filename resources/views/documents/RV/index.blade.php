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
                Deseo agradecer la responsabilidad asignada a mi persona, así como la colaboración de todos mis compañeros de trabajo durante mi permanencia en la empresa. Asimismo, le agradeceré instruir a quien corresponda se sirva exonerarme de los 30 días de preaviso conforme a ley.
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

    @if (is_null($finiquito->grupo_finquito_id) && $finiquito->regimen->name !== 'Obreros')
        <div class="page-break"></div>

        <div style="font-size: 8px;">
            <table class="table text-center" style="width: 100%">
                <tr>
                    <td>
                        <img src="{{ public_path() . '/img/Logo Documentos' . ($finiquito->empresa_id === 9 ? '2' : '1') . '.jpg'}}" width="50px" />
                    </td>
                    <td colspan="15">
                        <h3 style="margin-top: 0%; margin-bottom: 0%;">FORMATO DE ENCUESTA DE SALUDA</h3>
                    </td>
                    <td colspan="2">FPGRRHH<br />Revisión. 01<br />Pag. 1 de 1</td>
                </tr>
                <tr>
                    <td><b>{{ $finiquito->empresa->name }}</b></td>
                    <td colspan="3">RUC: {{ $finiquito->empresa->ruc }}</td>
                    <td colspan="12">{{ $finiquito->empresa->direccion }}</td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td colspan="18">
                        {{ $finiquito->empresa->name }}; {{ $finiquito->empresa->id === 9 ? 'empresa dedicada al cultivo, procesamiento y comercialización de uva de mesa' : 'empresa dedicada al cultivo, procesamiento y comercialización de uva,banano y fruta de mesa.' }}
                    </td>
                </tr>
                <tr>
                    <td colspan="18">
                        <table style="border-collapse: collapse; margin: auto; width: 70%">
                            <tr>
                                <td class="b-none"><b>APELLIDOS Y NOMBRES</b></td>
                                <td class="b-none">{{ $finiquito->persona->nombre }} {{ $finiquito->persona->apellido_paterno }} {{ $finiquito->persona->apellido_materno }}</td>
                                <td class="b-none"><b>FECHA DE INGRESO</b></td>
                                <td class="b-none">{{ $finiquito->fecha_inicio_periodo }}</td>
                            </tr>
                            <tr>
                                <td class="b-none"><b>CARGO</b></td>
                                <td class="b-none">{{ $finiquito->oficio->name }}</td>
                                <td class="b-none"><b>FECHA DE SALIDA</b></td>
                                <td class="b-none">{{ $finiquito->fecha_finiquito }}</td>
                            </tr>
                            <tr>
                                <td class="b-none"><b>FUNDO</b></td>
                                <td class="b-none">{{ $finiquito->zona_labor }}</td>
                            </tr>
                        </table>
                        <br />
                        <table style="border-collapse: collapse; margin: 5px 20px 5px 20px;">
                            <tr>
                                <td>
                                    Por favor, dedique unos minutos a completar esta encuesta, sus respuestas serán tratadas de forma CONFIDENCIAL y nos ayudarana mejorar como empresa.
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="18">
                        <b>MARCA CON UN (X) LAS ALTERNATIVAS QUE USTED CREA CONVENIENTE</b>
                    </td>
                </tr>
                <tr>
                    <td colspan="18">
                        <b>1. ¿QUÉ ES LO QUE MÁS LE AGRADÓ DE LA EMPRESA?</b>
                    </td>
                </tr>
                <tr>
                    <td colspan="18">
                        <table style="border-collapse: collapse;">
                            <tr>
                                <td class="b-none">a. El ambiente laboral </td>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="b-none">b. El trato de los jefe y supervisores</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="b-none">c. Posibilidad de crecimiento profesional</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="b-none">d. Horarios</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="b-none">e. Sueldo</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="b-none">f. Beneficios complementarios</td>
                                <td></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="18">
                        <b>2. ¿CUÁLES SON LOS MOTIVOS PORQUE DEJA DE TRABAJAR EN {{ $finiquito->empresa->name }}?</b>
                    </td>
                </tr>
                <tr>
                    <td colspan="18">
                        <table style="border-collapse: collapse;">
                            <tr>
                                <td class="b-none">a. Interesado en estudios</td>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="b-none">b. Mejores condiciones económicas</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="b-none">c. Oportunidad de crecimiento profesional</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="b-none">d. Horario de trabajo</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="b-none">e. Descontento con Supervisor o Jefe </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="b-none">f. Movilidad</td>
                                <td></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="18">
                        <b>3. RESPONSABILIDADES</b>
                    </td>
                </tr>
                <tr>
                    <td colspan="18">
                        <table style="border-collapse: collapse;">
                            <tr class="text-center">
                                <td class="b-none"></td>
                                <td><b>SI</b></td>
                                <td><b>NO</b></td>
                            </tr>
                            <tr>
                                <td class="b-none">a. ¿Se le comunicó claramente los objetivos y metas de su puesto de trabajo?</td>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="b-none">b. ¿Se le dieron las herramientas para desempeñar su trabajo?</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="b-none">c. ¿Se le capacitó para el desempeño de sus labores?</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="b-none">d. ¿Sintió un buen ambiente de trabajo?</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="b-none">e. ¿Las relaciones con su jefe fueron satisfactorias?</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="b-none">f. ¿Las relaciones con sus compañeros fueron agradables y positivas?</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="b-none">g. ¿Fue tratado con respeto y equidad?</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="b-none">h. ¿Se cumplieron sus expectativas?</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="b-none">i. ¿Recomendaría a Rapel como un lugar donde trabajar?</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="18">
                        <b>4. ¿Cuán satisfecho se siente usted con la gestión que realiza RECURSOS HUMANOS como área de servicio?</b>
                    </td>
                </tr>
                <tr>
                    <td colspan="18">
                        <table style="border-collapse: collapse;">
                            <tr>
                                <td class="b-none">Muy satisfecho</td>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="b-none">Satisfecho</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="b-none">Poco satisfecho</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="b-none">Nada satisfecho</td>
                                <td></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="18">
                        <b>5. ¿Tiene alguna sugerencia para mejorar las condiciones laborales en {{ $finiquito->empresa->name }}?</b>
                    </td>
                </tr>
                <tr>
                    <td colspan="18">
                        <div style="height: 22px;"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="18">
                        <div style="text-align: left">
                            <b>DNI:</b> {{ $finiquito->persona_id }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <b>Fecha:</b> {{ $finiquito->fecha_finiquito }}
                            <br /><br />
                            <b>Firma</b>
                            <br /><br />
                        </div>
                        <div style="text-align: right">
                            <b>GESTIÓN DEL TALENTO HUMANO</b>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    @endif
@endsection
