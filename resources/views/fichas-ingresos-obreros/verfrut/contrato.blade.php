@extends('documents.contrato.verfrut')

@section('contrato')
    <section id="page1" class="contrato">
        <div style="float: right">
            <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(80)->generate($codigo)) !!}" />
        </div>
        <br /><br />
        <h4 class="titulo">CONTRATO DE TRABAJO SUJETO A MODALIDAD <b>{{ $contrato->tipo_contrato->name }}</b></h4>
        @if ($contrato->regimen->name === 'Obreros')
            @if ($contrato->tipo_contrato->name === 'INTERMITENTE')
                <p>Conste por el presente documento que se extiende por duplicado, el <b style="text-transform: uppercase">Contrato de Trabajo sujeto a modalidad <span style="text-transform: capitalize">{{ $contrato->tipo_contrato->name }}</span></b> en adelante <b>EL CONTRATO</b>, que se suscribe de conformidad con lo establecido en la Ley N° 31110, Ley del Régimen Laboral Agrario y de Incentivos para el Sector Agrario y Riego, Agroexportador y Agroindustrial; y los artículos 64° al 66° del Texto Único Ordenado del Decreto Legislativo Nº 728, Ley de Productividad y Competitividad Laboral, D.S. Nº 003-97-TR (en adelante LPCL), entre:</p>
                <ul>
                    <li>
                        <b>SOCIEDAD EXPORTADORA VERFRUT S.A.C.</b>, R.U.C. Nº 20601438586, con domicilio en Caserío el Papayo Mz. O, Distrito de Castilla, Provincia y Departamento de Piura, debidamente representada por su Apoderado, <b>Daniel José Eyheralde Munita</b>, identificado con Documento Nacional de Identidad C.E. Nº 001555417, a la que en adelante le denominará <b>EL EMPLEADOR</b>; y de la otra parte,
                    </li>
                    <li>
                        <b><i>{{ $trabajador->apellidos }}, {{ $trabajador->nombre }}</i></b> con DNI o C.E. Nº <b>{{ $trabajador->rut }}</b>, con domicilio en <b>{{ $trabajador->direccion }}</b>, Distrito de <b>{{ $trabajador->distrito->name }}</b>, Provincia de <b>{{ $trabajador->distrito->provincia->name }}</b>, Departamento de <b>{{ $trabajador->distrito->provincia->departamento->name }}</b>, con fecha de nacimiento <b>{{ $trabajador->fecha_format }}</b> y de Nacionalidad <b>{{ $trabajador->nacionalidad->name }}</b>, a quien en adelante se le denominará <b>EL TRABAJADOR</b>.
                    </li>
                </ul>
                <p>En los términos y condiciones que constan en las cláusulas siguientes:</p>
                <ol>
                    <li>
                        <b><u>CLÁUSULA PRIMERA</u>: De las partes.-</b>
                        <br>1.1	<b>EL EMPLEADOR</b> es una persona jurídica de derecho privado, debidamente inscrito en los Registros Públicos de Lima, cuya actividad económica principal es la explotación de bienes raíces y agrícolas, sean estos propios o arrendados, así como la producción, comercialización y exportación de los productos agrícolas y frutícolas originados en esta explotación.
                        <br>1.2	<b>EL TRABAJADOR</b> declara estar capacitado para desempeñarse en el cargo para el que se le contrata, contando con acreditada experiencia para cumplir con la prestación de servicios en el cargo objeto de <b>EL CONTRATO</b>.
                        <br>1.3 Los antecedentes antes señalados y las competencias y aptitudes que son inherentes a los mismos han sido tenidos en especial consideración por <b>EL EMPLEADOR</b> para la contratación de <b>EL TRABAJADOR</b>, acordando las partes que tales competencias y aptitudes tienen el carácter de esenciales para la celebración de este contrato.

                    </li>
                    <li>
                        <b><u>CLÁUSULA SEGUNDA:</u> Causa objetiva de la contratación.-</b>
                        <br>2.1 Considerando la naturaleza agrícola de sus actividades, las mismas que son de carácter permanente pero discontinúo, con períodos de incremento y de inactividad, <b>EL EMPLEADOR</b> requiere contratar a plazo fijo y bajo la modalidad <b>{{ $contrato->tipo_contrato->name }}</b> los servicios de <b>EL TRABAJADOR</b>.
                        <br>2.2	<b>EL EMPLEADOR</b>, conforme lo señalado en el párrafo anterior, precisa que la intermitencia se basa en la naturaleza agrícola de las actividades a desarrollar, las cuales están afectas a factores externos como clima, suelo, crecimiento del producto agrícola, etc. Dichos factores externos escapan al control d<b>el EMPLEADOR</b>, por lo cual la necesidad del recurso humano no puede ser prevista con exactitud, y se irá adecuando en cada oportunidad, según el requerimiento de las áreas involucradas.
                    </li>
                    <li>
                        <b><u>CLÁUSULA TERCERA:</u> Objeto.-</b>
                        <br>3.1	En razón de la causa objetiva señalada en la cláusula anterior, <b>EL EMPLEADOR</b> contrata a plazo fijo bajo la modalidad indicada, los servicios de <b>EL TRABAJADOR</b> para que desempeñe el cargo de {{ $contrato->oficio->name }}.
                        <br>3.2	<b>EL TRABAJADOR</b> conoce y entiende que <b>EL EMPLEADOR</b> cuenta con facultades de dirección reconocida en el artículo 9° de la LPCL, por lo cual, en ejercicio legítimo de la misma, <b>EL EMPLEADOR</b> puede organizar y controlar el buen cumplimiento de las obligaciones de <b>EL TRABAJADOR</b>.
                        <br>3.3	<b>EL EMPLEADOR</b> en función de sus necesidades y requerimientos podrá modificar las condiciones de la prestación de los servicios objeto de la relación laboral, siendo pasibles de variación lo referente a la jornada y horario de trabajo, designación del centro de labores a cualquiera de las sedes que existan en su oportunidad, forma, funciones, categoría, modalidad dentro de los límites que la razonabilidad y la ley establecen. <b>EL TRABAJADOR</b> entiende que dichas variaciones no significan una rebaja de categoría y/o remuneración.
                    </li>
                    <li>
                        <b><u>CLÁUSULA CUARTA:</u> Prestaciones del Trabajador.-</b>
                        <br>8.1	La prestación de los servicios de <b>EL TRABAJADOR</b> comprende todas aquellas actividades relacionadas y complementarias al cargo indicado en la Cláusula Tercera de <b>EL CONTRATO</b>, así como aquellas que se le indiquen en función del cumplimiento de las actividades de <b>EL EMPLEADOR</b>.
                        <br>8.2	<b>EL TRABAJADOR</b>, en base al principio de buena fe laboral, debe cumplir de manera diligente todas las órdenes, disposiciones y directivas que, por necesidades del servicio, imparta <b>EL EMPLEADOR</b> conforme a los términos prescritos en <b>EL CONTRATO</b> y a las facultades de dirección y reglamentación que le corresponden conforme a la legislación vigente.
                    </li>
                    <li>
                        <b><u>CLÁUSULA QUINTA:</u> Plazo del Contrato.-</b>
                        <br>5.1	El plazo de vigencia del presente contrato es de tres (3) mes(es), y rige desde el <b>{{ $contrato->fecha_larga }}</b> hasta el <b>{{ $contrato->fecha_larga_termino }}</b>.
                        <br>5.2 Queda entendido que <b>EL EMPLEADOR</b> no está obligado a dar aviso alguno adicional referente al término del presente contrato, operando su extinción en la fecha de su vencimiento.
                        <br>5.3	Si la naturaleza del trabajo así lo requiere se podrá prorrogar el tiempo de vigencia de <b>EL CONTRATO</b>, en común acuerdo de ambas partes, debiéndose de firmar en este caso la prórroga respectiva.
                        <br>5.4	La suspensión de <b>EL CONTRATO</b>, cualquiera que fuera el supuesto, no interrumpe ni suspende el plazo de extinción de la relación laboral sujeta a plazo fijo. Por ende, si por alguna circunstancia <b>EL TRABAJADOR</b> estuviera percibiendo prestaciones por enfermedad o accidente de trabajo al vencimiento calendario del presente contrato, ello no significa en forma alguna la prolongación del plazo fijo contratado, ni la conversión de éste en indeterminado.
                        <br>Siendo así, simultáneamente a la cesación en la percepción de prestaciones, se producirá la terminación de la relación contractual de trabajo descrita en el presente documento, con efectividad a la fecha de vencimiento del mismo.
                    </li>
                    <li>
                        <b><u>CLÁUSULA SEXTA:</u> Período de Prueba.-</b>
                        <br><b>EL EMPLEADOR</b> señala que conforme a lo establecido en el artículo 10° de la LPCL-, <b>EL TRABAJADOR</b> estará sujeto a un período de prueba de tres (3) meses. <b>EL TRABAJADOR</b> entiende y conoce que durante este período de prueba <b>EL EMPLEADOR</b> podrá extinguir la relación laboral sin expresión de causa, y ello no generará el pago de concepto indemnizatorio alguno.
                    </li>
                    <li>
                        <b><u>CLÁUSULA SÉPTIMA:</u> Jornada y horario de trabajo.-</b>
                        <br>7.1	<b>EL TRABAJADOR</b> deberá cumplir el horario de trabajo señalado por <b>EL EMPLEADOR</b>, la cual será fijada respetando la jornada máxima de 48 horas semanales, ello de conformidad con lo previsto en el artículo 1º del Decreto Supremo Nº 007-2002-TR, Texto Único Ordenado de la Ley de Jornada de Trabajo, Horario y Trabajo en Sobretiempo.
                        <br>7.2 Conforme a ello, las partes convienen en que <b>EL EMPLEADOR</b> de acuerdo con las necesidades operativas que surjan, tendrá la facultad de determinar y variar los días de trabajo, los días de descanso, los horarios y las jornadas de trabajo, toda vez que ambas partes conocen y entienden que las labores a cargo del TRABAJADOR están sujetas a condiciones variables -tanto de suelo como climáticas- por lo cual se requiere que existan las condiciones propicias para que <b>EL TRABAJADOR</b> pueda cumplir con la prestación a su cargo. <b>EL TRABAJADOR</b> presta expreso consentimiento a esta prerrogativa de <b>EL EMPLEADOR</b>.
                        <br>7.3	Las ausencias injustificadas por parte de <b>EL TRABAJADOR</b> implican la pérdida de la remuneración proporcionalmente a la duración de dicha ausencia. Sin perjuicio de ello, <b>EL TRABAJADOR</b> entiende que en los supuestos de ausencias injustificadas <b>EL EMPLEADOR</b> podrá aplicar las medidas disciplinarias que estime convenientes, según su normativa interna, así como lo previsto en la legislación laboral; ello en ejercicio legítimo de su facultad disciplinaria.
                        <br>7.4	<b>EL TRABAJADOR</b> tendrá derecho a gozar de cuarenta y cinco (45) minutos de refrigerio, tiempo que no forma parte de la jornada de trabajo, tal como se establece en el artículo 7° del Texto Único Ordenado de la Ley de Jornada de Trabajo, el cual se hará efectivo en función de la organización del área en la que prestará labores <b>EL TRABAJADOR</b>.
                        <br>7.5	<b>EL EMPLEADOR</b> señala que <b>EL TRABAJADOR</b> tendrá derecho a gozar del día de descanso semanal obligatorio conforme lo establecido en el artículo 1° del Decreto Legislativo N° 713.
                    </li>
                    <li>
                        <b><u>CLÁUSULA OCTAVA:</u> Remuneración.-</b>
                        <br><b>8.1</b> En contraprestación a los servicios prestados por EL TRABAJADOR, EL EMPLEADOR se obliga a pagar una remuneración diaria (jornal) bruta ascendente a S/ 39.19 (TREINTA Y NUEVE CON 19/100 SOLES), remuneración que se encuentra comprendida por el básico de S/ 31.01 (TREINTA Y UNO CON 01/100 SOLES) más el concepto de CTS equivalente al 9.72% de S/ 3.01 (TRES CON 01/100 SOLES)  y el concepto de Gratificaciones de fiestas patrias y de navidad equivalente al 16.66% de S/ 5.17 (CINCO CON 17/100 SOLES), monto del cual se deducirán las aportaciones y descuentos establecidos en la ley. Adicionalmente una Bonificación Especial por Trabajo Agrario (BETA) del 30% de la RMV con carácter no remunerativo. Así mismo el trabajador elegirá recibir los conceptos de CTS y gratificaciones en los plazos que la ley establece, sin que entren a ser prorrateados en la RD; elección que forma parte integrante de este contrato como Anexo 2.
                        <br><b>8.2</b> Ambas partes acuerdan que la modalidad y fecha de pago de la remuneración será fijada y modificada por EL <b>EMPLEADOR</b> de acuerdo con sus necesidades operativas y/o administrativas.
                        <br><b>8.3</b> <b>EL EMPLEADOR</b> al encontrarse acogido al Régimen Agrario, precisa que la remuneración abonada a EL TRABAJADOR incluye la Compensación por Tiempo de Servicios y las Gratificaciones de Fiestas Patrias y de Navidad, más una Bonificación Especial por Trabajo Agrario (BETA) del 30% de la RMV con carácter no remunerativo, conforme lo previsto en los incisos c) y e) de la Ley N° 31110, Ley del Régimen Laboral Agrario y de Incentivos para el Sector Agrario y Riego, Agroexportador y Agroindustrial. De la misma forma, de acuerdo al inciso d) del mismo cuerpo normativo, de forma facultativa, el trabajador elegirá recibir los conceptos de CTS y gratificaciones en los plazos que la ley establece, sin que entren a ser prorrateados en la RD; elección que forma parte integrante de este contrato como Anexo 3.
                        <br><b>8.4</b> Las ausencias injustificadas por parte de <b>EL TRABAJADOR</b> implican la pérdida de la remuneración proporcional a la duración de dicha ausencia, sin perjuicio del ejercicio de las facultades disciplinarias propias de EL EMPLEADOR previstas en las normas laborales y en las normas internas de este último.
                        <br><b>8.5</b> Adicionalmente, las partes acuerdan que, de conformidad con el artículo 19° del Decreto Supremo N° 001-98-TR, modificado por el Decreto Supremo N° 009-2011-TR, <b>EL EMPLEADOR</b> podrá utilizar su firma digitalizada en las boletas de pago. Asimismo, <b>EL EMPLEADOR</b> podrá valerse de tecnologías de la información o comunicación tales como intranet, correo electrónico u otras de similar naturaleza para entregar virtualmente las boletas de pago a <b>EL TRABAJADOR</b>, quien se obliga a acusar recibo por escrito o en forma virtual, dentro del día útil siguiente de recibida virtualmente la boleta de pago, sin perjuicio que EL EMPLEADOR pueda hacer uso de medio distinto, virtual o físico, para acreditar dicha recepción
                        <br><b>8.6</b> <b>EL TRABAJADOR</b> declara que la remuneración señalada en esta cláusula constituye una adecuada compensación por los servicios prestados a <b>EL EMPLEADOR</b>, así como por las obligaciones asumidas en el presente contrato.
                    </li>
                    <li>
                        <b><u>CLÁUSULA NOVENA:</u> Régimen Laboral del Trabajador.-</b>
                        <br><b>EL TRABAJADOR</b> gozará de los beneficios laborales establecidos en la Ley N° 31110, Ley del Régimen Laboral Agrario y de Incentivos para el Sector Agrario y Riego, Agroexportador y Agroindustrial.
                    </li>
                    <li>
                        <b><u>CLÁUSULA DÉCIMA:</u> Entrega de Herramientas de Trabajo.-</b>
                        <br>10.1    <b>EL EMPLEADOR</b> proporcionará a <b>EL TRABAJADOR</b> los materiales y herramientas de trabajo necesarias para el adecuado desarrollo de sus actividades, <b>EL TRABAJADOR</b> será responsable de mantener el buen estado de las herramientas y/bienes de trabajo asignados, los mismas que sólo deben sufrir el desgaste propio y natural provocado por el uso normal.
                        <br>10.2    <b>EL TRABAJADOR</b> será responsable por los daños, pérdidas y/o extravíos de las herramientas y/o bienes de trabajo que se le hayan asignado. En este sentido, <b>EL TRABAJADOR</b> autoriza expresamente a <b>EL EMPLEADOR</b> a deducir de su remuneración, y de ser el caso de su liquidación de beneficios sociales (en caso de extinción de la relación laboral) el costo de la reparación o reposición de la o las herramientas de trabajo.
                    </li>
                    <li>
                        <b><u>CLÁUSULA DÉCIMO PRIMERA:</u> Buena Fe.-</b>
                        <br><b>EL TRABAJADOR</b> se obliga en forma expresa a poner al servicio d<b>el EMPLEADOR</b> toda su capacidad y lealtad, así como a la protección de sus intereses, en razón del cargo para el cual se le contrata. Asimismo, desarrollará las labores encargadas según las indicaciones impartidas por <b>EL EMPLEADOR</b>.
                    </li>
                    <li>
                        <b><u>CLÁUSULA DÉCIMO SEGUNDA:</u> Exclusividad.-</b>
                        <br>Los servicios de <b>EL TRABAJADOR</b> son contratados con el carácter de exclusividad, de manera tal que durante la vigencia de la relación laboral <b>EL TRABAJADOR</b> se compromete a dedicar todo su tiempo, desplegar la energía y aplicar la experiencia que sean necesarios para el servicio y la protección de los intereses de <b>EL EMPLEADOR</b>, no pudiendo dedicarse a actividades por cuenta propia o de terceros que le distraigan del cumplimiento cabal de sus obligaciones para con <b>EL EMPLEADOR</b>.
                    </li>
                    <li>
                        <b><u>CLÁUSULA DÉCIMO TERCERA:</u> Sistema de Pensiones.-</b>
                        <br>De acuerdo a los artículos 15° y 16° de la Ley 28991, <b>EL TRABAJADOR</b> dentro del plazo legal comunicará a <b>EL EMPLEADOR</b> su decisión respecto del derecho a afiliarse a cualquiera de los regímenes previsionales. En el supuesto que <b>EL TRABAJADOR</b> no cumpla con la comunicación indicada, <b>EL EMPLEADOR</b> lo afiliará al Sistema Privado de Pensiones (AFP) en las condiciones señaladas en el artículo 6° del TUO de la Ley del Sistema Privado de Pensiones.
                    </li>
                    <li>
                        <b><u>CLÁUSULA DÉCIMO CUARTA:</u> Seguridad y Salud.-</b>
                        <br>14.1 En cumplimiento de lo establecido en la Ley N° 29783, Ley de Seguridad y Salud en el Trabajo, y habiendo analizado el riesgo de las funciones propias del cargo a desempeñar por <b>EL TRABAJADOR</b>, con la finalidad de dar cumplimiento a las recomendaciones en materia de seguridad y salud destinadas a evitar cualquier riesgo para <b>EL TRABAJADOR</b> durante el desarrollo de las actividades del cargo indicado, se señala de manera expresa la obligación de ejecutar las recomendaciones aplicables, las cuales serán desarrolladas en el Anexo 1 del presente documento.
                        <br>14.2 <b>EL TRABAJADOR</b> entiende que es su obligación conocer el Reglamento de Seguridad y Salud que se le entregará al inicio de la relación laboral, así como asistir a las capacitaciones sobre la materia que sean programadas por <b>EL EMPLEADOR</b>.
                        <br>14.3 <b>EL EMPLEADOR</b> establece de manera expresa que el incumplimiento de obligaciones en materia de seguridad y salud por parte de <b>EL TRABAJADOR</b> son consideradas faltas graves toda vez que suponen un riesgo para la salud e integridad del mismo y de las otras personas que se encuentren en el centro de trabajo. Por lo cual, <b>EL EMPLEADOR</b> establece como lineamiento de actuación el de  “tolerancia cero” respecto a faltas cometidas en materia de seguridad y salud, sancionando las mismas con el despido y la imposibilidad de ser recontratado.
                    </li>
                    <li>
                        <b><u>CLÁUSULA DÉCIMO QUINTA:</u> Del período de inactividad.-</b>
                        <br>15.1 	Conforme la naturaleza intermitente de las actividades realizadas por <b>EL TRABAJADOR</b>, en el supuesto que exista un período de inactividad, <b>EL CONTRATO</b> podrá ser suspendido. El período de suspensión no afecta la vigencia de <b>EL CONTRATO</b>.
                        <br>15.2	La suspensión será comunicada a <b>EL TRABAJADOR</b>, indicándosele la fecha probable del reinicio de las actividades. En el supuesto que en la fecha señalada no existan las condiciones adecuadas para el reinicio de labores, se procederá a indicar una nueva fecha.
                        <br>15.3	El cálculo de los beneficios sociales de ELTRABAJADOR, y el tiempo de servicios se determinarán en función de los períodos efectivamente laborados, razón por la cual los períodos en que no exista prestación efectiva de labores por parte de <b>EL TRABAJADOR</b>, serán considerados suspensión perfecta de labores.
                        <br>15.4	Ambas partes declaran que durante la suspensión perfecta de labores <b>EL TRABAJADOR</b> no deberá asistir al centro de labores, ni realizará labores efectivas, por lo tanto <b>EL EMPLEADOR</b> no abonará remuneración alguna durante dicho período.
                        <br>15.5	<b>EL TRABAJADOR</b> entiende y conoce que la suspensión de labores no genera pago de remuneración durante el período de suspensión; asimismo, conoce y entiende que la suspensión del contrato de trabajo bajo ninguna circunstancia equivale a despido.
                    </li>
                    <li>
                        <b><u>CLÁUSULA DÉCIMO SEXTA:</u> Derecho de preferencia.-</b>
                        <br>16.1 Para la reanudación de las labores suspendidas <b>EL EMPLEADOR</b> verificará que exista necesidad de recurso humano para el desarrollo de las labores descritas en la cláusula segunda; es decir, que el producto agrícola se encuentre en condiciones determinadas para continuar a la siguiente etapa o labor.
                        <br>16.2 <b>EL EMPLEADOR</b> respetará el derecho de preferencia de <b>EL TRABAJADOR</b>, quien contará con un plazo máximo de cinco (5) días hábiles –contados desde la fecha señalada en el comunicado de suspensión- para hacer uso de su derecho de preferencia y proceda a reincorporarse a sus labores.
                        <br>16.3 En el supuesto que no se reincorpore dentro del período de cinco (5) días hábiles, <b>EL CONTRATO</b> se resuelve de pleno derecho, quedando a salvo el derecho de  <b>EL TRABAJADOR</b>  de solicitar la liquidación de sus beneficios sociales que le corresponda.
                    </li>
                    <li>
                        <b><u>CLÁUSULA DÉCIMO SEPTIMA:</u> Condición resolutoria.-</b>
                        <br>17.1 En el supuesto que por lo factores señalados o por cualquier otra circunstancia, la prestación a cargo de <b>EL TRABAJADOR</b> resulte innecesaria o imposible con anterioridad al vencimiento del contrato, <b>EL EMPLEADOR</b> podrá resolver <b>EL CONTRATO</b>.
                        <br>17.2 <b>EL TRABAJADOR</b> declara expresamente que conoce y entiende que la resolución de contrato no equivale a despido, sino que la misma obedece a la imposibilidad de realizar las prestaciones para la cual fue contratado, o a la extinción de la necesidad que dio origen a la celebración de <b>EL CONTRATO</b>.
                    </li>
                    <li>
                        <b><u>CLÁUSULA DÉCIMO OCTAVA:</u> Domicilio.-</b>
                        Las partes señalan como sus respectivos domicilios los especificados en la introducción del presente documento, por lo que se
                        reputarán válidas todas las comunicaciones y notificaciones dirigidas a las mismas con motivo de la ejecución del presente contrato.
                        El cambio de domicilio de cualquiera de las partes surtirá efecto dentro de las 24 horas hábiles posteriores a la comunicación de
                        dicho cambio a la contraparte. <b>EL TRABAJADOR</b> declara conocer que el cambio de domicilio se debe comunicar por medio escrito
                        al Departamento de Recursos Humanos de <b>EL EMPLEADOR</b>.
                    </li>
                    <li>
                        <b><u>CLÁUSULA DÉCIMO NOVENA:</u> Júrisdiccion.-</b>
                        Las partes acuerdan que cualquier controversia, diferencia, problema de interpretación, duda o dificultad que se produzca entre
                        ellas surgida o derivada de la relación jurídica ratificada por este documento o en la ejecución del mismo, o por cualquier otro
                        motivo o circunstancia relacionada directa o indirectamente con él o con los que por causa del presente contrato se celebren, se
                        solucionará siguiendo el procedimiento siguiente:<br />
                        a)&nbsp;&nbsp;En primer lugar, las partes pondrán sus mayores esfuerzos para encontrar directamente una solución amigable.<br />
                        b)&nbsp;&nbsp;En caso de que no se haya logrado acuerdo o éste haya sido parcial, entonces, para los asuntos que no hayan podido ser
                        materia de acuerdo las partes se someten a la competencia de los Juzgados de Trabajo y Salas Laborales o Mixtas de la Corte
                        Superior de Justicia correspondiente, conforme a lo establecido por la Ley Procesal del Trabajo o norma que la sustituya.
                    </li>
                    <li>
                        <b><u>CLÁUSULA VIGÉSIMA:</u> Aplicación e interpretación</b>
                        <br/>Las partes reconocen que EL EMPLEADOR puede emitir las directivas y pautas que correspondan para la aplicación e
                        interpretación de lo expuesto en este contrato.
                    </li>
                    <li>
                        <b><u>CLÁUSULA VIGÉSIMO PRIMERA:</u> Aplicación supletoria de la ley</b>
                        <br/>Las partes señalan que en todo lo no previsto en el presente documento, se regirán por las disposiciones contempladas en el TUO
                        del Decreto Legislativo N° 728, Ley de Productividad y Competitividad Laboral; así como por las demás normas laborales, entre
                        otros dispositivos de nuestro ordenamiento jurídico que le sean pertinentes.
                        <br />En señal de conformidad, las partes intervinientes suscriben el presente documento en dos ejemplares de idéntico tenor, en la
                        ciudad de Piura, el <b>{{ $contrato->fecha_larga }}</b>.
                    </li>
                </ol>
                <p>En señal de conformidad, las partes intervinientes suscriben el presente documento en dos ejemplares de idéntico tenor, en la ciudad de Piura, el <b>{{ $contrato->fecha_larga }}</b>.</p>
                <table style="width: 100%; font-weight: bold; text-align: center; margin-top: 100px">
                    <tr>
                        <td>___________________<br>EL EMPLEADOR</td>
                        <td>___________________<br>EL TRABAJADOR</td>
                    </tr>
                </table>
            @elseif ($contrato->tipo_contrato->name === 'DE TEMPORADA')
                <p>Conste por el presente documento que se extiende por duplicado, el <b style="text-transform: uppercase">Contrato de Trabajo sujeto a modalidad <span style="text-transform: capitalize">{{ $contrato->tipo_contrato->name }}</span></b> en adelante <b>EL CONTRATO</b>, que se suscribe de conformidad con lo establecido en la Ley N° 31110, Ley del Régimen Laboral Agrario y de Incentivos para el Sector Agrario y Riego, Agroexportador y Agroindustrial y los artículos 64° al 66° del Texto Único Ordenado del Decreto Legislativo Nº 728, Ley de Productividad y Competitividad Laboral, D.S. Nº 003-97-TR (en adelante LPCL), entre:</p>
                <ul>
                    <li>
                        <b>SOCIEDAD EXPORTADORA VERFRUT S.A.C.</b>, R.U.C. Nº 20601438586, con domicilio en Caserío el Papayo Mz. O, Distrito de Castilla, Provincia y Departamento de Piura, debidamente representada por su Apoderado, <b>Daniel José Eyheralde Munita</b>, identificado con Documento Nacional de Identidad C.E. Nº 001555417, a la que en adelante le denominará <b>EL EMPLEADOR</b>; y de la otra parte,
                    </li>
                    <li>
                        <b><i>{{ $trabajador->apellidos }}, {{ $trabajador->nombre }}</i></b> con DNI o C.E. Nº <b>{{ $trabajador->rut }}</b>, con domicilio en <b>{{ $trabajador->direccion }}</b>, Distrito de <b>{{ $trabajador->distrito->name }}</b>, Provincia de <b>{{ $trabajador->distrito->provincia->name }}</b>, Departamento de <b>{{ $trabajador->distrito->provincia->departamento->name }}</b>, con fecha de nacimiento <b>{{ $trabajador->fecha_format }}</b> y de Nacionalidad <b>{{ $trabajador->nacionalidad->name }}</b>, a quien en adelante se le denominará <b>EL TRABAJADOR</b>.
                    </li>
                </ul>
                <p>En los términos y condiciones que constan en las cláusulas siguientes:</p>
                <ol>
                    <li>
                        <b><u>CLÁUSULA PRIMERA</u>: Antecedentes.-</b>
                        <br><b>EL EMPLEADOR</b> es una persona jurídica de derecho privado constituida bajo el régimen de sociedad anónima cerrada, cuyo objeto social principal es dedicarse a la explotación de bienes raíces y agrícolas sean estos propios o arrendados así como la producción, comercialización y exportación de los productos agrícolas y frutícolas originados en esta explotación, toda otra actividad agrícola conexa con las anteriores y cualquier otra actividad que su junta general de accionistas decida emprender sin limitación de ninguna índole.
                    </li>
                    <li>
                        <b><u>CLÁUSULA SEGUNDA:</u> Causas objetivas de la contratación.-</b>
                        <br>2.1 <b>EL EMPLEADOR</b> realiza sus actividades productivas según secuencia predeterminada, la misma que se establece conforme el desarrollo de su cadena de procesos, razón por la cual resulta necesario iniciar los procesos de planta, que involucra labores de packing.
                        <br>2.2	Conforme la naturaleza temporal de los procesos de planta, la duración estimada es de tres (03) meses al año, aproximadamente. En función de lo señalado en el párrafo anterior, <b>EL EMPLEADOR</b> requiere contratar los servicios de <b>EL TRABAJADOR</b> a plazo fijo y bajo la modalidad de temporada, para que desempeñe el cargo de <b>{{ $contrato->oficio->name }}</b>.
                    </li>
                    <li>
                        <b><u>CLÁUSULA TERCERA:</u> Plazo del Contrato.-</b>
                        <br>3.1	El presente contrato tiene una duración de tres (03) meses, cuyo inicio será el <b>{{ $contrato->fecha_larga }}</b>, y concluirá el <b>{{ $contrato->fecha_larga_termino }}</b>. Asimismo, si la naturaleza del trabajo así lo requiere se podrá prorrogar la vigencia de EL CONTRATO, en común acuerdo de ambas partes, debiéndose de firmar en este caso la prórroga respectiva.
                        <br>3.2	De conformidad con el artículo 10° del Decreto Supremo N° 003-97-TR, <b>EL TRABAJADOR</b> se encontrará sujeto a un periodo de prueba de (03) meses, contados desde el primer día de labores.
                        <br>3.3	Queda entendido que <b>EL EMPLEADOR</b> no está obligado a dar aviso adicional alguno referente al término del presente contrato, operando su extinción en la fecha de su vencimiento, oportunidad en la cual se abonará a <b>EL TRABAJADOR</b> los beneficios sociales, que le pudieran corresponder de acuerdo a Ley, a menos que las partes pactasen la prórroga de este contrato por continuar la causa objetiva que lo motiva.
                    </li>
                    <li>
                        <b><u>CLÁUSULA CUARTA:</u> Jornada de Trabajo.-</b>
                        <br>4.1	<b>EL EMPLEADOR</b> establece que <b>EL TRABAJADOR</b> estará sujeto a la jornada máxima legal de 8 horas diarias o 48 horas semanales, de conformidad con el T.U.O. del Decreto Legislativo N° 854, Ley de Jornada de Trabajo, Horario y Trabajo en Sobretiempo, desarrollando sus labores en el siguiente horario de trabajo:
                        <br><span style="margin-left: 15px;"> - De Lunes a Sábado de 6:15 a.m. a 03:00 p.m.</span>
                        <br>4.2	<b>EL EMPLEADOR</b> en ejercicio de sus facultades de dirección establecerá el horario de trabajo que considere conveniente a sus actividades. Asimismo, en el supuesto que considere necesario modificar el horario de trabajo, variar los días de labores, procederá a comunicarlo a <b>EL TRABAJADOR</b> con una anticipación de 48 horas.
                        <br>4.3 El trabajo en sobretiempo es voluntario, tanto en su otorgamiento como en su prestación. Nadie puede ser obligado a trabajar horas extras, salvo en los casos justificados en que la labor resulte indispensable a consecuencia de un hecho fortuito o fuerza mayor que ponga en peligro inminente a las personas o los bienes del centro de trabajo o la continuidad de la actividad productiva.
                        <br>4.4 <b>EL EMPLEADOR</b> señala que <b>EL TRABAJADOR</b> tendrá derecho a gozar del día de descanso semanal obligatorio, conforme lo establecido en el artículo 2° del Decreto Legislativo N° 713. Al respecto se precisa que en el supuesto de realizarse las modificaciones señaladas en el párrafo precedente, se cumplirá con respetar lo estipulado en norma citada.
                        <br>4.5 <b>EL TRABAJADOR</b> tendrá derecho a gozar de 45 minutos de refrigerio, tiempo que no forma parte de la jornada de trabajo, tal como se indica en el artículo 7° del Texto Único Ordenado de la Ley de Jornada de Trabajo.
                        <br>4.6 <b>EL TRABAJADOR</b> está obligado a registrar su ingreso y salida en el Registro Permanente de Asistencia establecido por <b>EL EMPLEADOR</b>, el incumplimiento de esta disposición es pasible de sanción.
                    </li>
                    <li>
                        <b><u>CLÁUSULA QUINTA:</u> Prestaciones del Trabajador.-</b>
                        <br>5.1	<b>EL TRABAJADOR</b> llevará a cabo las siguientes acciones: cumplir con las normas propias del Centro de Trabajo, así como las contenidas en el Reglamento Interno de Trabajo y en las demás normas laborales, y las que se impartan por necesidades del servicio en ejercicio de las facultades de administración de la empresa, de conformidad con el Art. 9° de la Ley de Productividad y Competitividad Laboral aprobado por D. S. N° 003-97-TR, y la Ley N° 27360.
                        <br>5.2 <b>EL TRABAJADOR</b>, recibirá copia del Reglamento Interno de Seguridad y Salud en el Trabajo, comprometiéndose a cumplir lo establecido en el mismo.
                    </li>
                    <li>
                        <b><u>CLÁUSULA SEXTA:</u> Remuneración.-</b>
                        <br>6.1 En contraprestación a los servicios prestados por EL TRABAJADOR, EL EMPLEADOR se obliga a pagar una remuneración diaria (jornal) bruta ascendente a S/ 39.19 (TREINTA Y NUEVE CON 19/100 SOLES), remuneración que se encuentra comprendida por el básico de S/ 31.01 (TREINTA Y UNO CON 01/100 SOLES) más el concepto de CTS equivalente al 9.72% de S/ 3.01 (TRES CON 01/100 SOLES)  y el concepto de Gratificaciones de fiestas patrias y de navidad equivalente al 16.66% de S/ 5.17 (CINCO CON 17/100 SOLES), monto del cual se deducirán las aportaciones y descuentos establecidos en la ley. Adicionalmente una Bonificación Especial por Trabajo Agrario (BETA) del 30% de la RMV con carácter no remunerativo.
                        <br>Así mismo el trabajador elegirá recibir los conceptos de CTS y gratificaciones en los plazos que la ley establece, sin que entren a ser prorrateados en la RD; elección que forma parte integrante de este contrato como Anexo 2.
                        <br>6.2 <b>EL EMPLEADOR</b> al encontrarse acogido al régimen agrario, precisa que la remuneración abonada a <b>EL TRABAJADOR</b> incluye la compensación por tiempo de servicios y las gratificaciones de fiestas patrias y de navidad, más una Bonificación Especial por Trabajo Agrario (BETA) del 30% de la RMV con carácter no remunerativo, conforme lo previsto en los incisos c) y e) de la Ley N° 31110, Ley del Régimen Laboral Agrario y de Incentivos para el Sector Agrario y Riego, Agroexportador y Agroindustrial. De la misma forma, de acuerdo al inciso d) del mismo cuerpo normativo, de forma facultativa, el trabajador elegirá recibir los conceptos de CTS y gratificaciones en los plazos que la ley establece, sin que entren a ser prorrateados en la RD; elección que forma parte integrante de este contrato como Anexo 3.
                    </li>
                    <li>
                        <b><u>CLÁUSULA SÉPTIMA:</u> Entrega de Materiales y Herramientas de Trabajo.-</b>
                        <br>7.1 <b>EL EMPLEADOR</b> se obliga a facilitar a <b>EL TRABAJADOR</b> los materiales y condiciones necesarios para el adecuado desarrollo de sus actividades y a otorgarle los beneficios que por ley, pacto o costumbre tuvieran los trabajadores.
                        <br>7.2 En caso que <b>EL EMPLEADOR</b> proporcione herramientas de trabajo a <b>EL TRABAJADOR</b>, este último será responsable de las mismas desde el momento en que se realiza la entrega y firma el acta correspondiente. <b>EL TRABAJADOR</b> será igualmente responsable por los daños, pérdidas, extravíos o robos que sufran mencionadas las herramientas de trabajo durante el periodo que se encuentren bajo su custodia, pudiendo ser sancionado por <b>EL EMPLEADOR</b> conforme lo establecido en el Reglamento Interno de Trabajo de la empresa.
                    </li>
                    <li>
                        <b><u>CLÁUSULA OCTAVA:</u> Buena Fe.-</b>
                        <br><b>EL TRABAJADOR</b> se obliga en forma expresa a poner al servicio de <b>EL EMPLEADOR</b> toda su capacidad y lealtad, así como a la protección de sus intereses, en razón del cargo para el cual se le contrata.
                    </li>
                    <li>
                        <b><u>CLÁUSULA NOVENA:</u> Exclusividad.-</b>
                        <br>Los servicios de <b>EL TRABAJADOR</b> son contratados con el carácter de exclusividad. Durante la vigencia de la relación laboral <b>EL TRABAJADOR</b> se compromete a dedicar todo el tiempo, desplegar la energía y aplicar la experiencia que sean necesarios para el servicio y la protección de los intereses de <b>EL EMPLEADOR</b>, no pudiendo dedicarse a actividades por cuenta propia o de terceros que le distraigan del cumplimiento cabal de sus obligaciones para con <b>EL EMPLEADOR</b>.
                    </li>
                    <li>
                        <b><u>CLÁUSULA DÉCIMA:</u> Confidencialidad.-</b>
                        <br><b>EL TRABAJADOR</b> se compromete a guardar secreto de toda información confidencial que llegue a su conocimiento relacionada con los negocios de <b>EL EMPLEADOR</b>, sus socios y/o sus clientes.  Esta obligación subsistirá aún después de extinguida la relación laboral, sobre la base de principios elementales de derecho y de ética.
                    </li>
                    <li>
                        <b><u>CLÁUSULA DÉCIMO PRIMERA:</u> Inventos del Trabajador.-</b>
                        <br>En virtud del presente contrato, <b>EL TRABAJADOR</b> cede, transfiere y en general autoriza el uso sin costo alguno a favor de <b>EL EMPLEADOR</b> por plazo indefinido, cualquier creación intelectual personal establecida en la Ley de Derechos de Autor o cualquier otra invención o descubrimiento establecida en la Ley de Propiedad Industrial, generada durante la vigencia del presente contrato.
                    </li>
                    <li>
                        <b><u>CLÁUSULA DÉCIMO SEGUNDA:</u> Registro del Contrato.-</b>
                        <br><b>EL EMPLEADOR</b> se obliga a inscribir a <b>EL TRABAJADOR</b> en la planilla electrónica PDT Nº 601-PLAME, así como realizar el registro del presente contrato ante la Autoridad Administrativa de Trabajo, en cumplimiento de lo dispuesto en el TUO del D. Leg. Nº 728 D.S. Nº 003-97-TR, Ley de Productividad y Competitividad Laboral.
                    </li>
                    <li>
                        <b><u>CLÁUSULA DÉCIMO TERCERA:</u> Sistema de Pensiones.-</b>
                        <br>De acuerdo a los artículos 15 y 16 de la Ley 28991, <b>EL TRABAJADOR</b> comunica a <b>EL EMPLEADOR</b> su  decisión respecto del derecho a afiliarse a cualquiera de los regímenes previsionales, e informara oportunamente al <b>EL EMPLEADOR</b> el régimen previsional elegido.
                    </li>
                    <li>
                        <b><u>CLÁUSULA DÉCIMO CUARTA:</u> Seguridad y Salud.-</b>
                        <br>14.1 En cumplimiento con lo establecido en la Ley N° 29783, Ley de Seguridad y Salud en el Trabajo, y habiendo analizado el riesgo de las funciones propias del cargo a desempeñar por <b>EL TRABAJADOR</b>, con la finalidad de dar cumplimiento con las recomendaciones en materia de seguridad y salud destinadas a evitar cualquier riesgo para <b>EL TRABAJADOR</b> durante el desarrollo de las actividades del cargo indicado. <b>EL EMPLEADOR</b> señala de manera expresa la obligación de <b>EL TRABAJADOR</b> de cumplir con las recomendaciones que le resulten aplicables en el presente contrato, las mismas que serán desarrolladas en el Anexo 1 del presente documento.
                        <br>14.2 <b>EL TRABAJADOR</b> entiende que es su obligación conocer el Reglamento de Seguridad y Salud que se le entregará al inicio de la relación laboral, así como asistir a las capacitaciones sobre la materia que sean programadas por <b>EL EMPLEADOR</b>.
                        <br>14.3 <b>EL EMPLEADOR</b> establece de manera expresa que el incumplimiento de obligaciones en materia de seguridad y salud por parte de EL TRABAJADOR son consideradas faltas graves toda vez que suponen un riesgo para la salud e integridad del mismo y de las otras personas que se encuentren en el centro de trabajo.
                    </li>
                    <li>
                        <b><u>CLÁUSULA DÉCIMO QUINTA:</u> Ley Aplicable.-</b>
                        <br>En todo lo no previsto por este contrato, se aplicarán las disposiciones que contiene la Ley N° 31110, Ley del Régimen Laboral Agrario y de Incentivos para el Sector Agrario y Riego, Agroexportador y Agroindustrial, y el TUO del Decreto Legislativo Nº 728 aprobado por Decreto Supremo Nº 003-97-TR Ley de Productividad y Competitividad Laboral, y demás normas legales que lo regulen o que sean dictadas durante la vigencia del contrato.
                    </li>
                    <li>
                        <b><u>CLÁUSULA DÉCIMO SEXTA:</u> Solución de Controversias.-</b>
                        <br>Para todos los efectos emergentes de este contrato, las partes constituyen domicilio especial en los indicados en el encabezamiento del presente, donde serán válidas y surtirán plenos efectos todas las comunicaciones que deban cursarse con motivo del mismo. Asimismo, para cualquier divergencia que se suscite entre las partes con motivo del presente, se pacta la jurisdicción y competencia de los Tribunales Ordinarios del Departamento Judicial de Piura.
                    </li>
                </ol>
                <p>Conformes con todas las cláusulas anteriores, firman las partes, por triplicado, en Piura el <b>{{ $contrato->fecha }}</b>.</p>
                <table style="width: 100%; font-weight: bold; text-align: center; margin-top: 100px">
                    <tr>
                        <td>___________________<br>EL EMPLEADOR</td>
                        <td>___________________<br>EL TRABAJADOR</td>
                    </tr>
                </table>
            @endif
        @endif
    </section>

    @if ($contrato->regimen->name === 'Obreros' && $contrato->tipo_contrato->name === 'INTERMITENTE')
        <div class="page-break"></div>
    @endif
@endsection
