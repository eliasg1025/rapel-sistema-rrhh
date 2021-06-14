import React, { useState, useEffect } from 'react';
import { Spin, Button, Input, Form, Card, notification } from 'antd';
import { SearchOutlined } from '@ant-design/icons';
import moment from 'moment';
import Axios from 'axios';

const BusquedaTrabajador = props => {
    const {
        trabajador, setTrabajador, loading, setLoading, setAlertas, setContratoActivo, clearFormTrabajador,
        mostrarObservaciones
    } = props;
    const [validForm, setValidForm] = useState(false);

    useEffect(() => {
        if (trabajador.rut.length === 8) {
            setValidForm(true);
        }
    }, [trabajador.rut]);

    const handleSubmit = async () => {
        setLoading(true);
        Axios.get(`http://192.168.60.16/api/trabajador/${trabajador.rut}`)
            .then(res => {
                console.log(res);
                if (res.status === 200) {
                    notification['success']({
                        message: res.data.message,
                    });
                    formatBeforeInsert(res.data.data.trabajador);
                    setAlertas(res.data.data.alertas);
                    setContratoActivo(res.data.data.contrato_activo);

                    mostrarObservaciones(res.data.data);
                } else {
                    notification['warning']({
                        message: res.data.message,
                    });
                    clearFormTrabajador();
                }
            })
            .catch(err => {
                console.log(err.response);

                notification['error']({
                    message:
                        'Trabajador no encontrado',
                });
                clearFormTrabajador();
            })
            .finally(() => {
                setLoading(false);
            });
    };

    const formatBeforeInsert = _trabajador => {
        let provincia_id = _trabajador.distrito_id.substring(0, 4);
        let departamento_id = _trabajador.distrito_id.substring(0, 2);
        setTrabajador({
            ...trabajador,
            rut: _trabajador.rut,
            distrito_id: _trabajador.distrito_id,
            provincia_id,
            departamento_id,
            nombre: _trabajador.nombre,
            apellido_paterno:  _trabajador.apellido_paterno,
            apellido_materno:  _trabajador.apellido_materno,
            direccion: _trabajador.direccion,
            telefono: _trabajador.telefono,
            fecha_nacimiento: moment(_trabajador.fecha_nacimiento).format('YYYY-MM-DD').toString(),
            nombre_zona: _trabajador.nombre_zona,
            nombre_via: _trabajador.nombre_via,
            sexo: _trabajador.sexo,
            nacionalidad_id: _trabajador.nacionalidad_id,
            tipo_via_id: _trabajador.tipo_via_id,
            tipo_zona_id: _trabajador.tipo_zona_id,
            estado_civil_id: _trabajador.estado_civil_id
        });
    };

    return (
        <Card>
            <Form layout="inline" onSubmitCapture={handleSubmit}>
                <Form.Item
                    name="dni"
                    rules={[{ required: true, message: 'Dato obligatorio' }]}
                    initialValue={trabajador.rut}
                >
                    <Input
                        autoComplete="off"
                        value={trabajador.rut}
                        placeholder="Numero DNI"
                        size="small"
                        onChange={e => {
                            setTrabajador({
                                ...trabajador,
                                rut: e.target.value,
                            });
                        }}
                    />
                </Form.Item>
                <Form.Item>
                    {loading ? (
                        <Spin />
                    ) : (
                        <Button
                            type="primary"
                            size="small"
                            htmlType="submit"
                            disabled={!validForm}
                        >
                            Buscar
                        </Button>
                    )}
                </Form.Item>
            </Form>
        </Card>
    );
};

export default BusquedaTrabajador;
