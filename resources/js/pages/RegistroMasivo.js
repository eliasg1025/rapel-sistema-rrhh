import React, { useState, useEffect } from 'react';
import { Alert, Card, Modal, notification, Form, Row, Col, Button, message } from 'antd';
import moment from 'moment';

import AgregarTrabajador from "../components/RegistroMasivo/AgregarTrabajador";
import ListaTrabajadores from "../components/RegistroMasivo/ListaTrabajadores";
import DatosContrato from "../components/RegistroIndividual/DatosContrato";

const RegistroMasivo = props => {
    const [registrando, setRegistrando] = useState(false);
    const [contrato, setContrato] = useState({
        empresa_id: 9,
        zona_labor_id: '',
        grupo: '',
        regimen_id: '',
        fecha_ingreso: moment().add(1, 'days').format('YYYY-MM-DD').toString(),
        fecha_termino: moment().add(91, 'days').format('YYYY-MM-DD').toString(),
        oficio_id: '',
        cuartel_id: '',
        agrupacion_id: '',
        actividad_id: '',
        labor_id: '',
        tipo_contrato_id: '',
        tipo_trabajador: '',
        ruta_id: '',
        troncal_id: '',
    });
    const [trabajadores, setTrabajadores] = useState([]);
    const [loading, setLoading] = useState(false);
    const [errores, setErrores] = useState([]);

    const [zonasLabor, setZonasLabor] = useState([]);
    const [regimenes, setRegimenes] = useState([]);
    const [oficios, setOficios] = useState([]);
    const [actividades, setActividades] = useState([]);
    const [agrupaciones, setAgrupaciones] = useState([]);
    const [tiposContratos, setTiposContratos] = useState([]);
    const [cuarteles, setCuarteles] = useState([]);
    const [labores, setLabores] = useState([]);
    const [rutas, setRutas] = useState([]);
    const [troncales, setTroncales] = useState([]);

    const ListaErrores = errores => {
        console.log('ListaErrores: ', errores);
        return (
            <ul>
                {errores.errores.map((err, index) => (
                    <li key={index}>
                        <b>RUT: {err.rut}</b> - {err.error}
                    </li>
                ))}
            </ul>
        );
    };

    const clearData = nrs => {
        return nrs.map(nr => {
            for (const key in nr['trabajador']) {
                if (nr['trabajador'][key] == null) {
                    nr['trabajador'][key] = '';
                }
            }
            return nr;
        });
    };

    const guardarTrabajadores = () => {
        setLoading(true);

        if (trabajadores.length !== 0) {
            axios.post('http://192.168.60.16/api/trabajador/revision', {trabajadores})
                .then(res => {
                    const registrados = res.data.registrados || [];
                    const no_registrados = res.data.no_registrados || [];

                    const trabajadores_enviar = {
                        registrados: clearData([...registrados]),
                        no_registrados: [...no_registrados],
                    };

                    console.log('Sended payload: ', trabajadores_enviar);

                    Modal.confirm({
                        title: 'Resultados',
                        content: (
                            <div>
                                Se encontraton{' '}
                                <b>
                                    {trabajadores_enviar.registrados.length}{' '}
                                    trabajadores
                                </b>{' '}
                                en el sistema, se realizarán{' '}
                                <b>
                                    <u>
                                        {trabajadores_enviar.no_registrados.length}{' '}
                                        consultas
                                    </u>
                                </b>{' '}
                                a la RENIEC o se tiene que agregar manualmente:
                                <br />
                                <div style={{ background: '#eee', border: '1px solid black', padding: '5px' }}>
                                    {trabajadores_enviar.no_registrados.length > 0 && (
                                        <ListaNoRegistrados
                                            no_registrados={trabajadores_enviar.no_registrados}
                                        />
                                    )}
                                </div>
                            </div>
                        ),
                        okText: 'Aceptar',
                        cancelText: 'Cancelar',
                        onOk() {
                            setLoading(true);
                            registroMasivo(trabajadores_enviar);
                        },
                    });
                })
                .catch(err => {
                    console.log(err.response);
                })
                .finally(() => {
                    setLoading(false);
                });
        } else {
            setLoading(false);
            setRegistrando(false);
        }
    };

    const ListaNoRegistrados = no_registrados => {
        console.log('No registrados: ', no_registrados);
        return (
            <ul>
                {no_registrados.no_registrados.map(e => <li key={e.key}>{e.rut}</li>)}
            </ul>
        );
    };

    const registroMasivo = trabajadores_enviar => {
        axios.post('/api/contrato/registro-masivo', trabajadores_enviar)
            .then(res => {
                const { guardados, errores} = res.data;
                console.log('Resultado registro masivo: ', res.data);

                setErrores(errores);
                if (guardados) {
                    eliminarYaGuardados(guardados);
                    notification['success']({
                        message: `Se guardaron ${
                            guardados.length || 0
                        } registros`,
                    });

                    const observados = guardados.filter(
                        item => item.observado === true
                    );

                    notification['warning']({
                        message: `Hay ${observados.length} trabajadores con observación, por favor verificar en la pestaña Trabajador`,
                    });
                } else {
                    notification['warning']({
                        message: 'No se pudo guardar ninguno de los trabajadores'
                    });
                }
            })
            .catch(err => {
                console.error(err);
            })
            .finally(() => {
                setLoading(false);
            });
    };

    const eliminarYaGuardados = guardados => {
        let xd = [...trabajadores];
        guardados.forEach(g => {
            const index = xd.findIndex(t => t.rut == g.rut);
            if (index > -1) xd.splice(index, 1);
        });
        setTrabajadores(xd);
    };

    const validForm = () => {
        if (
            contrato.codigo_bus !== '' &&
            contrato.grupo !== '' &&
            contrato.empresa_id !== '' &&
            contrato.zona_labor_id !== '' &&
            contrato.fecha_ingreso !== '' &&
            contrato.cuartel_id !== '' &&
            contrato.agrupacion_id !== '' &&
            contrato.regimen_id !== '' &&
            contrato.actividad_id !== '' &&
            contrato.labor_id !== '' &&
            contrato.tipo_contrato_id !== '' &&
            contrato.oficio_id !== '' &&
            contrato.troncal_id !== '' &&
            contrato.ruta_id !== '' &&
            contrato.tipo_trabajador !== ''
        ) {
            return true;
        }
        return false;
    };

    const empezarRegistro = () => {
        if (validForm()) {
            message.info('Empezo el registro de trabajadores');
            setRegistrando(true);
        } else {
            notification['warning']({
                message: 'Debe completar el formulario',
            });
        }
    };

    const terminarRegistro = () => {
        Modal.confirm({
            title: 'Terminar proceso',
            content: `¿Esta seguro que desea terminar con el registro? Se revisará los dni de los trabajadores antes de registrarlos`,
            okText: 'Aceptar',
            onOk() {
                guardarTrabajadores();
                //setRegistrando(false);
            },
        });
    };

    return (
        <div className="registro-masivo">
            <h4>Registro Masivo</h4>
            <hr />
            <DatosContrato
                contrato={contrato}
                setContrato={setContrato}
                regimenes={regimenes}
                oficios={oficios}
                actividades={actividades}
                agrupaciones={agrupaciones}
                tiposContratos={tiposContratos}
                cuarteles={cuarteles}
                labores={labores}
                zonasLabor={zonasLabor}
                rutas={rutas}
                troncales={troncales}
                setRegimenes={setRegimenes}
                setOficios={setOficios}
                setActividades={setActividades}
                setAgrupaciones={setAgrupaciones}
                setTiposContratos={setTiposContratos}
                setCuarteles={setCuarteles}
                setLabores={setLabores}
                setZonasLabor={setZonasLabor}
                setRutas={setRutas}
                setTroncales={setTroncales}
            />
            <Card>
                <Form>
                    <Row gutter={16}>
                        <Col>
                            <Button
                                type="primary"
                                htmlType="submit"
                                onClick={empezarRegistro}
                                disabled={registrando}
                            >
                                Empezar
                            </Button>
                        </Col>
                        <Col>
                            <Button
                                type="danger"
                                htmlType="submit"
                                onClick={terminarRegistro}
                                disabled={!registrando}
                                loading={loading}
                            >
                                Terminar
                            </Button>
                        </Col>
                    </Row>
                </Form>
            </Card>
            <br />
            <AgregarTrabajador
                form={contrato}
                registrando={registrando}
                trabajadores={trabajadores}
                setTrabajadores={setTrabajadores}
                regimenes={regimenes}
                oficios={oficios}
                actividades={actividades}
                agrupaciones={agrupaciones}
                tiposContratos={tiposContratos}
                cuarteles={cuarteles}
                labores={labores}
                rutas={rutas}
                troncales={troncales}
            />
            <br />
            {errores.length > 0 ? (
                <Alert
                    message="Error al guardar"
                    description={<ListaErrores errores={errores} />}
                    type="error"
                    showIcon
                />
            ) : (
                ''
            )}

            <ListaTrabajadores
                trabajadores={trabajadores}
                setTrabajadores={setTrabajadores}
                loading={loading}
            />
        </div>
    );
}

export default RegistroMasivo;
