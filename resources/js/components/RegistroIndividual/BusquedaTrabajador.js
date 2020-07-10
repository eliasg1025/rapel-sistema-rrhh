import React, { useState, useEffect } from 'react';
import { Spin, Button, Input, Form, Card, notification } from 'antd';
import { SearchOutlined } from '@ant-design/icons';
import moment from 'moment';

const BusquedaTrabajador = props => {
    const { trabajador, setTrabajador, loading, setLoading, setAlertas, setContratoActivo, clearFormTrabajador } = props;
    const [validForm, setValidForm] = useState(false);

    useEffect(() => {
        if (trabajador.rut.length === 8) {
            setValidForm(true);
        }
    }, [trabajador.rut]);

    const handleSubmit = async () => {
        setLoading(true);
        axios.get(`http://192.168.60.16/api/trabajador/${trabajador.rut}`)
            .then(res => {
                console.log(res);
                if (res.status === 200) {
                    notification['success']({
                        message: res.data.message,
                    });
                    formatBeforeInsert(res.data.data.trabajador);
                    setAlertas(res.data.data.alertas);
                    setContratoActivo(res.data.data.contrato_activo);
                } else {
                    notification['warning']({
                        message: res.data.message,
                    });
                    clearFormTrabajador();
                }
            })
            .catch(err => {
                console.log(err);

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
        setTrabajador({
            ...trabajador,
            rut: _trabajador.rut,
            distrito_id: _trabajador.distrito_id,
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
                    label="DNI"
                    rules={[{ required: true, message: 'Dato obligatorio' }]}
                    initialValue={trabajador.rut}
                >
                    <Input
                        autoComplete="off"
                        value={trabajador.rut}
                        placeholder="Numero DNI"
                        onChange={e => {
                            setTrabajador({
                                ...trabajador,
                                rut: e.target.value,
                            });
                        }}
                    ></Input>
                </Form.Item>
                <Form.Item>
                    {loading ? (
                        <Spin />
                    ) : (
                        <Button
                            type="primary"
                            htmlType="submit"
                            disabled={!validForm}
                        >
                            <SearchOutlined />
                        </Button>
                    )}
                </Form.Item>
            </Form>
        </Card>
    );
};

export default BusquedaTrabajador;
