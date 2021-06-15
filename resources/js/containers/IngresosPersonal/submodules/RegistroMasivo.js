import React, { useState, useEffect, useReducer } from 'react';
import { Alert, Card, Modal, notification, Form, Row, Col, Button, message, Switch, Progress } from 'antd';
import moment from 'moment';
import Axios from 'axios';

import ModalCustom from '../../Modal';
import AgregarTrabajador from "../components/RegistroMasivo/AgregarTrabajador";
import ListaTrabajadores from "../components/RegistroMasivo/ListaTrabajadores";
import DatosContrato from "../components/RegistroIndividual/DatosContrato";


export const RegistroMasivo = () => {

    const { token } = JSON.parse(sessionStorage.getItem("data"));

    const [registroReniec, setRegistroReniec] = useState(true);
    const [registrando, setRegistrando] = useState(false);
    const [datosContratoValido, setDatosContratoValido] = useState(false);
    const [contrato, setContrato] = useState({
        empresa_id: 9,
        zona_labor_id: '',
        grupo: '',
        regimen_id: '',
        fecha_ingreso: moment().add(1, 'days').format('YYYY-MM-DD').toString(),
        fecha_termino: moment().add(92, 'days').format('YYYY-MM-DD').toString(),
        oficio_id: '',
        cuartel_id: '',
        agrupacion_id: '',
        actividad_id: '',
        labor_id: '',
        tipo_contrato_id: '',
        tipo_trabajador: '',
        ruta_id: '',
        troncal_id: '',
        sueldo: 0,
    });
    const [trabajadores, setTrabajadores] = useState([]);
    const [loading, setLoading] = useState(false);
    const [errores, setErrores] = useState([]);
    const [viewConfigModal, setViewConfigModal] = useState(false);

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

    const [completed, dispatchCompleted] = useReducer((state, action) => {
        switch (action.type) {
            case 'increment':
                return state + 1;
            case 'decrement':
                return state - 1;
            default:
                throw new Error();
        }
    }, 0);

    const [newTrabajadores, dispatchtNewTrabajadores] = useReducer((state, action) => {
        const { type, value } = action;

        switch (type) {
            case 'add':
                return [
                    ...state,
                    {
                        ...value.trabajador,
                        estado: { descripcion: 'SIN PROCESAR', color: 'default' }
                    }
                ];
            case 'remove':
                return state.filter(t => t.rut !== value.trabajador.rut);
            case 'success':
                return [
                    {
                        ...value.trabajador,
                        estado: { descripcion: 'PROCESADO', color: 'success' },
                        resultado: value.resultado
                    },
                    ...state.filter(t => t.rut !== value.trabajador.rut),
                ];
            case 'failure':
                return [
                    {
                        ...value.trabajador,
                        estado: { descripcion: 'ERROR', color: 'error' },
                        resultado: value.resultado
                    },
                    ...state.filter(t => t.rut !== value.trabajador.rut),
                ];
            default:
                return state;
        }
    }, []);

    /* useEffect(() => {
        fetchProcesosContratos();
    }, []);

    const fetchProcesosContratos = async () => {
        try {
            const res = await Axios.get('/api/procesos-contratos', { headers: { Authorization: token } });
            console.log(res);
        } catch (err) {
            console.log(err);
        }
    }

    const createProcesosContratos = async () => {
        try {
            const data = {
                contrato,
                datos_reniec: registroReniec
            };
            const res = await Axios.post('/api/procesos-contratos', data, { headers: { Authorization: token } });
            console.log(res);

        } catch (err) {
            console.log(err);
            notification['error']({
                message: 'Error al guardar registro'
            });
        }
    } */

    const percent = newTrabajadores.length > 0
        ? Math.round((completed / newTrabajadores.length) * 100)
        : 0;

    const ListaNoRegistrados = no_registrados => {
        return (
            <ul>
                {no_registrados.no_registrados.map(e => <li key={e.key}>{e.rut}</li>)}
            </ul>
        );
    };

    const ListaErrores = errores => {
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

    const revisionConReniec = async () => {
        /* try {
            const res = await Axios.post('http://192.168.60.16/api/trabajador/revision/sin-trabajadores', {
                trabajadores: trabajadores.filter(t => t.estado.descripcion === 'SIN PROCESAR')
            })
            consultaMasivaReniec(res.data);
        } catch (err) {
            console.log(err.response);
            setLoading(false);
        } */

        const _trabajadores = newTrabajadores.filter(t => t.estado.descripcion === 'SIN PROCESAR');
        const dnis = _trabajadores.map(t => t.rut);

        const buscar = async dni => {
            try {
                const { data: { message } } = await Axios.post(`/api/contrato/registro-reniec`, {
                    dni,
                    contrato: newTrabajadores.find(t => t.rut === dni)
                });
                dispatchtNewTrabajadores({
                    type: 'success',
                    value: {
                        trabajador: _trabajadores.find(t => t.rut === dni),
                        resultado: message
                    }
                });
            } catch (err) {
                const { message } = err.response.data;

                dispatchtNewTrabajadores({
                    type: 'failure',
                    value: {
                        trabajador: _trabajadores.find(t => t.rut === dni),
                        resultado: message
                    }
                });
            }
        }

        async function executeSequentially() {
            for (let index = 0; index < dnis.length; index++) {
                await buscar(dnis[index]);
                dispatchCompleted({ type: 'increment' });
            }
        }

        setLoading(true);
        await executeSequentially();
        setLoading(false);
    };

    const revisionSinReniec = () => {
        Axios.post('http://192.168.60.16/api/trabajador/revision', {trabajadores})
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
    };

    const consultaMasivaReniec = data => {
        Axios.post('/api/trabajador/reniec/masiva', data)
            .then(res => {
                console.log('Consulta masiva RENIEC:', res.data);
                if (res.status >= 400){
                    throw new Error();
                }

                const trabajadores_enviar = {
                    registrados: clearData(res.data),
                };
                registroMasivo(trabajadores_enviar);
            })
            .catch(err => {
                console.log(err.response);
                notification['error']({
                    message: 'Algo salió mal al tratar de obtener los datos de la RENIEC',
                });
                setLoading(false);
            })
    };

    const registroMasivo = trabajadores_enviar => {
        Axios.post('/api/contrato/registro-masivo', trabajadores_enviar)
            .then(res => {
                const { guardados, errores} = res.data;
                // console.log('Resultado registro masivo: ', res.data);

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
            if (index > -1) {
                xd.splice(index, 1);
            }
        });
        setTrabajadores(xd);
    };

    const validForm = () => {
        const result =
            contrato.empresa_id !== '' &&
            contrato.regimen_id !== '' &&
            contrato.zona_labor_id !== '' &&
            contrato.fecha_ingreso !== '' &&
            contrato.cuartel_id !== '' &&
            contrato.agrupacion_id !== '' &&
            contrato.actividad_id !== '' &&
            contrato.labor_id !== '' &&
            contrato.tipo_contrato_id !== '' &&
            contrato.oficio_id !== '';

        if (contrato.regimen_id == 3) {
            return result && (
                contrato.codigo_bus !== '' &&
                contrato.grupo !== '' &&
                contrato.tipo_trabajador !== '' &&
                contrato.troncal_id !== '' &&
                contrato.ruta_id !== ''
            );
        } else {
            return result && (
                contrato.sueldo !== 0
            );
        }
    };

    const empezarRegistro = () => {
        if (validForm()) {
            message.info('Empezo el registro de trabajadores');
            // createProcesosContratos();
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
                if (newTrabajadores.length !== 0) {
                    if (registroReniec) {
                        revisionConReniec();
                    } else {
                        revisionSinReniec();
                    }
                } else {
                    setRegistrando(false);
                }
            },
        });
    };

    return (
        <div className="registro-masivo">
            <Row>
                <Col span={4} sm={24} xs={24}>
                    <h4>
                        Registro Masivo&nbsp;<a href="#" onClick={e => {
                            e.preventDefault();
                            setViewConfigModal(true);
                        }}>
                            <i className="fas fa-cog"></i>
                        </a>
                    </h4>
                </Col>
            </Row>
            <br />
            <DatosContrato
                contrato={contrato}
                setDatosContratoValido={setDatosContratoValido}
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
                newTrabajadores={newTrabajadores}
                dispatchNewTrabajadores={dispatchtNewTrabajadores}
                regimenes={regimenes}
                oficios={oficios}
                actividades={actividades}
                agrupaciones={agrupaciones}
                tiposContratos={tiposContratos}
                cuarteles={cuarteles}
                labores={labores}
                rutas={rutas}
                troncales={troncales}
                zonasLabor={zonasLabor}
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
            <b style={{ fontSize: "13px" }}>
                Cantidad: {newTrabajadores.length} registros
            </b>
            <br /><br />
            {loading && (
                <>
                    <Progress percent={percent} />
                    <b style={{ fontSize: '13px', marginTop: '2px' }}>Completados {completed} de {newTrabajadores.length}</b>
                    <br /><br />
                </>
            )}
            <ListaTrabajadores
                newTrabajadores={newTrabajadores}
                dispatchNewTrabajadores={dispatchtNewTrabajadores}
                loading={loading}
            />
            <ModalCustom
                isVisible={viewConfigModal}
                setIsVisible={setViewConfigModal}
                title="Configuración"
            >
                Datos de Reniec: <Switch defaultChecked onChange={checked => setRegistroReniec(checked)}/>
            </ModalCustom>
        </div>
    );
}
