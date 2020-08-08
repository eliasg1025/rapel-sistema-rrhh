@extends('pdf-layout')

@section('titulo')
    ELECCION SISTEMA PENSIONARIO VERFRUT
@endsection

<style>
    * {
        font-family: Arial, Helvetica, sans-serif;
    }
</style>

@section('contenido')
    <section id="page19">
        <table style="width: 100%;">
            <tr>
                <td><img src="{{ public_path() . '/img/Logo Documentos1.jpg'}}" width="60px" /></td>
                <td><h4 style="text-align: left" class="titulo">FORMATO DE ELECCIÓN DE SISTEMA PENSIONARIO</h4></td>
                <td>
                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate($codigo)) !!}" />
                </td>
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
                            <td style="border-bottom: 0.5px solid black; font-size: 9px"><b>{{ $trabajador->direccion }}</b></td>
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
                            <td>1.- NOMBRE O RAZON SOCIAL:</td>
                            <td style="border-bottom: 0.5px solid black"><b>SOCIEDAD EXPORTADORA VERFRUT SAC</b></td>
                        </tr>
                        <tr>
                            <td>2.- N° DE RUC:</td>
                            <td style="border-bottom: 0.5px solid black"><b>20601438586</b></td>
                        </tr>
                        <tr>
                            <td>3.- DEPARTAMENTO DEL DOMICILIO FISCAL:</td>
                            <td style="border-bottom: 0.5px solid black"><b>Mz. L Lote. 06 A.H. Ignacio Merino -PIURA</b></td>
                        </tr>
                    </table>
                </li>
                <li>
                    <b><u>DATOS DEL VÍNCULO LABORAL</u></b><br>
                    <table>
                        <tr>
                            <td>1.- FECHA DE INICIO DE LA RELACION:</td>
                            <td style="border-bottom: 0.5px solid black"><b>{{ $eleccion_afp->fecha_larga }}</b></td>
                        </tr>
                        <tr>
                            <td>2.- REMUNERACIÓN:</td>
                            <td style="border-bottom: 0.5px solid black"><b></b></td>
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
                                            <div style="border: 1px black solid; height: 15px; width: 15px;">X</div>
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
                                            <td>Envio de estado de cuenta por correo</td>
                                            <td>
                                                <div style="border: 1px black solid; height: 15px; width: 15px; margin: auto;">
                                                </div>
                                            </td>
                                            <td>SI</td>
                                            <td>
                                                <div style="border: 1px black solid; height: 15px; width: 15px; margin: auto;">
                                                </div>
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
                                        <div style="border: 1px black solid; height: 15px; width: 15px; margin: auto;">
                                        </div>
                                    </td>
                                    <td>INTEGRA</td>
                                    <td>
                                        <div style="border: 1px black solid; height: 15px; width: 15px; margin: auto;">
                                        </div>
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
                                        <div style="border: 1px black solid; height: 15px; width: 15px; margin: auto;">X</div>
                                    </td>
                                    <td>O.N.P.</td>
                                </tr>
                            </table>
                        </li>
                    </ol>
                </li>
            </ol>
            <small>
                DECLARO HABER RECIBIDO EL BOLETIN INFORMATIVO SOBRE LAS CARACTERÍSTICAS, DIFERENCIAS Y DEMÁS PECULIARIDADES PERNSIONARIOS VIGENTES SPP - SNP.
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
                    <td><b>RR.HH. - {{ $eleccion_afp->anio_contrato }}</b></td>
                    <td style="text-align: right">Piura, {{ $eleccion_afp->fecha_larga_solicitud }}</td>
                </tr>
            </table>
            <small>{{ $trabajador->rut }}</small>
        </div>
    </section>
@endsection
