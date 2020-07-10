import React, { useState, useEffect } from 'react';
import {
    Card,
    Form,
    DatePicker,
    Input,
    Row,
    Col,
    Button,
    Select,
    notification,
} from 'antd';
import moment from 'moment';

import { empresa } from '../../data/default.json';

const FilterForm = props => {
    const initialState = props.filtro;

    useEffect(() => {
        const abortController = new AbortController();
        const signal = abortController.signal;
        props.setFiltro({ ...props.filtro, signal });
        getTrabajadores();

        return function cleanup() {
            abortController.abort();
        }
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [props.reload]);

    const buildTrabajadorDataSource = trabajadores => {
        const result = [];

        for (let i = 0; i < trabajadores.length; i++) {
            const trabajador = trabajadores[i];

            result.push({
                key: i,
                dni: trabajador.rut,
                contrato_id: trabajador.contrato_id,
                nombre: trabajador.nombre,
                apellidos: `${trabajador.apellido_paterno} ${trabajador.apellido_materno}`,
                zona_labor: trabajador.zona_labor_name,
                empresa: trabajador.empresa_id == 9 ? 'RAPEL' : 'VERFRUT',
                empresa_id: trabajador.empresa_id,
                grupo: trabajador.grupo,
                fecha_ingreso: moment(trabajador.fecha_inicio).format(
                    'DD/MM/YYYY'
                ),
            });
        }
        return result;
    };

    const getTrabajadores = () => {
        axios.put('/api/trabajador', {...props.filtro})
            .then(res => {
                console.log(res);
                if (res.status < 400) {
                    notification['success']({
                        message: res.data.message,
                    });
                    const data = buildTrabajadorDataSource(res.data.data);
                    props.setTrabajadores(data);
                } else {
                    notification['error']({
                        message: res.data,
                    });
                    console.error(res);
                }
            })
            .catch(err => {
                console.log(err);
                notification['error']({
                    message: 'Error del servidor',
                });
            });
    };

    const handleSubmit = e => {
        console.log('Filtros enviados: ', props.filtro);
        e.preventDefault();
        getTrabajadores();
    };

    const handleChange = e => {
        const { name, value } = e.target;
        props.setFiltro({
            ...props.filtro,
            [name]: value,
        });
    };

    return (
        <Card>
            <Form onSubmitCapture={handleSubmit}>
                <Row gutter={24}>
                    <Col>
                        <Form.Item
                            name="rango_fechas"
                            initialValue={[
                                moment(props.filtro.desde),
                                moment(props.filtro.hasta),
                            ]}
                        >
                            <DatePicker.RangePicker
                                placeholder={['Desde', 'Hasta']}
                                onChange={(date, dateString) => {
                                    props.setFiltro({
                                        ...props.filtro,
                                        desde: dateString[0],
                                        hasta: dateString[1],
                                    });
                                }}
                                value={[props.filtro.desde, props.filtro.hasta]}
                            />
                        </Form.Item>
                    </Col>
                    <Col>
                        <Form.Item name="empresa" initialValue={9}>
                            <Select
                                showSearch
                                placeholder="Empresa"
                                optionFilterProp="children"
                                filterOption={(input, option) =>
                                    option.children
                                        .toLowerCase()
                                        .indexOf(input.toLowerCase()) >= 0
                                }
                                value={props.filtro.empresa_id}
                                onChange={e => {
                                    props.setFiltro({
                                        ...props.filtro,
                                        empresa_id: e,
                                    });
                                }}
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
                    <Col>
                        <Form.Item>
                            <Input
                                type="number"
                                name="grupo"
                                placeholder="Grupo"
                                onChange={handleChange}
                            />
                        </Form.Item>
                    </Col>
                    <Col>
                        <Form.Item>
                            <Input
                                name="dni"
                                placeholder="DNI"
                                onChange={handleChange}
                            />
                        </Form.Item>
                    </Col>
                    <Col>
                        <Form.Item>
                            <Input
                                name="nombre"
                                placeholder="Nombre"
                                onChange={handleChange}
                            />
                        </Form.Item>
                    </Col>
                </Row>

                <Row>
                    <Col span={24} style={{ textAlign: 'left' }}>
                        <Button type="primary" htmlType="submit">
                            Buscar
                        </Button>
                        <Button
                            style={{ margin: '0 8px' }}
                            onClick={() => props.setFiltro(initialState)}
                        >
                            Borrar filtros
                        </Button>
                    </Col>
                </Row>
            </Form>
        </Card>
    );
}

export default FilterForm;
