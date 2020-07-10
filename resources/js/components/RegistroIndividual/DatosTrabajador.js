import React, { useEffect } from 'react';
import { Card, Form, Row, Col, Input, Select, DatePicker, notification } from 'antd'
import moment from 'moment';

import { sexo, estado_civil } from '../../data/default.json';

const DatosTrabajador = props => {
    const {
        trabajador, setTrabajador, departamentos, provincias,  distritos, nacionalidades, tiposZonas, tiposVias,
        setDepartamentos, setProvincias, setDistritos, setNacionalidades, setTiposVias, setTiposZonas, contrato
    } = props;
    const { Item } = Form;

    /**
     * Fetching data
     */
    const url = 'http://192.168.60.16/api';

    useEffect(() => {
        axios.get(`${url}/departamento`)
            .then(res => {
                setDepartamentos(res.data.data);
            })
            .catch(err => {
                console.log(err);
                notification['warning']({
                    message: 'Error al obtener los departamentos, vuelva a cargar la página',
                });
            });

        axios.get
    }, []);

    useEffect(() => {
        if (trabajador.departamento_id !== '') {
            axios.get(`${url}/departamento/${trabajador.departamento_id}/provincias`)
                .then(res => {
                    //console.log(res);
                    setProvincias(res.data.data.provincias);
                })
                .catch(err => {
                    console.log(err);
                    notification['warning']({
                        message: 'Error al obtener las provincias, vuelva a cargar la página',
                    });
                });
        }
    }, [trabajador.departamento_id]);

    useEffect(() => {
        if (trabajador.provincia_id !== '') {
            axios.get(`${url}/provincia/${trabajador.provincia_id}/distritos`)
                .then(res => {
                    //console.log(res);
                    setDistritos(res.data.data.distritos);
                })
                .catch(err => {
                    console.log(err);
                    notification['warning']({
                        message: 'Error al obtener las distritos, vuelva a cargar la página',
                    });
                });
        }
    }, [trabajador.provincia_id]);

    useEffect(() => {
        axios.get(`${url}/nacionalidad/${contrato.empresa_id}`)
            .then(res => setNacionalidades(res.data.data))
            .catch(err => {
                console.log(err);
                notification['warning']({
                    message: 'Error al obtener las provincias, vuelva a cargar la página',
                });
            });

        axios.get(`${url}/tipo-zona/${contrato.empresa_id}`)
            .then(res => setTiposZonas(res.data.data))
            .catch(err => {
                console.log(err);
                notification['warning']({
                    message: 'Error al obtener las provincias, vuelva a cargar la página',
                });
            });

        axios.get(`${url}/tipo-via/${contrato.empresa_id}`)
            .then(res => setTiposVias(res.data.data))
            .catch(err => {
                console.log(err);
                notification['warning']({
                    message: 'Error al obtener las provincias, vuelva a cargar la página',
                });
            });
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

    const handleChangeDate = (date, dateString) => {
        console.log(date, dateString);
        setTrabajador({
            ...trabajador,
            fecha_nacimiento: date
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
                    <Col span={8}>
                        <Item label="A. Paterno">
                            <Input
                                autoComplete="off"
                                name="apellido_paterno"
                                value={trabajador.apellido_paterno}
                                onChange={handleChangeInput}
                            />
                        </Item>
                    </Col>
                    <Col span={8}>
                        <Item label="A. Materno">
                            <Input
                                autoComplete="off"
                                name="apellido_materno"
                                value={trabajador.apellido_materno}
                                onChange={handleChangeInput}
                            />
                        </Item>
                    </Col>
                    <Col span={8}>
                        <Item label="Nombre">
                            <Input
                                autoComplete="off"
                                name="nombre"
                                value={trabajador.nombre}
                                onChange={handleChangeInput}
                            />
                        </Item>
                    </Col>
                </Row>

                <Row gutter={16}>
                    <Col span={8}>
                        <Item label="F. Nacimiento">
                            <DatePicker
                                name="fecha_nacimiento"
                                value={moment(
                                    trabajador.fecha_nacimiento,
                                    'YYYY-MM-DD'
                                )}
                                onChange={handleChangeDate}
                            />
                            <small>
                                {trabajador.fecha_nacimiento !== ''
                                    ? `  ${moment().diff(
                                        trabajador.fecha_nacimiento,
                                        'years'
                                    )} años`
                                    : ''}
                            </small>
                        </Item>
                    </Col>
                    <Col span={8}>
                        <Item label="Sexo">
                            <Select
                                name="sexo"
                                placeholder="Sexo"
                                onChange={e => {
                                    setTrabajador({ ...trabajador, sexo: e });
                                }}
                                value={trabajador.sexo}
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
                    <Col span={8}>
                        <Item label="E. Civil">
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
                    <Col span={8}>
                        <Item label="Nacionalidad">
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
                    <Col span={8}>
                        <Item label="Telefono">
                            <Input
                                autoComplete="off"
                                name="telefono"
                                value={trabajador.telefono}
                                onChange={handleChangeInput}
                            />
                        </Item>
                    </Col>
                    <Col span={8}>
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
                    <Col span={8}>
                        <Item label="Departamento">
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
                    <Col span={8}>
                        <Item label="Provincia">
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
                    <Col span={8}>
                        <Item label="Distrito">
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
                    <Col span={8}>
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
                    <Col span={8}>
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
                    <Col span={8}>
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
                    <Col span={8}>
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
                    <Col span={8}>
                        <Item label="Direccion">
                            <Input
                                autoComplete="off"
                                name="direccion"
                                value={trabajador.direccion}
                                onChange={handleChangeInput}
                            />
                        </Item>
                    </Col>
                </Row>
            </Form>
        </Card>
    );
};

export default DatosTrabajador;
