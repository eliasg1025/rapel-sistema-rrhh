@extends('pdf-layout')

@section('titulo')
    MEMORANDUM
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
    <section style="font-size: 14px;">
        <table style="width: 100%;">
            <tr>
                <td>
                    <div style="text-align: center">
                        <img
                            src="{{ public_path() . '/img/Logo Documentos' . ($sancion->empresa_id == 9 ? '2' : '1') . '.jpg' }}"
                            alt="" width="100px"
                        >
                    </div>
                </td>
                <td>
                    <h3 style="text-align: center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MEMORANDUM RR.HH. N°{{ $sancion->getCorrelativo($sancion->fecha_incidencia) }} - {{ $sancion->anio }}</h3>
                </td>
                <td>
                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate($codigo)) !!}" />
                </td>
            </tr>
        </table>
        <br />
        <div style="padding: auto 40px auto 40px;">
            <table class="bold w-100">
                <tr>
                    <td>PARA</td>
                    <td>:</td>
                    <td>{{ $sancion->trabajador->nombre_completo }}<br/>{{ $sancion->trabajador->rut }}</td>
                </tr>
                <tr>
                    <td>DE</td>
                    <td>:</td>
                    <td>{{ $sancion->empresa->id === 9 ? 'FEDERICO CARRILLO CURAY' : 'DANIEL JOSE EYHERALDE MUNITA'}}<br/>{{ $sancion->empresa_id === 9 ? 'JEFE DE RECURSOS HUMANOS' : 'APODERADO' }}</td>
                </tr>
                <tr>
                    <td>ASUNTO</td>
                    <td>:</td>
                    <td>AMONESTACIÓN ESCRITA</td>
                </tr>
            </table>
            <br /><hr /><br />
            <p class="justify">
                <b>{{ $sancion->empresa->name }}</b> Identificada con RUC Nº {{ $sancion->empresa->ruc }}, debidamente representada por el
                Sr. {{ 'Daniel José Eyheralde Munita, identificado con Carnet de Extranjería N° 001555417' }}, domiciliada en el
                {{ $sancion->empresa->direccion }}, centro donde usted labora, prestando los servicios de <b>{{ $sancion->oficio->name }}</b>,
                a usted atentamente dice:
            </p>
            @if ($sancion->incidencia_id === 7)
                <ol>
                    <li>Que Ud. Ha incumplido con las normas de la empresa en el sentido siguiente:</li>
                </ol>
                <p class="justify">
                    Este hecho se produjo el día {{ $sancion->fecha_incidencia_largo }}, donde usted ocasionó daños a la propiedad de la empresa, por lo que se le recomienda ser más cuidadoso al realizar su labor, con la finalidad de evitar perjuicios  a los bienes de la empresa, en tal sentido, se le recomienda cambiar de actitud, y cumplir con sus funciones de manera eficiente.
                </p>
                <p class="justify">
                    Esta actitud refleja una falta al cumplimiento de sus obligaciones, quebrando la confianza depositada en usted, habiendo incumplido lo establecido en el Reglamento Interno de Trabajo.
                </p>
                <p>
                    <b>CAPITULO VII:</b> DERECHOS Y OBLIGACIONES DE LOS TRABAJADORES.
                </p>
                <p><b>Artículo 55°.-</b> Son obligaciones del trabajador:</p>
                <div style="padding-left: 10px;">
                    <p>b) Conocer y cumplir con las disposiciones de este reglamento interno de trabajo, del reglamento interno de seguridad y salud en el trabajo de las políticas de aseguramiento de la calidad.</p>
                </div>
                <p><b>Artículo 56°.-</b> Todo trabajador debe observar las siguientes prohibiciones</p>
                <div style="padding-left: 10px;">
                    <p>p) La acción u omisión que afecte el normal desarrollo de las actividades de la Empresa.</p>
                </div>
                <br />
                <p>
                    Estos artículos han sido vulnerados toda vez que usted ha incurrido en faltas al incumplimiento de las normas y procedimientos de la Empresa. Por lo tanto, se recomienda cambiar de actitud y cumplir con las normas establecidas por la empresa.
                </p>
                <p>
                    Que, ante este acto de inconducta funcional e incumplimiento de obligaciones de trabajo, nos vemos en la lamentable situación de otorgarle la presente amonestación por escrito y <b>LLAMAR LA ATENCIÓN POR IMCUMPLIENTO DE OBLIGACIONES</b>, el presente documento será incorporado a su legajo personal.
                </p>
                <p>
                    Este hecho indica falta de responsabilidad en el cumplimiento de sus obligaciones asumidas por su parte en virtud de la relación de trabajo que mantiene con nosotros. En ese sentido le invocamos a que rectifique su conducta; de tal manera que permita el normal desarrollo de las actividades y evite que la empresa tome otras medidas.
                </p>
            @elseif ($sancion->incidencia_id === 10)
                <ol>
                    <li>Que Ud. Ha incurrido en falta al mal comportamiento en el sentido siguiente:</li>
                </ol>
                <p class="justify">
                    El hecho se produce el día {{ $sancion->fecha_incidencia_largo }} cuando se encontraba realizando sus labores, adopto una actitud inadecuada con la persona encargada, por lo que se recomienda cambiar de actitud y en adelante, evitar ese tipo de comportamiento, limitándose a cumplir eficientemente con las políticas, normas y procedimientos que la empresa disponga; absteniéndose de realizar actos de indisciplina o falta de respeto al resto de colaboradores.
                </p>
                <p>Esta actitud refleja una falta al cumplimiento de sus obligaciones, quebrando la confianza depositada en usted, habiendo incumplido lo establecido en el Reglamento Interno de  Seguridad y salud en el sentido de lo siguiente:</p>
                <p><b>Artículo 54°.–</b> Todo trabajador tiene derecho a:</p>
                <div style="padding-left: 10px;">
                    <p>d) Ser tratado con justicia, dignidad y respeto.</p>
                </div>
                <p><b>Artículo 55°.-</b> Son obligaciones del trabajador:</p>
                <div style="padding-left: 10px;">
                    <p>a) Realizar las labores a su cargo de manera eficiente.</p>
                    <p>b) Conocer y cumplir con las disposiciones de este reglamento interno de trabajo, del reglamento interno de seguridad y salud en el trabajo de las políticas de aseguramiento de la calidad.</p>
                    <p>t) Mantener en todo momento respeto, lealtad y consideración por sus compañeros de trabajo, superiores y colaboradores de menor jerarquía.</p>
                </div>
                <p><b>Artículo 56°.-</b> Todo trabajador de la empresa debe observar las siguientes prohibiciones:</p>
                <div style="padding-left: 10px;">
                    <p>p) La acción u omisión que afecte el normal desarrollo de las actividades de la empresa.</p>
                </div>
            @elseif ($sancion->incidencia_id === 17)
                <ol>
                    <li>Que Ud. Ha incurrido en falta al cumplimientos de sus obligaciones en el sentido siguiente:</li>
                </ol>
                <p class="justify">
                    Presentar reiteradas inasistencias, sin presentar justificación alguna, lo que ocasiona retrasos en las labores programadas, se le recomienda cambiar de actitud y cumplir con los deberes como trabajador y funciones asignadas, caso contrario se procederá a tomar otras medidas correctivas.
                </p>
                <p class="justify">
                    Esta actitud refleja una falta al cumplimiento de sus obligaciones, quebrando la confianza depositada en usted, habiendo incumplido lo establecido en el Reglamento Interno de Trabajo.
                </p>
                <p style="text-align: center;">
                    <b>CAPITULO V</b><br />
                    <b>NORMAS DE PERMANENCIA EN EL PUESTO DE TRABAJO, DE LAS AUSENCIAS, PERMISOS Y LICENCIAS</b>
                </p>
                <p class="justify">
                    <b>Artículo 45°.-</b> En caso que el trabajador se ausente de sus labores sin que se le haya otorgado permiso o licencia, será considerada como ausencia injustificada, y se le aplicará las sanciones previstas en el presente Reglamento y las establecidas por ley. Cuando el trabajador no pueda concurrir al centro de labores por razones de enfermedad o imprevistos, deberá avisar dentro de la primera hora de haberse iniciado la jornada de trabajo, a su supervisor jerárquico inmediato y/o gerente de área con la finalidad de que empresa adopte las medidas necesarias para el normal desarrollo de sus actividades.
                </p>
                <p class="justify">
                    <b>Artículo 50°.-</b> En el supuesto que el trabajador supere los tres (03) días de ausencia consecutivos sin que hubiese comunicado a la empresa, se procederá a iniciar el proceso de despido por causal de abandono de trabajo.
                </p>
                <p class="justify">
                    <b>Artículo 56.-</b> Todo trabajador de la empresa debe observar las siguientes prohibiciones:<br />
                    <b>p)</b> La acción u omisión que afecte el normal desarrollo de las actividades de la empresa.
                </p>

                <p>Estos artículos han sido vulnerados toda vez que usted ha incurrido en faltas al incumplimiento de las normas y procedimientos de la Empresa.</p>
            @elseif ($sancion->incidencia_id != 5)
                <ol>
                    <li>Que Ud. Ha incumplido con las normas de la empresa en el sentido siguiente:</li>
                </ol>
                <p class="justify">
                    El hecho ocurrió el día <b>{{ $sancion->fecha_incidencia_largo }}</b>, según informe alcanzado por el supervisor de Recursos Humanos, el cual indica que al realizar las labores correspondientes de campo, se detectó que no usaba su implemento de {{ $texto[0] === 'Alcohol' ? 'bio' : '' }}seguridad <b>({{ $texto[0] }})</b> para protegerse, ante este hecho se le recomienda cambiar de actitud y en adelante utilizar los Implementos de Seguridad, los cuales fueron entregados a su persona.
                </p>
                <p>
                    En tal sentido le hacemos recordar que debe tomar en cuenta y poner en práctica las sugerencias y capacitaciones que el personal de Seguridad y Salud en el Trabajo realiza en cada capacitación; ello con la finalidad de prevenir accidentes, los cuales se puedan producir  por negligencia suya.
                </p>
                <p class="justify">
                    Esta actitud refleja una falta al cumplimiento de sus obligaciones, quebrando la confianza depositada en usted; incumpliendo con las disposiciones establecidas en el Reglamento Interno de la empresa en el sentido de lo siguiente:
                </p>
                <p><b>Artículo 55°.-</b>son obligaciones del trabajador:</p>
                <div style="padding-left: 10px;">
                    <p>b) Conocer y cumplir con las disposiciones de este reglamento interno de trabajo, del reglamento interno de seguridad y salud en el trabajo de las políticas de aseguramiento de la calidad.</p>
                    <p>n) Usar los equipos de protección personal conforme las indicaciones dadas y según las normas de higiene y salud de la empresa.</p>
                    <p>r) Seguir las instrucciones recibidas por los supervisores.</p>
                </div>
                <p>Así como también está; incumpliendo con las disposiciones establecidas en el Reglamento de seguridad y salud en el trabajo, en el sentido de lo siguiente:</p>
                <p><b>Artículo 7°.-</b></p>
                <div style="padding-left: 10px;">
                    <p>1.	Cumplir con las disposiciones en el reglamento interno de seguridad y salud en el trabajo, las normas, estándares e instrucciones de los programas de seguridad y salud ocupacional.</p>
                    <p>7.   Todo trabajador es absolutamente  responsable de velar por su propia salud y su seguridad personal en el trabajo.</p>
                    <p>19.  Evitar exponerse a peligros que atenten contra su integridad física y salud personal.</p>
                </div>
            @else
                <ol>
                    <li>Que Ud. Ha incurrido en falta al cumplimientos de sus obligaciones en el sentido siguiente:</li>
                </ol>
                <p class="justify">
                    Usted trabajador no está cumpliendo con sus funciones, puesto que el <b>{{ $sancion->fecha_incidencia_largo }}</b>, se le encontró haciendo otras funciones que su jefe desconocía, generándose así retrasos en su información, por lo que se recomienda cambiar de actitud y en adelante, evitar ese tipo de comportamiento, limitándose a cumplir eficientemente con las políticas, normas y procedimientos que la empresa disponga, esta actitud refleja una falta al cumplimiento de sus obligaciones y responsabilidades, quebrantando la confianza depositada en usted.
                </p>
                <p class="justify">
                    Usted ha incumplido con las disposiciones establecidas en el Reglamento Interno de la empresa en el sentido de lo siguiente:
                </p>
                <p>
                    <b>Capítulo VII°. –DE LOS DERECHOS Y OBLIGACIONES DE LOS TRABAJADORES</b>
                </p>
                <p><b>Artículo 55°.-</b>son obligaciones del trabajador:</p>
                <div style="padding-left: 10px;">
                    <p>a) Realizar las labores a su cargo de manera eficiente.</p>
                    <p>b) Conocer y cumplir con las disposiciones de este reglamento interno de trabajo, del reglamento interno de seguridad y salud en el trabajo de las políticas de aseguramiento de la calidad.</p>
                </div>
                <p><b>Artículo 56°.-</b>Todo trabajador de la empresa debe observar las siguientes prohibiciones:</p>
                <div style="padding-left: 10px;">
                    <p>p) La acción u omisión que afecta el normal desarrollo de las actividades de la empresa.</p>
                </div>
                <p>
                    Estos artículos han sido vulnerados toda vez que usted ha incurrido en faltas al incumplimiento de las normas y procedimientos de la Empresa.
                </p>
            @endif

            @if ($sancion->incidencia_id !== 7)
                <p class="justify">
                    Que, ante este acto de inconducta funcional e incumplimiento de obligaciones de trabajo, nos vemos en la lamentable situación de otorgarle la presente amonestación por escrito y <b>LLAMAR LA ATENCIÓN POR IMCUMPLIENTO DE OBLIGACIONES</b>, el presente documento será incorporado a su legajo personal.
                </p>
                <p class="justify">
                    En este sentido, le solicitamos que en lo sucesivo preste el estricto cumplimiento de lo dispuesto en las normas y procedimientos de la empresa, de lo contrario, se adoptarán las medidas pertinentes, por lo cual deseamos que esta carta sirva para la reflexión y se evite reiteración.
                </p>
            @endif
            <p><b>Atentamente,</b></p>
            <table class="bold w-100" style="text-align: right;">
                <tr>
                   <td>El Papayo, {{ $sancion->fecha_incidencia_largo }}</td>
                </tr>
            </table>
            <table class="bold text-center">
                <tr>
                    <td>
                        @if ($sancion->empresa_id === 9)
                            <img
                                src="{{ public_path() . '/img/Firma-Federico.jpg' }}"
                                alt="" width="200px"
                            >
                        @else
                            <img
                                src="{{ public_path() . '/img/PostFirma - Daniel E  ' . ($sancion->empresa->shortname) . ' SAC.jpg' }}"
                                alt="" width="200px"
                            >
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>
                        ________________________________________<br />
                        {{ $sancion->empresa->name }}<br />
                        {{ $sancion->empresa->ruc }}<br /><br /><br />
                        Acepto la presente amonestación por escrito,
                    </td>
                </tr>
            </table>
            <table class="bold text-center">
                <tr>
                    <td>
                        <div style="height: 100px;"></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        _______________________________________<br />
                        {{ $sancion->trabajador->nombre_completo }}<br />
                        DNI: {{ $sancion->trabajador->rut }}
                    </td>
                </tr>
            </table>
        </div>
    </section>
@endsection
