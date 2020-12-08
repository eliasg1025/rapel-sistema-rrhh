import React, { useEffect, useState } from 'react';
import Axios from 'axios';
import { Card, Select, Button, notification, Spin, Modal } from 'antd';
import { ExclamationCircleOutlined } from '@ant-design/icons';

import { empresa as empresas } from '../../../data/default.json';

export const Home = () => {

    const [oneline, setOneline] = useState(false);

    useEffect(() => {
        setTimeout(() => {
            setOneline(true);
        }, 1000);
    }, []);

    return (
        <>
            <h4>Panel de Control - Aplicación RRHH</h4>
            <br />
            <h5>Servidor:</h5>
            <Card>
                Dirección IP: <b>209.151.144.74</b><br />
                Estado: {oneline ? (
                    <span>{" "}<i className="fas fa-check" style={{ color: 'green' }}></i> En línea</span>
                ) : (
                    <span>{" "}<i className="fas fa-times-circle" style={{ color: 'red' }}></i> Fuera de línea</span>
                )}
            </Card>
            <br />
            <SincronizacionEntregaCanastas />
        </>
    );
}

const SincronizacionEntregaCanastas = () => {

    const [loading, setLoading] = useState(false);
    const [form, setForm] = useState({
        empresaId: ''
    });

    const handleSincronizar = () => {
        console.log(form);

        recoverData();
    }

    const recoverData = async () => {
        setLoading(true);
        try {
            const { data } = await Axios.get(`http://192.168.60.16/api/trabajadores/${form.empresaId}/activos`);

            confirm(data, () => insertData(data));

        } catch (err) {
            console.log(err);
            notification['error']({
                message: 'Error inesperado, inténtelo más tarde'
            });
        } finally {
            setLoading(false);
        }
    }

    const confirm = (data, action) => {
        Modal.confirm({
            title: 'Cargar Datos',
            icon: <ExclamationCircleOutlined />,
            content: `Se recuperaron ${data.length} registros. ¿Desea cargarlos todos?`,
            okText: 'Si, CARGAR',
            cancelText: 'Cancelar',
            onOk: action
        });
    }

    const insertData = (data) => {
        setLoading(true);
        Axios.post(`http://209.151.144.74/api/employees/many`,{
            data
        })
            .then(res => {
                console.log(res.data);
                notification['success']({
                    message: res.data.message
                })
            })
            .catch(err => {
                console.log(err);
            })
            .finally(() => setLoading(false));
    }

    return (
        <>
            <Spin spinning={loading}>
                <h5>Sincronizar trabajadores activos</h5>
                <Card>
                    <div className="row">
                        <div className="col-md-4">
                            Empresa:<br />
                            <Select
                                value={form.empresaId} showSearch
                                style={{ width: '100%' }} optionFilterProp="children"
                                filterOption={(input, option) =>
                                    option.children
                                        .toLowerCase()
                                        .indexOf(input.toLowerCase()) >= 0
                                }
                                onChange={e => setForm({ ...form, empresaId: e })}
                                size="small"
                            >
                                {empresas.map(e => (
                                    <Select.Option value={e.id} key={e.id}>
                                        {`${e.id} - ${e.name}`}
                                    </Select.Option>
                                ))}
                            </Select>
                        </div>
                    </div>
                    <div className="row mt-1">
                        <div className="col">
                            <Button
                                size="small"
                                type="primary"
                                onClick={handleSincronizar}
                                disabled={form.empresaId === ''}
                            >
                                Sincronizar
                            </Button>
                        </div>
                    </div>
                </Card>
            </Spin>
        </>
    );
}
