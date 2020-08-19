import React, { useEffect, useState } from 'react';
import { Card, Form, Row, Col, Input, Select, DatePicker, notification } from 'antd'
import moment from 'moment';

import { sexo, estado_civil } from '../../data/default.json';

const DatosTrabajador = props => {
    const {
        setDatosTrabajadorValido,
        trabajador, setTrabajador, departamentos, provincias,  distritos, nacionalidades, tiposZonas, tiposVias,
        setDepartamentos, setProvincias, setDistritos, setNacionalidades, setTiposVias, setTiposZonas, contrato
    } = props;
    const { Item } = Form;

    const [edad, setEdad] = useState(0);
    const [validacionEdad, setValidacionEdad] = useState({
        validateStatus: "error",
        help: "La edad debe estar en 18 y 55 años"
    });

    useEffect(() => {
        const edad = moment().diff(moment(trabajador.fecha_nacimiento, 'DD/MM/YYYY'), 'years');
        setEdad(edad);

        if (edad <= 18 || edad >= 55) {
            setValidacionEdad({
                validateStatus: "error",
                help: "La edad debe estar en 18 y 55 años"
            });
            return;
        }

        setValidacionEdad({
            validateStatus: "success",
            help: ""
        });
    }, [trabajador.fecha_nacimiento]);

    const validacionDatosTrabajador = () => {
        return trabajador.apellido_materno !== '' &&
            trabajador.apellido_paterno !== '' &&
            trabajador.nombre !== '' &&
            trabajador.estado_civil_id !== '' &&
            trabajador.sexo !== '' &&
            trabajador.nacionalidad_id !== '' &&
            trabajador.distrito_id !== '' &&
            trabajador.direccion !== ''
    };

    useEffect(() => {
        if (validacionDatosTrabajador()) {
            setDatosTrabajadorValido(true);
            return;
        }
        setDatosTrabajadorValido(false);
    }, [trabajador]);

    /**
     * Fetching data
     */
    const url = 'http://192.168.60.16/api';

    useEffect(() => {
        let intentos = 0;
        function fetchDepartamentos() {
            intentos++;
            axios.get(`${url}/departamento`)
                .then(res => {
                    setDepartamentos(res.data.data);
                })
                .catch(err => {
                    console.log(err.response);
                    if (intentos < 3) {
                        fetchDepartamentos();
                    } else {
                        notification['warning']({
                            message: 'Error al obtener los departamentos, vuelva a cargar la página',
                        });
                    }
                });
        }
        fetchDepartamentos();
    }, []);

    useEffect(() => {
        let intentos = 0;
        function fetchProvincias() {
            intentos++;
            axios.get(`${url}/departamento/${trabajador.departamento_id}/provincias`)
                .then(res => {
                    //console.log(res);
                    setProvincias(res.data.data.provincias);
                })
                .catch(err => {
                    console.log(err.response);
                    if (intentos < 3) {
                        fetchProvincias();
                    } else {
                        notification['warning']({
                            message: 'Error al obtener las provincias, vuelva a cargar la página',
                        });
                    }
                });
        }
        if (trabajador.departamento_id !== '') {
            fetchProvincias();
        }
    }, [trabajador.departamento_id]);

    useEffect(() => {
        let intentos = 0;
        function fetchDistritos() {
            axios.get(`${url}/provincia/${trabajador.provincia_id}/distritos`)
                .then(res => {
                    //console.log(res);
                    setDistritos(res.data.data.distritos);
                })
                .catch(err => {
                    console.log(err.response);
                    if ( intentos < 3 ) {
                        fetchDistritos();
                    } else {
                        notification['warning']({
                            message: 'Error al obtener las distritos, vuelva a cargar la página',
                        });
                    }
                });
        }
        if (trabajador.provincia_id !== '') {
            fetchDistritos();
        }
    }, [trabajador.provincia_id]);

    useEffect(() => {
        let intentos = 0;
        let intentos1 = 0;
        let intentos2 = 0;

        function fetchNacionalidades() {
            intentos++;
            axios.get(`${url}/nacionalidad/${contrato.empresa_id}`)
                .then(res => setNacionalidades(res.data.data))
                .catch(err => {
                    console.log(err.response);
                    if (intentos < 3) {
                        fetchNacionalidades();
                    } else {
                        notification['warning']({
                            message: 'Error al obtener las nacionalidades, vuelva a cargar la página',
                        });
                    }
                });
        }
        function fetchTiposZonas() {
            intentos1++;
            axios.get(`${url}/tipo-zona/${contrato.empresa_id}`)
                .then(res => setTiposZonas(res.data.data))
                .catch(err => {
                    console.log(err.response);
                    if (intentos1 < 3) {
                        fetchTiposZonas();
                    } else {
                        notification['warning']({
                            message: 'Error al obtener las tipos zonas, vuelva a cargar la página',
                        });
                    }
                });
        }
        function fetchTiposVias() {
            intentos2++;
            axios.get(`${url}/tipo-via/${contrato.empresa_id}`)
                .then(res => setTiposVias(res.data.data))
                .catch(err => {
                    console.log(err.response);
                    if (intentos2 < 3) {
                        fetchTiposVias();
                    } else {
                        notification['warning']({
                            message: 'Error al obtener las tipos vias, vuelva a cargar la página',
                        });
                    }
                });
        }

        fetchNacionalidades();
        fetchTiposZonas();
        fetchTiposVias();

    }, [contrato.empresa_id]);

    /**
     * Functions
     */

    const handleChangeInput = e => {
        setTrabajador({
            ...trabajador,
            [e.target.name]: e.target.value
        });
    };

    const handleChangeDepartamento = e => {
        setTrabajador({
            ...trabajador,
            departamento_id: e,
            provincia_id: '',
            distrito_id: ''
        });
    };

    const handleChangeProvincia = e => {
        setTrabajador({
            ...trabajador,
            provincia_id: e
        });
    };

    const handleChangeDistrito = e => {
        setTrabajador({
            ...trabajador,
            distrito_id: e
        });
        console.log(e);
    };

    const layout = {
        labelCol: {
            span: 6
        }
    };

    return (
        <Card>
            <Form {...layout} className="data-form">
                <Row gutter={16}>
                    <Col md={8} sm={24} xs={24}>
                        <Item label="A. Paterno" required={true}>
                            <Input
                                autoComplete="off"
                                name="apellido_paterno"
                                value={trabajador.apellido_paterno}
                                onChange={e => setTrabajador({ ...trabajador, apellido_paterno: e.target.value })}
                            />
                        </Item>
                    </Col>
                    <Col md={8} sm={24} xs={24}>
                        <Item label="A. Materno" required={true}>
                            <Input
                                autoComplete="off"
                                name="apellido_materno"
                                value={trabajador.apellido_materno}
                                onChange={e => setTrabajador({ ...trabajador, apellido_materno: e.target.value })}
                            />
                        </Item>
                    </Col>
                    <Col md={8} sm={24} xs={24}>
                        <Item label="Nombre" required={true}>
                            <Input
                                autoComplete="off"
                                name="nombre"
                                value={trabajador.nombre}
                                onChange={e => setTrabajador({ ...trabajador, nombre: e.target.value })}
                            />
                        </Item>
                    </Col>
                </Row>

                <Row gutter={16}>
                    <Col md={8} sm={24} xs={24}>
                        <Item
                            label="F. Nacimiento"
                            validateStatus={validacionEdad.validateStatus}
                            help={validacionEdad.help}
                        >
                            <DatePicker
                                name="fecha_nacimiento"
                                value={trabajador.fecha_nacimiento && moment(
                                    trabajador.fecha_nacimiento,
                                    'DD/MM/YYYY'
                                )}
                                format={['DD/MM/YYYY']}
                                allowClear={false}
                                onChange={(date, dateString) => setTrabajador({ ...trabajador, fecha_nacimiento: date })}
                            />
                            <small>
                                {trabajador.fecha_nacimiento !== ''
                                    ? `  ${edad} años`
                                    : ''}
                            </small>
                        </Item>
                    </Col>
                    <Col md={8} sm={24} xs={24}>
                        <Item label="Sexo" required={true}>
                            <Select
                                name="sexo"
                                placeholder="Sexo"
                                onChange={e => {
                                    setTrabajador({ ...trabajador, sexo: e });
                                }}
                                value={trabajador.sexo}
                                required={true}
                            >
                                {sexo.map(option => (
                                    <Select.Option
                                        key={option.id}
                                        value={option.id}
                                    >
                                        {option.name}
                                    </Select.Option>
                                ))}
                            </Select>
                        </Item>
                    </Col>
                    <Col md={8} sm={24} xs={24}>
                        <Item label="E. Civil" required={true}>
                            <Select
                                name="estado_civil_id"
                                placeholder="Estado Civil"
                                onChange={e => {
                                    setTrabajador({ ...trabajador, estado_civil_id: e });
                                }}
                                value={trabajador.estado_civil_id}

                            >
                                {estado_civil.map(option => (
                                    <Select.Option
                                        key={option.id}
                                        value={option.id}
                                    >
                                        {option.name}
                                    </Select.Option>
                                ))}
                            </Select>
                        </Item>
                    </Col>
                </Row>
                <Row gutter={16}>
                    <Col md={8} sm={24} xs={24}>
                        <Item label="Nacionalidad" required={true}>
                            <Select
                                name="nacionalidad_id"
                                showSearch
                                placeholder="Nacionalidad"
                                optionFilterProp="children"
                                filterOption={(input, option) =>
                                    option.children
                                        .toLowerCase()
                                        .indexOf(input.toLowerCase()) >= 0
                                }
                                onChange={e => {
                                    setTrabajador({ ...trabajador, nacionalidad_id: e });
                                }}
                                value={trabajador.nacionalidad_id}

                            >
                                {nacionalidades.map(option => (
                                    <Select.Option
                                        value={option.id}
                                        key={option.id}
                                    >
                                        {`${option.id} - ${option.name}`}
                                    </Select.Option>
                                ))}
                            </Select>
                        </Item>
                    </Col>
                    <Col md={8} sm={24} xs={24}>
                        <Item label="Telefono">
                            <Input
                                autoComplete="off"
                                name="telefono"
                                value={trabajador.telefono}
                                onChange={handleChangeInput}
                            />
                        </Item>
                    </Col>
                    <Col md={8} sm={24} xs={24}>
                        <Item label="Email">
                            <Input
                                autoComplete="off"
                                name="email"
                                value={trabajador.email}
                                onChange={handleChangeInput}
                            />
                        </Item>
                    </Col>
                </Row>
                <Row gutter={16}>
                    <Col md={8} sm={24} xs={24}>
                        <Item label="Departamento" required={true}>
                            <Select
                                name="departamento_id"
                                showSearch
                                placeholder="Departamento"
                                optionFilterProp="children"
                                filterOption={(input, option) =>
                                    option.children
                                        .toLowerCase()
                                        .indexOf(input.toLowerCase()) >= 0
                                }
                                onChange={handleChangeDepartamento}
                                value={trabajador.departamento_id}

                            >
                                {departamentos.map(option => (
                                    <Select.Option
                                        value={option.id}
                                        key={option.id}
                                    >
                                        {`${option.id} - ${option.name}`}
                                    </Select.Option>
                                ))}
                            </Select>
                        </Item>
                    </Col>
                    <Col md={8} sm={24} xs={24}>
                        <Item label="Provincia" required={true}>
                            <Select
                                name="provincia_id"
                                showSearch
                                placeholder="Provincia"
                                optionFilterProp="children"
                                filterOption={(input, option) =>
                                    option.children
                                        .toLowerCase()
                                        .indexOf(input.toLowerCase()) >= 0
                                }
                                onChange={handleChangeProvincia}
                                value={trabajador.provincia_id}

                            >
                                {provincias.map(option => (
                                    <Select.Option
                                        value={option.id}
                                        key={option.id}
                                    >
                                        {`${option.id} - ${option.name}`}
                                    </Select.Option>
                                ))}
                            </Select>
                        </Item>
                    </Col>
                    <Col md={8} sm={24} xs={24}>
                        <Item label="Distrito" required={true}>
                            <Select
                                name="distrito_id"
                                showSearch
                                placeholder="Distrito"
                                optionFilterProp="children"
                                filterOption={(input, option) =>
                                    option.children
                                        .toLowerCase()
                                        .indexOf(input.toLowerCase()) >= 0
                                }
                                onChange={handleChangeDistrito}
                                value={trabajador.distrito_id}

                            >
                                {distritos.map(option => (
                                    <Select.Option
                                        value={option.id}
                                        key={option.id}
                                    >
                                        {`${option.id} - ${option.name}`}
                                    </Select.Option>
                                ))}
                            </Select>
                        </Item>
                    </Col>
                </Row>
                <Row gutter={16}>
                    <Col md={8} sm={24} xs={24}>
                        <Item label="Zona">
                            <Select
                                name="tipo_zonas_id"
                                showSearch
                                placeholder="Tipo Zona"
                                optionFilterProp="children"
                                filterOption={(input, option) =>
                                    option.children
                                        .toLowerCase()
                                        .indexOf(input.toLowerCase()) >= 0
                                }
                                onChange={e =>
                                    setTrabajador({ ...trabajador, tipo_zona_id: e })
                                }
                                value={trabajador.tipo_zona_id}
                            >
                                {tiposZonas.map(option => (
                                    <Select.Option
                                        value={option.id}
                                        key={option.id}
                                    >
                                        {`${option.id} - ${option.name}`}
                                    </Select.Option>
                                ))}
                            </Select>
                        </Item>
                    </Col>
                    <Col md={8} sm={24} xs={24}>
                        <Item label="Nombre">
                            <Input
                                autoComplete="off"
                                name="nombre_zona"
                                value={trabajador.nombre_zona}
                                onChange={handleChangeInput}
                            />
                        </Item>
                    </Col>
                </Row>
                <Row gutter={16}>
                    <Col md={8} sm={24} xs={24}>
                        <Item label="Via">
                            <Select
                                name="tipo_via_id"
                                showSearch
                                placeholder="Tipo Via"
                                optionFilterProp="children"
                                filterOption={(input, option) =>
                                    option.children
                                        .toLowerCase()
                                        .indexOf(input.toLowerCase()) >= 0
                                }
                                onChange={e =>
                                    setTrabajador({ ...trabajador, tipo_via_id: e })
                                }
                                value={trabajador.tipo_via_id}
                            >
                                {tiposVias.map(option => (
                                    <Select.Option
                                        value={option.id}
                                        key={option.id}
                                    >
                                        {`${option.id} - ${option.name}`}
                                    </Select.Option>
                                ))}
                            </Select>
                        </Item>
                    </Col>
                    <Col md={8} sm={24} xs={24}>
                        <Item label="Nombre">
                            <Input
                                autoComplete="off"
                                name="nombre_via"
                                value={trabajador.nombre_via}
                                onChange={handleChangeInput}
                            />
                        </Item>
                    </Col>
                </Row>
                <Row>
                    <Col md={2} sm={24} xs={24}>
                        <Item required={true}>
                            Dirección:
                        </Item>
                    </Col>
                    <Col md={14} sm={24} xs={24}>
                        <Item>
                            <Input
                                autoComplete="off"
                                name="direccion"
                                value={trabajador.direccion}
                                onChange={e => setTrabajador({ ...trabajador, direccion: e.target.value })}
                            />
                        </Item>
                    </Col>
                </Row>
            </Form>
        </Card>
    );
};

export default DatosTrabajador;
