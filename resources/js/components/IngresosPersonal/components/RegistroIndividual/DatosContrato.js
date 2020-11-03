import React, { useState, useEffect } from 'react';
import {Card, Form, Input, Select, Row, Col, DatePicker, notification, message} from 'antd';
import moment from 'moment';

import { empresa, tipos_trabajadores } from '../../../../data/default.json';

const DatosContrato = props => {
    const {
        setDatosContratoValido,
        contrato, setContrato, regimenes, oficios, actividades, agrupaciones, tiposContratos, cuarteles, labores, zonasLabor,
        rutas, troncales, setRegimenes, setOficios, setActividades, setAgrupaciones, setTiposContratos, setCuarteles, setLabores,
        setZonasLabor, setRutas, setTroncales
    } = props;

    const [loadingZonaLabores, setLoadingZonaLabores] = useState(false);
    const [loadingRegimenes, setLoadingRegimenes] = useState(false);
    const [loadingOficios, setLoadingOficios] = useState(false);
    const [loadingActividades, setLoadingActividades] = useState(false);
    const [loadingAgrupaciones, setLoadingAgrupaciones] = useState(false);
    const [loadingTiposContratos, setLoadingTiposContratos] = useState(false);
    const [loadingCuarteles, setLoadingCuarteles] = useState(false);
    const [loadingLabores, setLoadingLabores] = useState(false);
    const [loadingTroncales, setLoadingTroncales] = useState(false);
    const [loadingRutas, setLoadingRutas] = useState(false);

    const layout = {
        labelCol: {
            md: 6,
        },
    };

    const handleChangeInput = e => {
        const { name, value } = e.target;
        setContrato({
            ...contrato,
            [name]: value,
        });
    };

    const validacionDatosContrato = () => {
        return contrato.codigo_bus !== '' &&
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
            contrato.tipo_trabajador !== '';
    };

    useEffect(() => {
        if (validacionDatosContrato()) {
            setDatosContratoValido(true);
        } else {
            setDatosContratoValido(false);
        }
    }, [contrato]);

    const setChangeFechaIngreso = (date, dateString) => {
        setContrato({
            ...contrato,
            fecha_ingreso: dateString,
            fecha_termino: moment(dateString)
                .add(91, 'days')
                .format('YYYY-MM-DD')
                .toString(),
        });
    };

    useEffect(() => {
        if (contrato.regimen_id === 3) {
            setContrato({
                ...contrato,
                oficio_id: '3',
                cuartel_id: 'SCG',
                agrupacion_id: 3,
                actividad_id: "111",
                labor_id: 61,
                tipo_contrato_id: 10
            });
        }
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [contrato.regimen_id]);

    /**
     * Fetching data
     */
    const url = 'http://192.168.60.16/api';

    useEffect(() => {
        setLoadingRegimenes(true);
        let intentos = 0;
        function fetchRegimenes() {
            intentos++;
            Axios.get(`${url}/regimen`)
                .then(res => {
                    setRegimenes(res.data.data);
                    setLoadingRegimenes(false);
                })
                .catch(err => {
                    console.log(err);
                    if (intentos < 5) {
                        fetchRegimenes();
                    } else {
                        notification['warning']({
                            message: 'Error al obtener los departamentos, vuelva a cargar la página',
                        });
                    }
                });
        }
        fetchRegimenes();
    }, []);

    useEffect(() => {
        setLoadingZonaLabores(true);
        setLoadingOficios(true);
        setLoadingActividades(true);
        setLoadingAgrupaciones(true);
        setLoadingTiposContratos(true);
        setLoadingTroncales(true);

        function fetchZonasLabores() {
            Axios.get(`${url}/zona-labor/${contrato.empresa_id}`)
                .then(res => {
                    setZonasLabor(res.data.data);
                    setLoadingZonaLabores(false)
                })
                .catch(err => {
                    console.log(err);
                    fetchZonasLabores();
                });
        }
        function fetchOficios() {
            Axios.get(`${url}/oficio/${contrato.empresa_id}`)
                .then(res => {
                    setOficios(res.data.data);
                    setLoadingOficios(false);
                })
                .catch(err => {
                    console.log(err);
                    fetchOficios();
                });
        }
        function fetchActividades() {
            Axios.get(`${url}/actividad/${contrato.empresa_id}`)
                .then(res => {
                    setActividades(res.data.data);
                    setLoadingActividades(false)
                })
                .catch(err => {
                    console.log(err);
                    fetchActividades();
                });
        }
        function fetchAgrupaciones() {
            Axios.get(`${url}/agrupacion/${contrato.empresa_id}`)
                .then(res => {
                    setAgrupaciones(res.data.data);
                    setLoadingAgrupaciones(false)
                })
                .catch(err => {
                    console.log(err);
                    fetchAgrupaciones();
                });
        }
        function fetchTiposContratos() {
            Axios.get(`${url}/tipo-contrato/${contrato.empresa_id}`)
                .then(res => {
                    setTiposContratos(res.data.data);
                    setLoadingTiposContratos(false);
                })
                .catch(err => {
                    console.log(err);
                    fetchTiposContratos();
                });
        }
        function fetchTroncales() {
            Axios.get(`${url}/troncal/${contrato.empresa_id}`)
                .then(res => {
                    setTroncales(res.data.data);
                    setLoadingTroncales(false);
                })
                .catch(err => {
                    console.log(err);
                    fetchTroncales();
                });
        }
        fetchZonasLabores();
        fetchOficios();
        fetchActividades();
        fetchAgrupaciones();
        fetchTiposContratos();
        fetchTroncales();
    }, [contrato.empresa_id]);

    useEffect(() => {
        function fetchRutas() {
            Axios.get(`${url}/ruta/${contrato.empresa_id}/${contrato.troncal_id}`)
                .then(res => {
                    setRutas(res.data.data);
                    setLoadingRutas(false);
                })
                .catch(err => {
                    console.log(err);
                    fetchRutas();
                });
        }
        if (contrato.troncal_id !== '') {
            setLoadingRutas(true);
            fetchRutas();
        }
    }, [contrato.empresa_id, contrato.troncal_id]);

    useEffect(() => {
        function fetchCuarteles() {
            Axios.get(`${url}/cuartel/${contrato.empresa_id}/${contrato.zona_labor_id}`)
                .then(res => {
                    setCuarteles(res.data.data);
                    setLoadingCuarteles(false);
                })
                .catch(err => {
                    console.log(err);
                    fetchCuarteles();
                });
        }
        if (contrato.zona_labor_id !== '') {
            setLoadingCuarteles(true);
            fetchCuarteles();
        }
    }, [contrato.empresa_id, contrato.zona_labor_id]);

    useEffect(() => {
        function fetchActividades() {
            Axios.get(`${url}/labor/${contrato.empresa_id}/${contrato.actividad_id}`)
                .then(res => {
                    setLabores(res.data.data);
                    setLoadingLabores(false);
                })
                .catch(err => {
                    console.log(err);
                    fetchActividades();
                });
        }
        if (contrato.actividad_id !== '') {
            setLoadingLabores(true);
            fetchActividades();
        }
    }, [contrato.empresa_id, contrato.actividad_id]);

    return (
        <Card>
            <Form {...layout}>
                <Row gutter={16}>
                    <Col md={8} sm={24} xs={24}>
                        <Form.Item label="Empresa" initialValue={9} required={true}>
                            <Select
                                name="empresa_id"
                                showSearch
                                placeholder="Empresa"
                                optionFilterProp="children"
                                filterOption={(input, option) =>
                                    option.children
                                        .toLowerCase()
                                        .indexOf(input.toLowerCase()) >= 0
                                }
                                onChange={e =>
                                    setContrato({ ...contrato, empresa_id: e })
                                }
                                value={contrato.empresa_id}
                            >
                                {empresa.map(option => (
                                    <Select.Option
                                        value={option.id}
                                        key={option.id}
                                    >
                                        {option.name}
                                    </Select.Option>
                                ))}
                            </Select>
                        </Form.Item>
                    </Col>
                    <Col md={8} sm={24} xs={24}>
                        <Form.Item label="Zona Labor" required={true}>
                            <Select
                                name="zona_labor_id"
                                showSearch
                                placeholder="Zona Labor"
                                optionFilterProp="children"
                                loading={loadingZonaLabores}
                                filterOption={(input, option) =>
                                    option.children
                                        .toLowerCase()
                                        .indexOf(input.toLowerCase()) >= 0
                                }
                                onChange={e =>
                                    setContrato({ ...contrato, zona_labor_id: e })
                                }
                                value={contrato.zona_labor_id}
                            >
                                {zonasLabor.map(option => (
                                    <Select.Option
                                        value={option.id}
                                        key={option.id}
                                    >
                                        {`${option.id} - ${option.name}`}
                                    </Select.Option>
                                ))}
                            </Select>
                        </Form.Item>
                    </Col>
                    <Col md={8} sm={24} xs={24}>
                        <Form.Item label="Grupo" required={true}>
                            <Input
                                type="number"
                                name="grupo"
                                value={contrato.grupo}
                                onChange={handleChangeInput}
                            />
                        </Form.Item>
                    </Col>
                </Row>
                <Row gutter={16}>
                    <Col md={8} sm={24} xs={24}>
                        <Form.Item label="Regimen" required={true}>
                            <Select
                                name="regimen_id"
                                showSearch
                                placeholder="Regimen"
                                optionFilterProp="children"
                                loading={loadingRegimenes}
                                filterOption={(input, option) =>
                                    option.children
                                        .toLowerCase()
                                        .indexOf(input.toLowerCase()) >= 0
                                }
                                onChange={e =>
                                    setContrato({ ...contrato, regimen_id: e })
                                }
                                value={contrato.regimen_id}
                            >
                                {regimenes.map(option => (
                                    <Select.Option
                                        value={option.id}
                                        key={option.id}
                                    >
                                        {`${option.id} - ${option.name}`}
                                    </Select.Option>
                                ))}
                            </Select>
                        </Form.Item>
                    </Col>
                    <Col md={8} sm={24} xs={24}>
                        <Form.Item label="F. Ingreso" required={true}>
                            <DatePicker
                                placeholder="Fecha Ingreso"
                                value={moment(contrato.fecha_ingreso)}
                                onChange={setChangeFechaIngreso}
                                allowClear={false}
                            />
                        </Form.Item>
                    </Col>
                    <Col md={8} sm={24} xs={24}>
                        <Form.Item label="F. Termino" required={true}>
                            <DatePicker
                                placeholder="Fecha Termino"
                                value={moment(contrato.fecha_termino)}
                                allowClear={false}
                                onChange={(date, dateString) => {
                                    setContrato({
                                        ...contrato,
                                        fecha_termino: dateString,
                                    });
                                }}
                            />
                        </Form.Item>
                    </Col>
                </Row>
                <Row gutter={16}>
                    <Col md={8} sm={24} xs={24}>
                        <Form.Item label="Oficio" required={true}>
                            <Select
                                name="oficio_id"
                                showSearch
                                placeholder="Oficio"
                                optionFilterProp="children"
                                loading={loadingOficios}
                                filterOption={(input, option) =>
                                    option.children
                                        .toLowerCase()
                                        .indexOf(input.toLowerCase()) >= 0
                                }
                                onChange={e =>
                                    setContrato({ ...contrato, oficio_id: e })
                                }
                                value={contrato.oficio_id}
                            >
                                {oficios.map(option => (
                                    <Select.Option
                                        value={option.id}
                                        key={option.id}
                                    >
                                        {`${option.id} - ${option.name}`}
                                    </Select.Option>
                                ))}
                            </Select>
                        </Form.Item>
                    </Col>
                    <Col md={8} sm={24} xs={24}>
                        <Form.Item label="Cuartel" required={true}>
                            <Select
                                name="cuartel_id"
                                showSearch
                                placeholder="Cuartel"
                                optionFilterProp="children"
                                loading={loadingCuarteles}
                                filterOption={(input, option) =>
                                    option.children
                                        .toLowerCase()
                                        .indexOf(input.toLowerCase()) >= 0
                                }
                                onChange={e =>
                                    setContrato({ ...contrato, cuartel_id: e })
                                }
                                value={contrato.cuartel_id}
                            >
                                {cuarteles.map(option => (
                                    <Select.Option
                                        value={option.id}
                                        key={option.id}
                                    >
                                        {`${option.id} - ${option.name}`}
                                    </Select.Option>
                                ))}
                            </Select>
                        </Form.Item>
                    </Col>
                    <Col md={8} sm={24} xs={24}>
                        <Form.Item label="Agrupación" required={true}>
                            <Select
                                name="agrupacion_id"
                                showSearch
                                placeholder="Agrupacion"
                                optionFilterProp="children"
                                loading={loadingAgrupaciones}
                                filterOption={(input, option) =>
                                    option.children
                                        .toLowerCase()
                                        .indexOf(input.toLowerCase()) >= 0
                                }
                                onChange={e =>
                                    setContrato({ ...contrato, agrupacion_id: e })
                                }
                                value={contrato.agrupacion_id}
                            >
                                {agrupaciones.map(option => (
                                    <Select.Option
                                        value={option.id}
                                        key={option.id}
                                    >
                                        {`${option.id} - ${option.name}`}
                                    </Select.Option>
                                ))}
                            </Select>
                        </Form.Item>
                    </Col>
                </Row>
                <Row gutter={16}>
                    <Col md={8} sm={24} xs={24}>
                        <Form.Item label="Actividad" required={true}>
                            <Select
                                name="actividad_id"
                                showSearch
                                placeholder="Actividad"
                                optionFilterProp="children"
                                loading={loadingActividades}
                                filterOption={(input, option) =>
                                    option.children
                                        .toLowerCase()
                                        .indexOf(input.toLowerCase()) >= 0
                                }
                                onChange={e =>
                                    setContrato({ ...contrato, actividad_id: e })
                                }
                                value={contrato.actividad_id}
                            >
                                {actividades.map(option => (
                                    <Select.Option
                                        value={option.id}
                                        key={option.id}
                                    >
                                        {`${option.id} - ${option.name}`}
                                    </Select.Option>
                                ))}
                            </Select>
                        </Form.Item>
                    </Col>
                    <Col md={8} sm={24} xs={24}>
                        <Form.Item label="Labor" required={true}>
                            <Select
                                name="labor_id"
                                showSearch
                                placeholder="Labor"
                                optionFilterProp="children"
                                loading={loadingLabores}
                                filterOption={(input, option) =>
                                    option.children
                                        .toLowerCase()
                                        .indexOf(input.toLowerCase()) >= 0
                                }
                                onChange={e =>
                                    setContrato({ ...contrato, labor_id: e })
                                }
                                value={contrato.labor_id}
                            >
                                {labores.map(option => (
                                    <Select.Option
                                        value={option.id}
                                        key={option.id}
                                    >
                                        {`${option.id} - ${option.name}`}
                                    </Select.Option>
                                ))}
                            </Select>
                        </Form.Item>
                    </Col>
                    <Col md={8} sm={24} xs={24}>
                        <Form.Item label="Tipo Contrato" required={true}>
                            <Select
                                name="tipo_contrato_id"
                                showSearch
                                placeholder="Tipo Contrato"
                                optionFilterProp="children"
                                loading={loadingTiposContratos}
                                filterOption={(input, option) =>
                                    option.children
                                        .toLowerCase()
                                        .indexOf(input.toLowerCase()) >= 0
                                }
                                onChange={e =>
                                    setContrato({ ...contrato, tipo_contrato_id: e })
                                }
                                value={contrato.tipo_contrato_id}
                            >
                                {tiposContratos.map(option => (
                                    <Select.Option
                                        value={option.id}
                                        key={option.id}
                                    >
                                        {`${option.id} - ${option.name}`}
                                    </Select.Option>
                                ))}
                            </Select>
                        </Form.Item>
                    </Col>
                </Row>
                <Row gutter={16}>
                    <Col md={8} sm={24} xs={24}>
                        <Form.Item label="Tipo" required={true}>
                            <Select
                                name="tipo_trabajador"
                                showSearch
                                placeholder="Tipo Trabajador"
                                optionFilterProp="children"
                                filterOption={(input, option) =>
                                    option.children
                                        .toLowerCase()
                                        .indexOf(input.toLowerCase()) >= 0
                                }
                                onChange={e =>
                                    setContrato({ ...contrato, tipo_trabajador: e })
                                }
                                value={contrato.tipo_trabajador}
                            >
                                {tipos_trabajadores.map(option => (
                                    <Select.Option
                                        value={option.id}
                                        key={option.id}
                                    >
                                        {option.name}
                                    </Select.Option>
                                ))}
                            </Select>
                        </Form.Item>
                    </Col>
                    <Col md={8} sm={24} xs={24}>
                        <Form.Item label="Troncal" required={true}>
                            <Select
                                name="troncal_id"
                                showSearch
                                placeholder="Troncal"
                                optionFilterProp="children"
                                loading={loadingTroncales}
                                filterOption={(input, option) =>
                                    option.children
                                        .toLowerCase()
                                        .indexOf(input.toLowerCase()) >= 0
                                }
                                onChange={e =>
                                    setContrato({ ...contrato, troncal_id: e })
                                }
                                value={contrato.troncal_id}
                            >
                                {troncales.map(option => (
                                    <Select.Option
                                        value={option.id}
                                        key={option.id}
                                    >
                                        {`${option.id} - ${option.name}`}
                                    </Select.Option>
                                ))}
                            </Select>
                        </Form.Item>
                    </Col>
                    <Col md={8} sm={24} xs={24}>
                        <Form.Item label="Ruta" required={true}>
                            <Select
                                name="ruta_id"
                                showSearch
                                placeholder="Ruta"
                                optionFilterProp="children"
                                loading={loadingRutas}
                                filterOption={(input, option) =>
                                    option.children
                                        .toLowerCase()
                                        .indexOf(input.toLowerCase()) >= 0
                                }
                                onChange={e =>
                                    setContrato({ ...contrato, ruta_id: e })
                                }
                                value={contrato.ruta_id}
                            >
                                {rutas.map(option => (
                                    <Select.Option
                                        value={option.id}
                                        key={option.id}
                                    >
                                        {`${option.id} - ${option.name}`}
                                    </Select.Option>
                                ))}
                            </Select>
                        </Form.Item>
                    </Col>
                </Row>
                <Row gutter={16}>
                    <Col md={8} sm={24} xs={24}>
                        <Form.Item label="Código Bus">
                            <Input
                                name="codigo_bus"
                                value={contrato.codigo_bus}
                                onChange={handleChangeInput}
                            />
                        </Form.Item>
                    </Col>
                </Row>
            </Form>
        </Card>
    );
};

export default DatosContrato;
