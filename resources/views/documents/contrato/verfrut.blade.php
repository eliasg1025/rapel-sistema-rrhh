@extends('pdf-layout')

@section('titulo')
    FICHA PERSONAL contrato declaracion topico - {{ $contrato->oficio->name }}
@endsection

<style>
    * {
        font-family: Arial, Helvetica, sans-serif;
    }

    .contrato {
        font-size: 10px;
    }

    p, li {
        text-align: justify;
    }

    .contrato li {
        margin: 0 0 13px 0;
    }

    .titulo {
        text-align: center;
        text-decoration: underline;
    }

    .page-break {
        page-break-after: always;
    }

    .lista-romanos {
        list-style: upper-roman
    }

    .lista-sin-estilos {
        list-style: none;
    }

    table {
        border-collapse: collapse;
    }
    .tabla th, .tabla td {
        border: 1px solid black;
    }

    td {
        padding: 5px;
    }

    .firma-container {
        margin-top: 80px;
    }

    .firma-container div {
        display: inline;
    }

    .firma-container .primero {
        margin-left: 80px;
    }

    .firma-container .segundo {
        padding-left: 200px;
    }

    .espacios-lista li {
        margin-bottom: 2px;
    }

    .espacios-lista-md li {
        margin-bottom: 10px;
    }
</style>

