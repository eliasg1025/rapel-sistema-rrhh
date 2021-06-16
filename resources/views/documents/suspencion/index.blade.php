@extends('pdf-layout')

@section('titulo')
    CARTA DE SUSPENCIÓN
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
                    <h3 style="text-align: center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CARTA DE SUSPENSIÓN</h3>
                </td>
                <td>
                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate($codigo)) !!}" />
                </td>
            </tr>
        </table>
        <br />
        <div style="padding: auto 40px auto 40px;">
            <p class="justify">
                <b>Señor (a), (ita):</b><br />
                <b>{{ $sancion->trabajador->nombre_completo_doc }}</b><br />
                <b>DNI: {{ $sancion->trabajador->rut }}</b><br />
                Presente .-
            </p>
            <p class="justify">
                <b>{{ $sancion->empresa->name }}</b> Identificada con RUC Nº {{ $sancion->empresa->ruc }}, debidamente representada por el
                Sr. Daniel José Eyheralde Munita, identificado con Carnet de Extranjería N° 001555417, domiciliada en el
                {{ $sancion->empresa->direccion }}, centro donde usted labora, prestando los servicios de <b>{{ $sancion->oficio->name }}</b>,
                a usted atentamente dice:
            </p>
            @if ($sancion->incidencia->name === 'INCUMPLIMIENTO DE FUNCIONES (SUSPENCION)')
                <ol>
                    <li><u>Que Ud. Ha incurrido en falta al cumplimiento de sus obligaciones en el sentido siguiente:</u></li>
                </ol>
                <div style="padding-left: 40px;">
                    <p><b>Haber Incumplido con sus funciones asignadas.</b></p>
                </div>
            @else
                <ol>
                    <li><u>No cumplir con las Normas de Seguridad y Salud en el trabajo.</u></li>
                </ol>
            @endif

            @if (in_array($sancion->incidencia->name, ['NO USAR MASCARILLA', 'NO USAR PROTECTOR FACIAL', 'NO USAR MASCARILLA (PLANTA)', 'NO USAR PROTECTOR FACIAL (PLANTA)']))
                <p class="justify">
                    El hecho ocurrió el día <b>{{ $sancion->fecha_incidencia_largo }}</b>, según informe alcanzado por el supervisor de Recursos Humanos
                    , el cual indica que al {{ $texto[1] }}, se detectó que no usaba su implemento de bioseguridad <b>({{ $texto[0] }})</b>
                    para protegerse, ante este hecho se le recomienda cambiar de actitud y en adelante utilizar los Implementos de Seguridad, los cuales fueron entregados a su persona. En tal sentido le hacemos recordar que debe tomar en cuenta y poner en práctica las sugerencias y capacitaciones que el personal de Seguridad y Salud en el Trabajo realiza en cada capacitación; ello con la finalidad de prevenir accidentes, los cuales se puedan producir  por negligencia suya.
                </p>
            @else
                <p class="justify">
                    El hecho ocurrió el día <b>{{ $sancion->fecha_incidencia_largo }}</b>, {{ $texto[0] ?? '' }}
                </p>
            @endif

            @if ($sancion->incidencia->name === 'INASISTENCIA INJUSTIFICADA')
                <p class="justify">
                    De acuerdo a lo establecido en el Reglamento Interno de Trabajo, toda ausencia al centro de trabajo por motivos de salud u otros imprevistos debe ser comunicada al Jefe inmediato con la finalidad de que este avise al Departamento de Recursos Humanos, con el fin de que la empresa adopte las medidas necesarias.
                </p>
                <p class="justify">
                    Como es de su conocimiento, el asistir al centro de trabajo constituye la principal obligación que emana de su contrato de trabajo, la cual además se encuentra estipulada en el RIT de la empresa, y cuyo incumplimiento afecta el correcto funcionamiento de la empresa generando retrasos en nuestras labores.
                </p>
            @endif
            <p class="justify">
                Esta actitud refleja una falta al cumplimiento de sus obligaciones, quebrando la confianza depositada en usted; incumpliendo con las disposiciones establecidas en el Reglamento Interno de la empresa en el sentido de lo siguiente:
            </p>
            @if (in_array($sancion->incidencia->name, ['NO USAR MASCARILLA', 'NO USAR PROTECTOR FACIAL', 'NO USAR MASCARILLA (PLANTA)', 'NO USAR PROTECTOR FACIAL (PLANTA)']))
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
            @elseif ($sancion->incidencia->name === 'INGRESO DE BEBIDAS ALCOHOLICAS')
                <p><b>Artículo 55°.-</b>son obligaciones del trabajador:</p>
                <div style="padding-left: 10px;">
                    <p>b) Conocer y cumplir con las disposiciones de este reglamento interno de trabajo, del reglamento interno de seguridad y salud en el trabajo de las políticas de aseguramiento de la calidad.</p>
                </div>
                <p><b>Artículo 56°.-</b>Todo trabajador de la empresa debe observar las siguientes prohibiciones:</p>
                <div style="padding-left: 10px;">
                    <p>b) Ingresar bebidas alcohólicas, drogas a las instalaciones de la Empresa.</p>
                    <p>p) La acción u omisión que afecte el normal desarrollo de las actividades de la Empresa.</p>
                </div>
                <p><b>Artículo 63°.-</b>La empresa en su condición de empleadora, es quien ejerce de manera única y exclusiva su facultad disciplinaria, por lo cual puede ejercer las acción es correctivas que considere conveniente, conforme lo establecido en la normativa laboral.</p>
            @elseif ($sancion->incidencia->name === 'ALCOHOLIMETRIA')
                <p><b>Artículo 56°.-</b>Todo trabajador de la empresa debe observar las siguientes prohibiciones:</p>
                <div style="padding-left: 10px;">
                    <p>a) Acudir a laborar bajo los efectos del alcohol, drogas o bajo la influencia de medicamentos que afecten su capacidad para realizar su labor.</p>
                </div>
            @elseif ($sancion->incidencia->name === 'INASISTENCIA INJUSTIFICADA')
                <p><b>Artículo 45°.-</b>En caso que el trabajador se ausente de sus labores sin que se le haya otorgado permiso o licencia, será considerada como ausencia injustificada, y se le aplicará las sanciones previstas en el presente reglamento y las establecidas por la ley.</p>
                <p><b>Artículo 46°.-</b>En el supuesto que el trabajador no pueda acudir a sus labores por razones médicas, deberá comunicar a la empresa antes del tercer día presentando el certificado médico  de Es SALUD (CITT), y en supuesto de atenciones médicas particulares estas deben ser presentadas  con el visado de Es SALUD.</p>
                <p class="justify">
                    Asimismo, el RIT establece claramente que los incumplimientos de las obligaciones señaladas constituyen faltas de carácter disciplinario sujetas a sanción conforme lo establece el  literal C. del artículo 59° del RIT:
                </p>
                <p><b>Artículo 59°.-</b>La empresa, valorando la naturaleza del incumplimiento o falta cometida por el trabajador, podrá efectuar cualquiera de las siguientes medidas disciplinarias:</p>
                <div style="padding-left: 10px;">
                    <p><b>c) Suspensión sin goce de haber.</b></p>
                    <p class="justify">
                        Es la sanción disciplinaria aplicable cuando existan transgresiones de gravedad relativa, ya sea contra la normativa interna de la Empresa o contra las disposiciones laborales vigente.
                        La aplicación de una suspensión sin goce de haber se dará con  sujeción a criterios de razonabilidad y proporcionalidad. La suspensión sin goce de haber es impuesta única y exclusivamente por el departamento de Recursos Humanos a solicitud del Jefe, Supervisor, Coordinador, Encargado y/o Responsable del área en cuestión, con la finalidad de no afectar el funcionamiento regular del Área  y/o Servicio.
                    </p>
                </div>
            @elseif ($sancion->incidencia->name === 'INCUMPLIMIENTO DE FUNCIONES (SUSPENCION)')
                <p><b>Artículo 55°.-</b>son obligaciones del trabajador:</p>
                <div style="padding-left: 10px;">
                    <p>a) Realizar las labores a su cargo de manera eficiente.</p>
                    <p>b) Conocer y cumplir con las disposiciones de este reglamento interno de trabajo, del reglamento interno de seguridad y salud en el trabajo, de las políticas de aseguramiento de la calidad.</p>
                    <p>r) Seguir las instrucciones recibidas de los supervisores.</p>
                </div>
                <p><b>Artículo 56°.-</b>Todo trabajador de la empresa debe observar las siguientes prohibiciones:</p>
                <div style="padding-left: 10px;">
                    <p>p) La acción u omisión que afecte el normal desarrollo de las actividades de la Empresa.</p>
                </div>
            @elseif ($sancion->incidencia->name === 'MAL COMPORTAMIENTO (SUSPENCION)')
                <p><b>Artículo 52°.-</b>son obligaciones del trabajador:</p>
                <div style="padding-left: 10px;">
                    <p>b) Conocer y cumplir con las disposiciones de este reglamento interno de trabajo, del reglamento interno de seguridad y salud en el trabajo, de las políticas de aseguramiento de la calidad.</p>
                    <p>u) Cumplir con las capacitaciones que la Empresa disponga.</p>
                </div>
                <p><b>Artículo 56°.-</b>Todo trabajador de la empresa debe observar las siguientes prohibiciones:</p>
                <div style="padding-left: 10px;">
                    <p>p) La acción u omisión que afecte el normal desarrollo de las actividades de la Empresa.</p>
                </div>
                <p><b>Artículo 62°.-</b>La empresa considera causales de sanción disciplinaria las siguientes:</p>
                <div style="padding-left: 10px;">
                    <p>e) Cometer dentro de las horas de trabajo actos contrarios a la disciplina, higiene o reñidos contra la moral. Colocar ilustraciones, afiches, grabados, cuadros, leyendas, almanaques, etc. en los diferentes ambientes de la empresa.</p>
                </div>
                <br />
                <p>Así como también a incumplido en las normas de seguridad y salud en el trabajo en lo siguiente:</p>
                <p><b>Artículo 7°.-</b></p>
                <div style="padding-left: 10px;">
                    <p>3. Mantener condiciones de orden y limpieza en todos los lugares y actividades.</p>
                </div>
            @endif
            <p class="justify">
                Que, ante este acto de indisciplina, se considera una acción como falta grave, la cual nos faculta a tomar otras decisiones le
                comunicamos que hemos decidido <b>SANCIONARLO CON UNA SUSPENCIÓN POR {{ $sancion->total_horas / 8 }} DIA(S)</b> hábiles sin goce de haber, hecho que se hará efectivo
                el día <b>{{ $sancion->fecha_salida_largo }}</b>  hasta el <b>{{ $sancion->fecha_regreso_largo }}</b> reincorporándose a sus labores el
                día <b>{{ $sancion->fecha_rei_largo }}</b>, el
                presente documento será incorporado a su legajo personal.
            </p>
            <p class="justify">
                Este hecho indica falta de responsabilidad en el cumplimiento de sus obligaciones asumidas por su parte en virtud de la relación
                de trabajo que mantiene con nosotros. En ese sentido le invocamos a que rectifique su conducta; de tal manera que permita el
                normal desarrollo de las actividades y evite que la empresa adopte otras medidas.
            </p>
            <p><b>Atentamente,</b></p>
            <table class="bold w-100" style="text-align: right;">
                <tr>
                   <td>El Papayo, {{ $sancion->fecha_incidencia_largo }}</td>
                </tr>
            </table>
            <table class="bold text-center">
                <tr>
                    <td>
                        <img
                            src="{{ public_path() . '/img/PostFirma - Daniel E  ' . ($sancion->empresa->shortname) . ' SAC.jpg' }}"
                            alt="" width="200px"
                        >
                    </td>
                </tr>
                <tr>
                    <td>
                        ________________________________________<br />
                        {{ $sancion->empresa->name }}<br />
                        {{ $sancion->empresa->ruc }}<br /><br />
                        Acepto la presente suspensión,
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