@section('contenido')
    <section style="font-size: 14px">
        <h3 style="text-align: center;">
            CONSENTIMIENTO INFORMADO PARA EVALUACION MÉDICA DE INGRESO  Y CUSTODIA DE HISTORIA CLÍNICA
        </h3>
        <br />
        <p>
            Yo, <b>{{ $contrato->trabajador->nombre_completo }}</b> de <b>{{ $trabajador->age }}</b> años de edad; identificado con DNI N° <b>{{ $contrato->trabajador->rut }}</b>, domiciliado en: <b>{{ $contrato->trabajador->direccion }}</b> Postulante de la empresa <b>SOCIEDAD EXPORTADORA VERFRUT S.A.C</b>.
        </p>
        <br />
        <p>
            Certifico que he sido informado acerca de la naturaleza, propósito y posibles complicaciones de las evaluaciones de ingreso, lo cual he comprendido claramente; ya que todas mis dudas y preguntas han sido absueltas; por lo cual, autorizo se me realice la Evaluación de Ingreso y todos los estudios requeridos de acuerdo al programa de Vigilancia de Salud Ocupacional  y en conformidad de las normas vigentes, y a la vez, autorizo la custodia de estos documentos en mi Historia Clínica de la empresa la  cual se encuentra en el archivo del área de Salud Ocupacional.
        </p>
        <br />
        <p>
            Hago de conocimiento y firmo este documento sin presión alguna y por propia voluntad.<br />
            Quedando en conformidad de lo anterior descrito firmo a continuación.
        </p>
        <br />
        <p><b>Fecha:</b> 11 de junio del 2021</p>
        <br />
        <table style="width: 100%; font-weight: bold; margin-top: 70px; text-align: center">
            <tr>
                <td>
                    <div style="width: 100px; height: 140px;"></div>
                </td>
                <td>
                    <div style="border: 1px solid black; width: 100px; height: 140px; margin: auto;"></div>
                </td>
            </tr>
            <tr>
                <td style="width: 50%">_______________________________<br>{{ $trabajador->nombre_completo }} <br> DNI/CE: {{ $trabajador->rut }}</td>
                <td style="width: 50%">HUELLA DIGITAL <br> (INDICE DERECHO)</td>
            </tr>
        </table>
        <br />
        <small>NOTA: Si el paciente no puede firmar (Describir motivos)</small>
    </section>

    <div class="page-break"></div>

    <section id="page23">
        <h5 style="text-align: center">
            Ficha de Sintomatología COVID-19 para Regreso al Trabajo<br/>
            Declaración Jurada
        </h5>
        <div style="font-size: 11px; text-align: justify">
            <p>He recibido explicación del objetivo de esta evaluación y me comprometo a responder con la verdad </p>
            <p style="font-weight: bold">
                Empresa: SOCIEDAD EXPORTADORA VERFRUT S.A.C &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; RUC: 20601438586 <br /><br />
                Apellidos y Nombres: {{ $trabajador->nombre_completo }}<br /><br />
                Área de Trabajo: ___________________________ &nbsp;&nbsp;DNI: {{ $trabajador->rut }}<br /><br/>
                Dirección: <span style="font-weight: normal">{{ $trabajador->direccion }}</span> &nbsp;&nbsp;Numero (celular): _____________
            </p>
            <div>
                <p style="font-weight: bold">A) En los últimos 14 días calendario ha tenido algunos de los síntomas siguientes</p>
                <table>
                    <tr>
                        <th></th>
                        <th>SI</th>
                        <th>NO</th>
                    </tr>
                    <tr>
                        <td>1. sensación de alza térmica o fiebre</td>
                        <td style="border: 1px solid black">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </td>
                        <td style="border: 1px solid black">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td>2. tos, estornudos o flema o dificultad para respirar</td>
                        <td style="border: 1px solid black"></td>
                        <td style="border: 1px solid black"></td>
                    </tr>
                    <tr>
                        <td>3. expectoración de flema amarilla o verdosa</td>
                        <td style="border: 1px solid black"></td>
                        <td style="border: 1px solid black"></td>
                    </tr>
                    <tr>
                        <td>4. contacto con persona(s) con un caso confirmado de COVID-19</td>
                        <td style="border: 1px solid black"></td>
                        <td style="border: 1px solid black"></td>
                    </tr>
                    <tr>
                        <td>5. Estas tomando alguna medicación (detallar cual o cuales):</td>
                        <td style="border: 1px solid black"></td>
                        <td style="border: 1px solid black"></td>
                    </tr>
                </table>
            </div>
            <div>
                <p style="font-weight: bold;">B) Padece de alguna de estas enfermedades y/o condiciones vulnerables:</p>
                <table>
                    <tr>
                        <td style="border: 1px solid black">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td>Edad mayor a 65 años</td>
                        <td style="border: 1px solid black">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td>Asma Moderada o Grave</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black"></td>
                        <td>Asma Moderada o Grave</td>
                        <td style="border: 1px solid black"></td>
                        <td>Enfermedad Pulmonar Crónica</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black"></td>
                        <td>Enfermedades cardiovasculares graves</td>
                        <td style="border: 1px solid black"></td>
                        <td>Enfermedades cardiovasculares graves</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black"></td>
                        <td>Cáncer</td>
                        <td style="border: 1px solid black"></td>
                        <td>Enfermedad o tratamiento inmunosupresor</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black"></td>
                        <td>Parálisis o parecías (parálisis parcial</td>
                        <td style="border: 1px solid black"></td>
                        <td>Tos con rasgos de sangre o sangrado al toser (hemoptisis)</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black"></td>
                        <td>Diabetes Mellitus</td>
                        <td style="border: 1px solid black"></td>
                        <td>Obesidad con IMC de 40 a más</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black"></td>
                        <td>Otros: ___________________________</td>
                        <td style="border-top: 1px solid black"></td>
                        <td></td>
                    </tr>
                </table>
            </div>
            <div>
                <p>Aquellas enfermedades o condiciones marcadas serán evaluadas con mayor detalle durante la entrevista médica ocupacional</p>
                <p>TODA LA INFORMACION QUE HE PROPORCIONADO ES VERDADERA, NO HABIENDO OMITIDO NINGUN DATO EN FORMA VOLUNTARIA</p>
                <br />
                <table>
                    <tr>
                        <td></td>
                        <td>
                            <div style="height: 160px; width: 140px; border: 1px solid black;"></div>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold">
                            ___________________________________________<br />
                            Apellidos y Nombres: {{ $trabajador->nombre_completo }}<br />
                            DNI/CE: {{ $trabajador->rut }}
                        </td>
                        <td style="font-weight: bold">
                            Fecha: {{ $contrato->fecha_larga }}
                        </td>
                    </tr>
                </table>
            </div>
            <br />
            <div>
                <p style="font-weight: bold;">Nota: proporcionar información falsa al empleador está tipificada como falta grave, según lo dispuesto en el inciso del articulo
                    25 el TUO de la ley de productividad y competitividad laboral.</p>
            </div>
        </div>
    </section>

    <div class="page-break"></div>

    @yield('contrato')

    <div class="page-break"></div>

    <section style="font-size: 14px">
        <h4 class="titulo">ANEXO 1<br />RECOMENDACIONES AL TRABAJADOR EN MATERIA DE SEGURIDAD Y SALUD EN EL TRABAJO</h4>
        <br />
        <ul>
            <li>
                Procurar el cuidado integral de su salud.
            </li>
            <li>
                Usar adecuadamente los instrumentos y materiales de trabajo, así como los equipos de protección personal y colectiva, siempre y
                Cuando hayan sido previamente informados y capacitados sobre su uso.
            </li>
            <li>
                No operar o manipular equipos, maquinarias, herramientas u otros elementos para los cuales no hayan sido autorizados.
            </li>
            <li>
                Conocer y ejecutar las actividades del Sistema de Gestión de la Seguridad y Salud en el Trabajo.
            </li>
            <li>
                Cumplir con las normas, reglamentos e instrucciones de los programas de seguridad y salud en el trabajo.
            </li>
        </ul>
        <br /><br /><br />
        <div style="margin-top: 20px; font-weight: bold">
            <table style="width: 100%; text-align: center">
                <tr>
                    <td>
                        <img src="{{ public_path() . '/img/PostFirma - Daniel E  VERFRUT SAC.jpg' }}" style="width: 180px">
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td style="vertical-align: top">__________________<br/>EL EMPLEADOR</td>
                    <td style="vertical-align: top">__________________<br/>EL TRABAJADOR<br/>DNI: {{ $trabajador->rut }}</td>
                </tr>
            </table>
        </div>
    </section>

    <div class="page-break"></div>

    <section></section>

    <div class="page-break"></div>

    <section style="font-size: 11px; transform: rotate(270deg); margin-left: 50px; margin-top: 120px; width: 50%;">
        <h4 class="titulo">ANEXO 3</h4>
        <p>
            <b>DECLARACIÓN JURADA ELECCIÓN VOLUNTARIA SOBRE EL  PAGO DE LA BONIFICACIÓN ESPECIAL POR TRABAJO AGRARIO.</b>
        </p>
        <p>
            Yo, <b>{{ $contrato->trabajador->nombre_completo_doc }}</b> Identificado con DNI N° 02815445, solicito y declaro bajo juramento que:
        </p>
        <p>
            De acuerdo a lo establecido en el inciso e) del artículo 3° de la Ley N° 31110, <b>LEY DEL RÉGIMEN LABORAL AGRARIO Y DE INCENTIVOS PARA EL SECTOR AGRARIO Y RIEGO, AGROEXPORTADOR Y AGROINDUSTRIAL</b>, puedo elegir de manera facultativa el pago de la Bonificación Especial por Trabajo Agrario.
        </p>
        <p>
            Por lo tanto,  declaro a mi empleador elegir de manera voluntaria, percibir  en mis haberes este concepto dentro de mi remuneración diaria. Por lo expuesto firmo la presente en señal de conformidad.
        </p>
        <br /><br /><br /><br />
        <p>
            <b>FIRMA _______________________________________________</b>
            <br /><br />
            <b>NOMBRE Y APELLIDOS: {{ $contrato->trabajador->nombre_completo_doc }}</b><br />
            <b>DNI: {{ $contrato->trabajador->rut }}</b><br />
            <br />
            <b>El Papayo, {{ $contrato->fecha_larga }}</b>
        </p>
    </section>

    <section style="font-size: 11px; transform: rotate(270deg); margin-left: 50px; margin-top: 50px; width: 50%;">
        <h4 class="titulo">ANEXO 2</h4>
        <p>
            <b>DECLARACIÓN JURADA  ELECCIÓN VOLUNTARIA SOBRE EL ABONO DE LA COMPENSACIÓN POR TIEMPO DE SERVICIOS  Y GRATIFICACIONES.</b>
        </p>
        <p>
            Yo, <b>{{ $contrato->trabajador->nombre_completo_doc }}</b> Identificado con DNI N° 02815445, solicito y declaro bajo juramento que:
        </p>
        <p>
            De acuerdo a lo establecido en el inciso d) del artículo 3° de la Ley N° 31110, <b>LEY DEL RÉGIMEN LABORAL AGRARIO Y DE INCENTIVOS PARA EL SECTOR AGRARIO Y RIEGO, AGROEXPORTADOR Y AGROINDUSTRIAL</b>, puedo elegir de manera facultativa la periodicidad del pago de los conceptos de Compensación por Tiempo de Servicios y Gratificaciones.
        </p>
        <p>
            Por lo tanto,  declaro a mi empleador elegir de manera voluntaria, percibir  en mis haberes ambos conceptos dentro  de mi remuneración diaria. Por lo expuesto firmo la presente en señal de conformidad.
        </p>
        <br /><br /><br /><br />
        <p>
            <b>FIRMA _______________________________________________</b>
            <br /><br />
            <b>NOMBRE Y APELLIDOS: {{ $contrato->trabajador->nombre_completo_doc }}</b><br />
            <b>DNI: {{ $contrato->trabajador->rut }}</b><br />
            <br />
            <b>El Papayo, {{ $contrato->fecha_larga }}</b>
        </p>
    </section>

    {{-- <div class="page-break"></div>

    <section id="page9"></section>

    <div class="page-break"></div>

    <section id="page10">
        <table>
            <tr>
                <td style="vertical-align: center"><img src="{{ public_path() . '/img/Logo Documentos1.jpg'}}" width="70px" /></td>
                <td style="font-size: 14px; vertical-align: bottom"></td>
            </tr>
        </table>
        <br>
        <h4 class="titulo">CONSTANCIA DE ENTREGA DE REGLAMENTO INTERNO DE TRABAJO</h4>
        <br>
        <div style="padding: 25px;">
            <p>
                Yo, <b>{{ $trabajador->apellidos }}, {{ $trabajador->nombre }}</b><br>
                Identificado con D.N.I N° <b>{{ $trabajador->rut }}</b>, manifiesto haber recibido un ejemplar del Reglamento Interno de Trabajo, comprometiéndome a leerlo, estudiarlo y cumplirlo, durante la vigencia del vínculo laboral que mantengo con La Empresa.<br><br>
                Me comprometo voluntariamente a difundir y velar por su cumplimiento entre mis compañeros de trabajo.
            </p>
            <br><br><br><br>
            <p style="text-align: right"><b>Piura,  {{ $contrato->fecha_larga }}.</b></p>
            <table style="width: 100%; font-weight: bold; margin-top: 70px; text-align: center">
                <tr>
                    <td>
                        <div style="border: 1px solid black; width: 100px; height: 140px; margin: auto;"></div>
                    </td>
                    <td>
                        <div style="width: 100px; height: 140px;"></div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%">HUELLA DIGITAL <br> (INDICE DERECHO)</td>
                    <td style="width: 50%">_______________________________<br>FIRMA DEL TRABAJADOR <br> DNI/CE: {{ $trabajador->rut }}</td>
                </tr>
            </table>
            <div style="margin-top: 150px; width: 100%">
                <hr>
                <small>Prohibida la reproducción total o parcial de este documento sin autorización de  SOCIEDAD EXPORTADORA VERFRUT S.A.C.</small>
            </div>
        </div>
    </section> --}}

    <div class="page-break"></div>

    <section></section>

    <div class="page-break"></div>

    <section id="page11">
        <table>
            <tr>
                <td style="vertical-align: center"><img src="{{ public_path() . '/img/Logo Documentos1.jpg'}}" width="70px" /></td>
                <td style="font-size: 14px; vertical-align: bottom"></td>
            </tr>
        </table>
        <br>
        <h4 class="titulo">
            DECLARACIÓN  DE RECEPCIÓN DE FORMATO PARA BENEFICIARIOS DE SEGURO VIDA LEY
        </h4>
        <br>
        <div style="padding: 25px;">
            <p>
                Yo, <b>{{ $trabajador->apellidos }}, {{ $trabajador->nombre }}</b> identificado con D.N.I N° <b>{{ $trabajador->rut }}</b>, declaro que:<br /> Haber recibido el formato de DECLARACION DE BENEFICIARIOS para SEGURO VIDA LEY D. LEG. 688, COMPROMETIENDOME con mi empleador en alcanzar este documento con el detalle de mis beneficiarios y debidamente certificado NOTARIALMENTE, en un plazo máximo de 30 días calendario desde la firma de este documento.
            </p>
            <br><br><br><br>
            <p style="text-align: right"><b>El Papayo,  {{ $contrato->fecha_larga }}.</b></p>
            <table style="width: 100%; font-weight: bold; margin-top: 70px; text-align: center">
                <tr>
                    <td>
                        <div style="border: 1px solid black; width: 100px; height: 140px; margin: auto;"></div>
                    </td>
                    <td>
                        <div style="width: 100px; height: 140px;"></div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%">HUELLA DIGITAL <br> (INDICE DERECHO)</td>
                    <td style="width: 50%">_______________________________<br>FIRMA DEL(A) TRABAJADOR(A) <br> DNI/CE: {{ $trabajador->rut }}</td>
                </tr>
            </table>
            <div style="margin-top: 150px; width: 100%">
                <hr>
                <small>Prohibida la reproducción total o parcial de este documento sin autorización de  SOCIEDAD EXPORTADORA VERFRUT S.A.C.</small>
            </div>
        </div>
    </section>

    <div class="page-break"></div>
    <div class="page-break"></div>

    {{-- <section id="page12">
        <table>
            <tr>
                <td style="vertical-align: center"><img src="{{ public_path() . '/img/Logo Documentos1.jpg'}}" width="70px" /></td>
                <td style="font-size: 14px; vertical-align: bottom"></td>
            </tr>
        </table>
        <br>
        <h4 class="titulo">DECLARACIÓN DE ACEPTACIÓN DEL REGLAMENTO INTERNO DE SEGURIDAD  Y SALUD EN EL TRABAJO</h4>
        <br>
        <p>
            Yo, <b>{{ $trabajador->nombre_completo }}</b>, identificado con DNI N° <b>{{ $trabajador->rut }}</b>, desempeñándome en el cargo de <b>{{ $contrato->oficio->name }}</b>, declaro que desarrollare mis labores en forma segura, comprometiéndome a cumplir y acatar todas las normativas y procedimientos de Seguridad y Salud en el Trabajo establecidas por la Empresa en el presente Reglamento y demás directivas o políticas internas; siendo esto condición imprescindible para mi permanencia en la Empresa.
        </p>
        <p>
            Asimismo, declaro que me regiré por los procedimientos mencionados de Seguridad y Salud en el Trabajo y las normas que sobre el tema se han dictado y se dicten en adelante; adecuando mi desempeño laboral a una conducta segura e higiénica, y de respeto hacia mis compañeros de trabajo, jefes, clientes, comunidad y medio ambiente. Cualquier incumplimiento de las normas y procedimientos establecidos en SOCIEDAD EXPORTADORA VERFRUT S.A.C., me obligará a someterme a las sanciones establecidas en el Reglamento Interno de Seguridad y Salud en el Trabajo, y demás normas internas de la Empresa., las cuales conozco y acato en su totalidad.
        </p>
        <p>
            Finalmente,  declaro  haber recibido un ejemplar del Reglamento Interno de Seguridad y Salud en el Trabajo, así también declaro haberlo leído cuidadosamente y me comprometo a darle estricto cumplimiento.
        </p>
        <p>
            Dejo presente que dicho ejemplar me fue entregado en forma gratuita.
        </p>
        <p style="margin-top: 80px; text-align: right">
            <b>El Papayo, {{ $contrato->fecha_larga }}</b>
        </p>
        <table style="width: 100%; font-weight: bold; margin-top: 70px; text-align: center">
            <tr>
                <td>
                    <div style="border: 1px solid black; width: 100px; height: 140px; margin: auto;"></div>
                </td>
                <td>
                    <div style="width: 100px; height: 140px;"></div>
                </td>
            </tr>
            <tr>
                <td style="width: 50%">HUELLA DIGITAL <br> (INDICE DERECHO)</td>
                <td style="width: 50%">_______________________________<br>FIRMA DEL TRABAJADOR <br> DNI/CE: {{ $trabajador->rut }}</td>
            </tr>
        </table>
    </section>

    <div class="page-break"></div>

    <section></section>

    <div class="page-break"></div>

    <section id="page13">
        <table>
            <tr>
                <td style="vertical-align: center"><img src="{{ public_path() . '/img/Logo Documentos1.jpg'}}" width="70px" /></td>
                <td style="font-size: 14px; vertical-align: bottom"></td>
            </tr>
        </table>
        <br>
        <h4 class="titulo">RADIACIÓN ULTRAVIOLETA</h4>
        <br>
        <p>
            Yo, <b>{{ $trabajador->nombre_completo }}</b>, identificado con DNI N° <b>{{ $trabajador->rut }}</b>, desempeñándome en el cargo de <b>{{ $contrato->oficio->name }}</b>, declaro haber recibido instrucción e información sobre la Guía para el cumplimiento legal de la Ley Nº 30102, “LEY QUE DISPONE MEDIDAS PREVENTIVAS CONTRA LOS EFECTOS NOCIVOS PARA LA SALUD POR LA EXPOSICIÓN PROLONGADA A LA RADIACIÓN SOLAR”, indicándome los riesgos específicos de exposición laboral a radiación UV de origen solar y sus medidas de control en los siguientes términos: “la exposición excesiva y/o acumulada de radiación ultravioleta produce efectos dañinos a corto y largo plazo, principalmente en ojos y piel que van desde quemaduras solares, queratitis actínica y alteraciones de la respuesta inmune hasta foto envejecimiento, tumores malignos de piel y cataratas a nivel ocular”, en los siguientes términos:
        </p>
        <ol>
            <li>Efectos en la salud por exposición a radiación UV.</li>
            <li>Expuestos y puestos de trabajo en riesgo dentro de la empresa.</li>
            <li>Medidas de control y de protección personal</li>
            <li>Concientización sobre la correcta utilización y cuidados de los elementos de protección personal</li>
        </ol>
        <p style="margin-top: 80px; text-align: right">
            <b>El Papayo, {{ $contrato->fecha_larga }}</b>
        </p>
        <table style="width: 100%; font-weight: bold; margin-top: 70px; text-align: center">
            <tr>
                <td>
                    <div style="border: 1px solid black; width: 100px; height: 140px; margin: auto;"></div>
                </td>
                <td>
                    <div style="width: 100px; height: 140px;"></div>
                </td>
            </tr>
            <tr>
                <td style="width: 50%">HUELLA DIGITAL <br> (INDICE DERECHO)</td>
                <td style="width: 50%">_______________________________<br>FIRMA DEL TRABAJADOR <br> DNI/CE: {{ $trabajador->rut }}</td>
            </tr>
        </table>
    </section>

    <div class="page-break"></div>

    <section></section>

    <div class="page-break"></div>

    <section id="page14">
        <table>
            <tr>
                <td style="vertical-align: center"><img src="{{ public_path() . '/img/Logo Documentos1.jpg'}}" width="70px" /></td>
                <td style="font-size: 14px; vertical-align: bottom">REGLAMENTO INTERNO DE SEGURIDAD Y SALUD EN EL TRABAJO</td>
            </tr>
        </table>
        <br>
        <h4 class="titulo">POLÍTICA DE SEGURIDAD Y SALUD EN EL TRABAJO</h4>
        <div style="font-size: 14px">
            <p>
                SOCIEDAD EXPORTADORA VERFRUT S.A.C.; empresa dedicada al cultivo, procesamiento y comercialización de uva de mesa, reconoce que el capital humano constituye lo más importante para la organización, por tal motivo se compromete a:
            </p>
            <ol>
                <li>
                    Proteger la integridad y la salud de todos los trabajadores, proveedores, clientes y visitantes que laboren o ingresen en cualquiera de nuestras instalaciones; ejecutando los planes, programas y medidas de prevención destinadas a prevenir accidentes y enfermedades ocupacionales.
                </li>
                <li>
                    Promover una cultura preventiva, basada en la identificación de los peligros y evaluación los riesgos determinando las medidas de control orientadas a eliminar o minimizar los impactos a la seguridad y salud de nuestros colaboradores.
                </li>
                <li>
                    Cumplir las normas legales, las normas técnicas de adhesión voluntaria, convenios de negociación colectiva y otros requisitos relativos a la seguridad y salud en el trabajo suscritos por nuestra empresa.
                </li>
                <li>
                    Garantizar la comunicación y consulta a los trabajadores y sus representantes, así como su capacitación, información y participación activa en el Sistema de Gestión de Seguridad y Salud en el Trabajo de acuerdo a lo estipulado en la legislación nacional.
                </li>
                <li>
                    Implementar y mejorar continuamente el Sistema de Gestión de Seguridad y Salud en el Trabajo e integrarlo a los demás sistemas desarrollados en la Empresa.
                </li>
            </ol>
            <br>
            <table class="tabla" style="width: 80%; margin-left: 20px">
                <tbody>
                    <tr>
                        <td>Nombre:</td>
                        <td>{{ $trabajador->nombre }}</td>
                    </tr>
                    <tr>
                        <td>Apellidos:</td>
                        <td>{{ $trabajador->apellidos }}</td>
                    </tr>
                    <tr>
                        <td>Cargo:</td>
                        <td>{{ $contrato->oficio->name }}</td>
                    </tr>
                    <tr>
                        <td>DNI N°:</td>
                        <td>{{ $trabajador->rut }}</td>
                    </tr>
                    <tr>
                        <td>Fecha:</td>
                        <td>{{ $contrato->fecha_larga }}</td>
                    </tr>
                </tbody>
            </table>

            <table style="width: 100%; font-weight: bold; margin-top: 70px; text-align: center">
                <tr>
                    <td>
                        <div style="border: 1px solid black; width: 100px; height: 140px; margin: auto;"></div>
                    </td>
                    <td>
                        <div style="width: 100px; height: 140px;"></div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%">HUELLA DIGITAL <br> (INDICE DERECHO)</td>
                    <td style="width: 50%">_______________________________<br>FIRMA DEL TRABAJADOR <br> DNI/CE: {{ $trabajador->rut }}</td>
                </tr>
            </table>
        </div>
    </section>

    <div class="page-break"></div>

    <section></section>

    <div class="page-break"></div>

    <section id="page15">
        <table>
            <tr>
                <td style="vertical-align: center"><img src="{{ public_path() . '/img/Logo Documentos1.jpg'}}" width="70px" /></td>
                <td style="font-size: 14px; vertical-align: bottom">REGLAMENTO INTERNO DE SEGURIDAD Y SALUD EN EL TRABAJO</td>
            </tr>
        </table>
        <h4 class="titulo">COMPROMISO</h4>
        <div style="font-size: 12px">
            <p>
                Considerando que todos los que trabajamos en SOCIEDAD EXPORTADORA VERFRUT S.A.C., compartimos como valor  fundamental el respeto por la vida y la seguridad de las personas, lo que debiera manifestarse en una permanente actitud de auto cuidado, y teniendo plena conciencia del dolor que provocan en nosotros los accidentes, en especial si sus consecuencias son fatales, me comprometo a
            </p>
            <ol>
                <li>
                    Que ninguna meta productiva o contingencia operacional exponga a mis compañeros o a mi persona a riesgos no suficientemente controlados.
                </li>
                <li>
                    Cumplir la normativa, los reglamentos y los procedimientos de trabajo que se han hecho para proteger nuestras vidas.
                </li>
                <li>
                    Analizar al inicio de cada trabajo los riesgos que tiene asociados y las medidas de control, para asegurar la ejecución del trabajo, evitar accidentes y para proteger el medio ambiente
                </li>
                <li>
                    Informar las condiciones inseguras que pudieran existir en los lugares donde desarrollo mis actividades y hacer lo que esté a mi alcance para eliminarlas y/o controlarlas
                </li>
                <li>
                    Participar activamente en los planes y programas que se implementen para fomentar en nosotros una conducta segura y responsable.
                </li>
            </ol>

            <p>
                Los principios antes mencionados se traducen en acciones concretas que tendré presente y guiarán mi trabajo en todo momento, según corresponda, comprometiendo SIEMPRE a:
            </p>

            <ul>
                <li>Usar correctamente los elementos de protección personal. </li>
                <li>Operar sólo los equipos para los cuales estoy autorizado. </li>
                <li>Intervenir o permitir intervenir solo equipos que estén des energizados y bloqueados. </li>
                <li>Trabajar con equipos, materiales y herramientas en buen estado. </li>
                <li>Cuidar  obedecer  las señalizaciones y los dispositivos de seguridad diseñados para protegerme. </li>
                <li>Ubicarme fuera del alcance de equipos en movimiento y fuentes de energía. </li>
                <li>Conducir atento a las condiciones del tránsito y a una velocidad razonable y prudente. </li>
            </ul>

            <p>
                El compromiso que aquí suscribo voluntariamente, expresa mi firme decisión de proteger mi integridad física y mi vida, así como la de mis compañeros de trabajo. Constituyendo además un incentivo para que todos los que trabajamos en esta Empresa; ejecutivos, profesionales, supervisores y trabajadores, continuemos cumpliendo nuestras obligaciones en materia de prevención de riesgos por nuestro propio bienestar y el de nuestras familias
            </p>

            <table class="tabla" style="width: 80%; margin-left: 20px">
                <tbody>
                    <tr>
                        <td>Nombre:</td>
                        <td>{{ $trabajador->nombre }}</td>
                    </tr>
                    <tr>
                        <td>Apellidos:</td>
                        <td>{{ $trabajador->apellidos }}</td>
                    </tr>
                    <tr>
                        <td>Cargo:</td>
                        <td>{{ $contrato->oficio->name }}</td>
                    </tr>
                    <tr>
                        <td>DNI N°:</td>
                        <td>{{ $trabajador->rut }}</td>
                    </tr>
                    <tr>
                        <td>Fecha:</td>
                        <td>{{ $contrato->fecha_larga }}</td>
                    </tr>
                </tbody>
            </table>

            <table style="width: 100%; font-weight: bold; margin-top: 70px; text-align: center">
                <tr>
                    <td>
                        <div style="border: 1px solid black; width: 100px; height: 140px; margin: auto;"></div>
                    </td>
                    <td>
                        <div style="width: 100px; height: 140px;"></div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%">HUELLA DIGITAL <br> (INDICE DERECHO)</td>
                    <td style="width: 50%">_______________________________<br>FIRMA DEL TRABAJADOR <br> DNI/CE: {{ $trabajador->rut }}</td>
                </tr>
            </table>
        </div>
    </section>

    <div class="page-break"></div>

    <section></section>

    <div class="page-break"></div> --}}

    <section id="page18" style="font-size: 12px">
        <table style="width: 100%;">
            <tr>
                <td><img src="{{ public_path() . '/img/Logo Documentos1.jpg'}}" width="50px" /></td>
                <td><h4 style="text-align: left" class="titulo">FICHA DE INGRESO Y CONTRATACIÓN</h4></td>
            </tr>
        </table>
        <div style="font-size: 10px">
            <table class="tabla" style="width: 100%">
                <tr>
                    <td>Apellido Paterno:</td>
                    <td colspan="2">{{ $trabajador->apellido_paterno }}</td>
                    <td>Apellido Materno:</td>
                    <td colspan="12">{{ $trabajador->apellido_materno }}</td>
                </tr>
                <tr>
                    <td>Nombres:</td>
                    <td colspan="15">{{ $trabajador->nombre }}</td>
                </tr>
                <tr>
                    <td>DNI:</td>
                    <td colspan="2">{{ $trabajador->rut }}</td>
                    <td>Nacionalidad:</td>
                    <td colspan="12">{{ $trabajador->nacionalidad->name }}</td>
                </tr>
                <tr>
                    <td>Fecha de Nacimiento:</td>
                    <td colspan="2">{{ $trabajador->fecha_format }}</td>
                    <td>Estado Civil:</td>
                    <td colspan="12">{{ $trabajador->estado_civil->name }}</td>
                </tr>
                <tr>
                    <td>Dirección(1)</td>
                    <td colspan="15">{{ $trabajador->direccion }}</td>
                </tr>
                <tr>
                    <td>Departamento:</td>
                    <td>{{ $trabajador->distrito->provincia->departamento->name }}</td>
                    <td>Provincia:</td>
                    <td>{{ $trabajador->distrito->provincia->name }}</td>
                    <td>Distrito:</td>
                    <td colspan="11">{{ $trabajador->distrito->name }}</td>
                </tr>
                <tr>
                    <td>Telf./Celular:</td>
                    <td colspan="2">{{ $trabajador->telefono ?? '' }}</td>
                    <td>Correo Electrónico:</td>
                    <td colspan="12">{{ $trabajador->email ?? '' }}</td>
                </tr>
                <tr>
                    <td>Dirección(2):</td>
                    <td colspan="2"></td>
                    <td>Centro de Costo:</td>
                    <td colspan="12">{{ $contrato->zona_labor->name ?? '' }}</td>
                </tr>
                <tr>
                    <td>Departamento:</td>
                    <td></td>
                    <td>Provincia:</td>
                    <td></td>
                    <td>Distrito:</td>
                    <td colspan="11"></td>
                </tr>
                <tr>
                    <td>Sistema Pensionario:</td>
                    <td></td>
                    <td>Seguro Social:</td>
                    <td>ESSALUD</td>
                    <td>Hijos:</td>
                    <td>SI</td>
                    <td colspan="2"></td>
                    <td>NO</td>
                    <td colspan="7"></td>
                </tr>
                <tr>
                    <td>Cargo:</td>
                    <td><b>{{ $contrato->oficio->name }}</b></td>
                    <td>Nivel Educativo:</td>
                    <td colspan="2"></td>
                    <td>
                        <small>¿Inst. Educ. del Perú?</small>
                    </td>
                    <td colspan="3">SI</td>
                    <td colspan="7">NO</td>
                </tr>
                <tr>
                    <td>Tipo de Institución Educativa:</td>
                    <td></td>
                    <td>Nombre de Inst. Educ.:</td>
                    <td colspan="2"></td>
                    <td>
                        <small>Régimen</small>
                    </td>
                    <td colspan="3">Pública</td>
                    <td colspan="7">Privada</td>
                </tr>
                <tr>
                    <td>Tiempo Estimado de Contrato</td>
                    <td><b>03 Meses (Periodo de Prueba)</b></td>
                    <td>Carrera</td>
                    <td colspan="2"></td>
                    <td>Año de egreso</td>
                    <td colspan="10"></td>
                </tr>
                <tr>
                    <td>Fecha de Ingreso</td>
                    <td><b>{{ $contrato->fecha_format }}</b></td>
                    <td>Troncal:</td>
                    <td><b>{{ $contrato->troncal->name ?? '' }}</b></td>
                    <td>Ruta:</td>
                    <td colspan="11"><b>{{ $contrato->ruta->name }}</b></td>
                </tr>
                <tr>
                    <td>Tipo de Trabajador:</td>
                    <td>Diario:</td>
                    <td></td>
                    <td>Destajo:</td>
                    <td></td>
                    <td>Mensual</td>
                    <td colspan="10"></td>
                </tr>
                <tr>
                    <td>Tipo de Contratos:</td>
                    <td>Parcial:</td>
                    <td> </td>
                    <td>Indefinido</td>
                    <td colspan="12"> </td>
                </tr>
                <tr>
                    <td>Sueldo Bruto:</td>
                    <td colspan="2"> </td>
                    <td>Sueldo Neto:</td>
                    <td colspan="12"> </td>
                </tr>
                <tr>
                    <td>Horario de Trabajo:</td>
                    <td colspan="2">Lunes a Sábados</td>
                    <td>Hora:</td>
                    <td colspan="12">6:15 am a 10:15am - 11:00am a 15:00pm</td>
                </tr>
                <tr>
                    <td>En caso de Emergencia, Comunicarse a:</td>
                    <td colspan="2"> </td>
                    <td>Teléf./Celular:</td>
                    <td colspan="12"> </td>
                </tr>
                <tr>
                    <td>Capacitaciones:</td>
                    <td colspan="15">
                        <b>Se realizó charla de Inducción de BPA, Seguridad y Salud Ocupacional, Bienestar Social y Remuneraciones</b>
                    </td>
                </tr>
                <tr>
                    <td>Observaciones varias:</td>
                    <td colspan="15"> </td>
                </tr>
                <br>
            </table>
            <small>Declaro Bajo Juramento que la información brindada es verdadera y que en caso se determine la falsedad de la misma, será causal de falta grave.</small>
            <br><br>
            <table class="tabla" style="width: 80%; text-align: center; margin: auto">
                <tr>
                    <td></td>
                    <td>
                        <img src="{{ public_path() . '/img/PostFirma - Daniel E  VERFRUT SAC.jpg' }}" style="width: 120px">
                    </td>
                </tr>
                <tr>
                    <td><b>Firma del Trabajador</b></td>
                    <td><b>V°B° Gerente General y/o Recursos Humanos</b></td>
                </tr>
            </table>

            <ul style="list-style: none">
                <li>______ D.N.I.</li>
                <li>______ Certificado Antecedentes Policiales</li>
                <li>______ D.N.I. Esposa</li>
                <li>______ D.N.I. Hijos</li>
                <li>______ Partida/Acta de Matrimonio o Documentación de Convivencia</li>
            </ul>
        </div>
    </section>

    <div class="page-break"></div>

    <section id="page18.5"></section>

    <div class="page-break"></div>

    <section id="page19">
        <table style="width: 100%;">
            <tr>
                <td><img src="{{ public_path() . '/img/Logo Documentos1.jpg'}}" width="50px" /></td>
                <td><h4 style="text-align: left" class="titulo">FORMATO DE ELECCIÓN DEL SISTEMA PENSIONARIO</h4></td>
            </tr>
        </table>
        <div style="font-size: 11px; text-align: justify">
            <ol style="list-style: upper-roman">
                <li>
                    <b><u>DATOS DEL TRABAJADOR</u></b><br>
                    <table style="width: 100%">
                        <tr>
                            <td>1.- APELLIDO PATERNO:</td>
                            <td style="border-bottom: 0.5px solid black"><b>{{ $trabajador->apellido_paterno }}</b></td>
                        </tr>
                        <tr>
                            <td>2.- APELLIDO MATERNO:</td>
                            <td style="border-bottom: 0.5px solid black"><b>{{ $trabajador->apellido_materno }}</b></td>
                        </tr>
                        <tr>
                            <td>3.- NOMBRES:</td>
                            <td style="border-bottom: 0.5px solid black"><b>{{ $trabajador->nombre }}</b></td>
                        </tr>
                        <tr>
                            <td>4.- TIPO DOCUMENTO:</td>
                            <td>
                                <table style="width: 100%">
                                    <tr>
                                        <td><div style="border: 1px black solid; height: 15px; width: 15px;">{{ $trabajador->nacionalidad->code === 'PE' ? 'X' : null }}</div></td>
                                        <td>DNI</td>
                                        <td>N°</td>
                                        <td style="border-bottom: 0.5px solid black; width: 65%">{{ $trabajador->nacionalidad->code === 'PE' ? $trabajador->rut : null }}</td>
                                    </tr>
                                    <tr>
                                        <td><div style="border: 1px black solid; height: 15px; width: 15px;"></div></td>
                                        <td>Carnet Extranjería</td>
                                        <td>N°</td>
                                        <td style="border-bottom: 0.5px solid black; width: 65%"></td>
                                    </tr>
                                    <tr>
                                        <td><div style="border: 1px black solid; height: 15px; width: 15px;"></div></td>
                                        <td>Pasaporte</td>
                                        <td>N°</td>
                                        <td style="border-bottom: 0.5px solid black; width: 65%"></td>
                                    </tr>
                                    <tr>
                                        <td><div style="border: 1px black solid; height: 15px; width: 15px;"></div></td>
                                        <td>Otros</td>
                                        <td>N°</td>
                                        <td style="border-bottom: 0.5px solid black; width: 65%"></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>5.- SEXO:</td>
                            <td>
                                <table style="width: 40%">
                                    <tr>
                                        <td>
                                            <div style="border: 1px black solid; height: 15px; width: 15px; margin: auto;">
                                                {{ $trabajador->sexo === 'M' ? 'X' : null }}
                                            </div>
                                        </td>
                                        <td><b>M</b></td>
                                        <td>
                                            <div style="border: 1px black solid; height: 15px; width: 15px; margin: auto;">
                                                {{ $trabajador->sexo === 'F' ? 'X' : null }}
                                            </div>
                                        </td>
                                        <td><b>F</b></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>6.- FECHA DE NACIMIENTO:</td>
                            <td style="border-bottom: 0.5px solid black"><b>{{ $trabajador->fecha_format }}</b></td>
                        </tr>
                        <tr>
                            <td>7.- DOMICILIO:</td>
                            <td style="border-bottom: 0.5px solid black"><b>{{ $trabajador->direccion }}</b></td>
                        </tr>
                        <table style="margin-left: 45px">
                            <tr>
                                <td>DISTRITO:</td>
                                <td style="border-bottom: 0.5px solid black"><b>{{ $trabajador->distrito->name }}</b></td>
                            </tr>
                            <tr>
                                <td>PROVINCIA:</td>
                                <td style="border-bottom: 0.5px solid black"><b>{{ $trabajador->distrito->provincia->name }}</b></td>
                            </tr>
                            <tr>
                                <td>DEPARTAMENTO:</td>
                                <td style="border-bottom: 0.5px solid black"><b>{{ $trabajador->distrito->provincia->departamento->name }}</b></td>
                            </tr>
                        </table>
                    </table>
                </li>
                <li>
                    <b><u>DATOS DE LA ENTIDAD EMPLEADORA</u></b><br>
                    <table>
                        <tr>
                            <td>1.- NOMBRE O RAZÓN SOCIAL:</td>
                            <td style="border-bottom: 0.5px solid black"><b>SOCIEDAD EXPORTADORA VERFRUT SAC</b></td>
                        </tr>
                        <tr>
                            <td>2.- N° DE RUC:</td>
                            <td style="border-bottom: 0.5px solid black"><b>20601438586</b></td>
                        </tr>
                        <tr>
                            <td>3.- DIRECCIÓN DEL DOMICILIO FISCAL:</td>
                            <td style="border-bottom: 0.5px solid black"><b>Mz. L Lote. 06 A.H. Ignacio Merino -PIURA</b></td>
                        </tr>
                    </table>
                </li>
                <li>
                    <b><u>DATOS DEL VÍNCULO LABORAL</u></b><br>
                    <table>
                        <tr>
                            <td>1.- FECHA DE INICIO DE LA RELACIÓN LABORAL:</td>
                            <td style="border-bottom: 0.5px solid black"><b>{{ $contrato->fecha_larga }}</b></td>
                        </tr>
                        <tr>
                            <td>2.- REMUNERACIÓN:</td>
                            <td style="border-bottom: 0.5px solid black"><b> </b></td>
                        </tr>
                    </table>
                </li>
                <li>
                    <b><u>ELECCIÓN DEL SISTEMA PENSIONARIO</u></b><br>
                    <ol>
                        <li>
                            DESEO AFILIARME (Marcar el que corresponda)<br>
                            <ul style="list-style: none">
                                <table>
                                    <tr>
                                        <td>SISTEMA NACIONAL DE PENSIONES</td>
                                        <td>
                                            <div style="border: 1px black solid; height: 15px; width: 15px;"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>SISTEMA PRIVADO DE PENSIONES (AFP)</td>
                                        <td>
                                            <div style="border: 1px black solid; height: 15px; width: 15px;"></div>
                                        </td>
                                    </tr>
                                </table>
                                <small>* Si deseas afiliarte al Sistema Privado de Pensiones, llenar los siguientes datos:</small>
                                <div>
                                    <table>
                                        <tr>
                                            <td>Correo Electrónico:</td>
                                            <td>__________________________________</td>
                                        </tr>
                                        <tr>
                                            <td>Teléfono Fijo:</td>
                                            <td>__________________________________</td>
                                        </tr>
                                        <tr>
                                            <td>Teléfono Móvil:</td>
                                            <td>__________________________________</td>
                                        </tr>
                                    </table>
                                    <table style="width: 70%">
                                        <tr>
                                            <td>Envio de estado de cuenta por correo electrónico</td>
                                            <td>
                                                <div style="border: 1px black solid; height: 15px; width: 15px; margin: auto;"></div>
                                            </td>
                                            <td>SI</td>
                                            <td>
                                                <div style="border: 1px black solid; height: 15px; width: 15px; margin: auto;"></div>
                                            </td>
                                            <td>
                                                NO
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </ul>
                        </li>
                        <li>
                            ESTOY ACTUALMENTE AFILIADO (Marcar el que corresponda)<br>
                            <table style="font-weight: bold; margin: auto; width: 50%;">
                                <tr>
                                    <td>
                                        <div style="border: 1px black solid; height: 15px; width: 15px; margin: auto;"></div>
                                    </td>
                                    <td>INTEGRA</td>
                                    <td>
                                        <div style="border: 1px black solid; height: 15px; width: 15px; margin: auto;"></div>
                                    </td>
                                    <td>PRIMA</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div style="border: 1px black solid; height: 15px; width: 15px; margin: auto;"></div>
                                    </td>
                                    <td>PROFUTURO</td>
                                    <td>
                                        <div style="border: 1px black solid; height: 15px; width: 15px; margin: auto;"></div>
                                    </td>
                                    <td>HABITAT</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div style="border: 1px black solid; height: 15px; width: 15px; margin: auto;"></div>
                                    </td>
                                    <td>HORIZONTE</td>
                                    <td>
                                        <div style="border: 1px black solid; height: 15px; width: 15px; margin: auto;"></div>
                                    </td>
                                    <td>O.N.P.</td>
                                </tr>
                            </table>
                        </li>
                    </ol>
                </li>
            </ol>
            <small>
                DECLARO HABER RECIBIDO EL BOLETIN INFORMATIVO SOBRE LAS CARACTERÍSTICAS, DIFERENCIAS Y DEMÁS PECULIARIDADES PENSIONARIOS VIGENTES SPP - SNP.
            </small>
            <br><br><br>
            <table style="width: 100%">
                <tr>
                    <td style="text-align: right; font-size: 12px">
                        <b>Firma del trabajador</b>
                    </td>
                    <td style="border-bottom: 0.5px solid black">

                    </td>
                </tr>
                <tr>
                    <td><b>RR.HH. - {{ $contrato->anio_contrato }}</b></td>
                    <td style="text-align: right">Piura, {{ $contrato->fecha_larga }}</td>
                </tr>
            </table>
            <small>{{ $trabajador->rut }}</small>
        </div>
    </section>

    <section id="page20"></section>

    <div class="page-break"></div>

    {{-- <div class="page-break"></div>

    <section>
        <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
        <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
        <br /><br /><br /><br /><br /><br /><br /><br /><br />
        <div style="text-align: center">
            _______________________________<br />
            <b>{{ $trabajador->nombre_completo }}</b><br />
            <b>DNI: {{ $trabajador->rut }}</b>
        </div>
    </section>

    <div class="page-break"></div> --}}

    <div class="page-break"></div>

    <section id="page22">
        <img src="{{ public_path() . '/img/Logo Documentos1.jpg'}}" width="50px" />
        <h4 class="titulo">MEMORÁNDUM N° 001-{{ $contrato->anio_contrato }}-G.GRAL./VERFRUT </h4>
        <br>
        <div style="font-size: 13px;">
            <table style="font-weight: bold">
                <tr>
                    <td>A:</td>
                    <td>TODO EL PERSONAL</td>
                </tr>
                <tr>
                    <td>DE:</td>
                    <td>GERENCIA GENERAL</td>
                </tr>
                <tr>
                    <td>ASUNTO:</td>
                    <td>ENTREGA DE BOLETA DIGITAL</td>
                </tr>
                <tr>
                    <td>FECHA:</td>
                    <td>{{ strtoupper($contrato->fecha_larga) }}</td>
                </tr>
            </table>
            <br>
            <hr>
            <br>
            <p>
                Por medio de la presente, tenemos a bien a comunicarnos con usted con la finalidad de informarle lo siguiente:
            </p>

            <p>
                Que en ejercicio de nuestro poder de dirección y al amparo de lo que establece el artículo 3° numeral 3.2° Decreto Legislativo Nº 1310, Decreto Legislativo que aprueba medidas adicionales de simplificación administrativa y demás normas complementarias; a partir del mes de {{ $contrato->mes_contrato }}, La Empresa realizará la entrega de sus boletas de pago de remuneraciones en forma digital, las cuales pondremos a su disponibilidad a través de la Plataforma <b>“verfrut.turecibo.com”</b>.
            </p>

            <p>
                Las boletas de pago serán puestas a su disposición en la plataforma virtual, de manera mensual, a más tardar el tercer día hábil siguiente a la fecha de pago de la remuneración, siendo su obligación acusar recibo de la boleta de pago en la plataforma virtual dentro del día hábil siguiente de recibida. En caso de incumplimiento de esta obligación, la Empresa podrá aplicar las sanciones disciplinarias que considere pertinentes.
            </p>

            <p>
                Asimismo, le informamos que para poder acceder a la plataforma en mención, el área de Recursos Humanos le hará entrega de su usuario y clave en el desglosable de este documento.
            </p>

            <p>Atentamente,</p>
            <br>

            <img src="{{ public_path() . '/img/PostFirma - Daniel E  VERFRUT SAC.jpg'}}" width="150px" style="margin-left: 300px" />

            <br /><br />

            <div style="font-weight: bold;">
                _______________________________________________<br>
                Nombre: <span>{{ $trabajador->nombre . ' ' . $trabajador->apellidos }}</span><br>
                DNI: <span>{{ $trabajador->rut }}</span><br>
                Fecha de recepción: {{ $contrato->fecha_larga }}
            </div>
            <br>
            <hr>
            <br>
            <div>
                <div>
                    <span style="font-weight: bold; background: gray">USUARIO: {{ $trabajador->rut }}</span> <br>
                    <span style="font-weight: bold; background: gray">CLAVE: {{ $trabajador->fecha_format }}</span>
                </div>
                <div>
                    <b>RECUERDA:</b> La primera vez que ingreses, deberás cambiar la contraseña por una de tu elección y de fácil recordación. Como mínimo debe tener 8 dígitos. <u>No olvides firmar tu boleta, es tu obligación</u>. Para cualquier consulta, acércate a la oficina de Recursos Humanos de tu fundo. <br> <b>Página Web:</b> verfrut.turecibo.com
                </div>
            </div>

        </div>

    </section>

    <div class="page-break"></div>
    {{-- <div class="page-break"></div>

    <section>
        <img src="{{ public_path() . '/img/la-positiva.png'}}" width="150px" />
        <h4 class="titulo" style="font-size: 13px;">
            DECLARACION DE BENEFICIARIOS PARA SEGUROS DE VIDA LEY D. LEG. 688
        </h4>
        <h4 style="text-align: center;" style="font-size: 13px">
            DECLARACION JURADA
        </h4>
        <div style="font-size: 13px;">
            <p style="text-align: center;">
                Quien suscribe, en cumplimiento de lo dispuesto en el artículo 6 del Decreto Legislativo 688, efectúa su Declaración de Beneficiarios.
            </p>

            <p>
                PRIMER BENEFICIARIO: Cónyuge o Conviviente y sus descendientes (hijos, nietos, bisnietos). Para efectos de acreditar la convivencia, se debe tener declaración notarial o judicial de convivencia.
            </p>

            <p>
                Las boletas de pago serán puestas a su disposición en la plataforma virtual, de manera mensual, a más tardar el tercer día hábil siguiente a la fecha de pago de la remuneración, siendo su obligación acusar recibo de la boleta de pago en la plataforma virtual dentro del día hábil siguiente de recibida. En caso de incumplimiento de esta obligación, la Empresa podrá aplicar las sanciones disciplinarias que considere pertinentes.
            </p>

            <p>
                Asimismo, le informamos que para poder acceder a la plataforma en mención, el área de Recursos Humanos le hará entrega de su usuario y clave en el desglosable de este documento.
            </p>

            <p>Atentamente,</p>
            <br>

            <img src="{{ public_path() . '/img/PostFirma - Daniel E  VERFRUT SAC.jpg'}}" width="150px" style="margin-left: 300px" />

            <br /><br />

            <div style="font-weight: bold;">
                _______________________________________________<br>
                Nombre: <span>{{ $trabajador->nombre . ' ' . $trabajador->apellidos }}</span><br>
                DNI: <span>{{ $trabajador->rut }}</span><br>
                Fecha de recepción: {{ $contrato->fecha_larga }}
            </div>
            <br>
            <hr>
            <br>
            <div>
                <div>
                    <span style="font-weight: bold; background: gray">USUARIO: {{ $trabajador->rut }}</span> <br>
                    <span style="font-weight: bold; background: gray">CLAVE: {{ $trabajador->fecha_format }}</span>
                </div>
                <div>
                    <b>RECUERDA:</b> La primera vez que ingreses, deberás cambiar la contraseña por una de tu elección y de fácil recordación. Como mínimo debe tener 8 dígitos. <u>No olvides firmar tu boleta, es tu obligación</u>. Para cualquier consulta, acércate a la oficina de Recursos Humanos de tu fundo. <br> <b>Página Web:</b> verfrut.turecibo.com
                </div>
            </div>
        </div>
    </section> --}}

    <div class="page-break"></div>

    <section>
        <img src="{{ public_path() . '/img/la-positiva.png'}}" width="150px" />
        <h4 class="titulo" style="font-size: 13px;">
            DECLARACION DE BENEFICIARIOS PARA SEGUROS DE VIDA LEY D. LEG. 688
        </h4>
        <h4 style="text-align: center;" style="font-size: 12px">
            DECLARACION JURADA
        </h4>
        <div style="font-size: 13px;">
            <p style="text-align: center;">
                Quien suscribe, en cumplimiento de lo dispuesto en el artículo 6 del Decreto Legislativo 688, efectúa su Declaración de Beneficiarios.
            </p>

            <p>
                <u>PRIMER BENEFICIARIO: Cónyuge o Conviviente y sus descendientes (hijos, nietos, bisnietos).</u><br /> Para efectos de acreditar la convivencia, se debe tener declaración notarial o judicial de convivencia.
            </p>

            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td>
                        <u><b>Nombres y Apellidos</b></u>
                    </td>
                    <td>
                        <u><b>Parentesco</b></u>
                    </td>
                    <td>
                        <u><b>Edad</b></u>
                    </td>
                    <td>
                        <u><b>Dirección</b></u>
                    </td>
                </tr>
                <tr>
                    <td>1. .......................................................</td>
                    <td>...................................</td>
                    <td>............</td>
                    <td>...................................</td>
                </tr>
                <tr>
                    <td>2. .......................................................</td>
                    <td>...................................</td>
                    <td>............</td>
                    <td>...................................</td>
                </tr>
                <tr>
                    <td>3. .......................................................</td>
                    <td>...................................</td>
                    <td>............</td>
                    <td>...................................</td>
                </tr>
                <tr>
                    <td>4. .......................................................</td>
                    <td>...................................</td>
                    <td>............</td>
                    <td>...................................</td>
                </tr>
                <tr>
                    <td>5. .......................................................</td>
                    <td>...................................</td>
                    <td>............</td>
                    <td>...................................</td>
                </tr>
                <tr>
                    <td>6. .......................................................</td>
                    <td>...................................</td>
                    <td>............</td>
                    <td>...................................</td>
                </tr>
            </table>
            <br />
            <p>
                <u>A FALTA DE PRIMEROS BENEFICIARIOS: Padres, Abuelos y hermanos menores de dieciocho (18) años</u>
            </p>
            <table style="width: 100%">
                <tr>
                    <td>
                        <u><b>Nombres y Apellidos</b></u>
                    </td>
                    <td>
                        <u><b>Parentesco</b></u>
                    </td>
                    <td>
                        <u><b>Edad</b></u>
                    </td>
                    <td>
                        <u><b>Dirección</b></u>
                    </td>
                </tr>
                <tr>
                    <td>1. .......................................................</td>
                    <td>...................................</td>
                    <td>............</td>
                    <td>...................................</td>
                </tr>
                <tr>
                    <td>2. .......................................................</td>
                    <td>...................................</td>
                    <td>............</td>
                    <td>...................................</td>
                </tr>
                <tr>
                    <td>3. .......................................................</td>
                    <td>...................................</td>
                    <td>............</td>
                    <td>...................................</td>
                </tr>
                <tr>
                    <td>4. .......................................................</td>
                    <td>...................................</td>
                    <td>............</td>
                    <td>...................................</td>
                </tr>
                <tr>
                    <td>5. .......................................................</td>
                    <td>...................................</td>
                    <td>............</td>
                    <td>...................................</td>
                </tr>
                <tr>
                    <td>6. .......................................................</td>
                    <td>...................................</td>
                    <td>............</td>
                    <td>...................................</td>
                </tr>
            </table>
            <br />
            <p>
                <b>Nombres y Apellidos del trabajador Asegurado</b>
            </p>
            <p>........................................................................................................................................................................</p>
            <p>
                <b>DNI N°:</b> .............................................
            </p>
            <br />
            <p>
                <b>Firma del Asegurado que debe ser certificada notarialemente:</b> ........................................................................
            </p>
        </div>
    </section>

    <div class="page-break"></div>
@endsection
