import React, { useEffect, useState } from 'react';
import { Card, DatePicker, Select, Modal, notification } from 'antd';
import { ExclamationCircleOutlined } from '@ant-design/icons';
import Axios from 'axios';
import moment from 'moment';

import { empresa } from '../../../data/default.json';

export const Sincronizacion = () => {

    const [zonasLabor, setZonasLabor] = useState([]);
    const [form, setForm] =useState({
        empresaId: 9,
        tipoPago: 'SUELDO',
        periodo: moment().format('YYYY-MM').toString()
    });

    const tiposPagos = [
        {
            id: 'ANTICIPO',
            name: 'ANTICIPO'
        },
        {
            id: 'SUELDO',
            name: 'SUELDO'
        }
    ];

    useEffect(() => {
        if (form.empresaId) {
            Axios.get(`/api/zona-labor/${form.empresaId}`)
                .then(res => {
                    setZonasLabor(res.data);
                })
                .catch(err => console.error(err));
        }
    }, [form.empresaId]);

    return (
        <>
            <h4>Sincronización</h4>
            <br />
            <div className="row">
                <div className="col-md-12">
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
                                    {empresa.map(e => (
                                        <Select.Option value={e.id} key={e.id}>
                                            {`${e.id} - ${e.name}`}
                                        </Select.Option>
                                    ))}
                                </Select>
                            </div>
                            <div className="col-md-4">
                                Tipo Pago:<br />
                                <Select
                                    value={form.tipoPago} showSearch
                                    style={{ width: '100%' }} optionFilterProp="children"
                                    filterOption={(input, option) =>
                                        option.children
                                            .toLowerCase()
                                            .indexOf(input.toLowerCase()) >= 0
                                    }
                                    onChange={e => setForm({ ...form, tipoPago: e })}
                                    size="small"
                                >
                                    {tiposPagos.map(e => (
                                        <Select.Option value={e.id} key={e.id}>
                                            {`${e.name}`}
                                        </Select.Option>
                                    ))}
                                </Select>
                            </div>
                            <div className="col-md-4">
                                Periodo:<br />
                                <DatePicker
                                    size="small"
                                    allowClear={false}
                                    style={{ width: '100%' }}
                                    placeholder="Seleccione Periodo"
                                    picker="month"
                                    onChange={(date, dateString) => {
                                        setForm({
                                            ...form,
                                            periodo: dateString,
                                        })
                                    }}
                                    value={moment(form.periodo)}
                                />
                            </div>
                        </div>
                    </Card>
                </div>
            </div>
            <br />
            <div className="row">
                <div className="col-md-6">
                    <SyncForm
                        table="planilla"
                        eTable="payments"
                        zonasLabor={zonasLabor}
                        header={form}
                    />
                </div>
                <div className="col-md-6">
                    <SyncForm
                        table="detalle-planilla"
                        eTable="payments-detail"
                        zonasLabor={zonasLabor}
                        header={form}
                    />
                </div>
            </div>
            <br />
            <div className="row">
                <div className="col-md-6">
                    <SyncFormTarja
                        eTable="tarja"
                        header={form}
                    />
                </div>
            </div>
        </>
    );
}


const SyncForm = ({ table, eTable, zonasLabor, header }) => {

    const [zonasLaborId, setZonasLaborId] = useState([]);
    const [loadingZonas, setLoadingZonas] = useState(false);

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
        Axios.post(`http://209.151.144.74/api/${eTable}/many`,{
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
            });
    }

    const recoverData = () => {
        setLoadingZonas(true);
        Axios.post(`http://192.168.60.16/api/sueldos/${table}`, {
            ...header,
            zonasLaborId
        })
            .then(res => {
                const { data } = res;
                confirm(data, () => insertData(data));
            })
            .catch(err => {
                console.error(err);
            })
            .finally(() => setLoadingZonas(false));
    }

    const handleSubmit = e => {
        e.preventDefault();
        recoverData();
    }

    return (
        <>
            <h5>{table.toUpperCase()}:</h5>
            <Card>
                <form onSubmit={handleSubmit}>
                    <div className="row">
                        <div className="col-md-12">
                            Zonas Labor:<br />
                            <Select
                                mode="multiple"
                                allowClear
                                style={{ width: '100%' }}
                                placeholder="Seleccione ZONA LABOR"
                                onChange={value => setZonasLaborId(value)}
                                size="small"
                            >
                                {zonasLabor.map(item => (
                                    <Select.Option key={item.id} value={item.id}>
                                        {`${item.id} - ${item.name}`}
                                    </Select.Option>
                                ))}
                            </Select>
                        </div>
                    </div>
                    <br />
                    <div className="row">
                        <div className="col-md-12">
                            <button type="submit" className="btn btn-primary" disabled={loadingZonas}>
                                {!loadingZonas ? (
                                    <>
                                        <i className="fas fa-sync-alt"></i>{" "}Sincronizar <b>{ table.toUpperCase() }</b>
                                    </>
                                ) : (
                                    <>
                                        <i className="fas fa-sync-alt fa-spin"></i>{" "}Obteniendo datos
                                    </>
                                )}
                            </button>
                        </div>
                    </div>
                </form>
            </Card>
        </>
    );
}

const SyncFormTarja = ({ header, eTable }) => {

    const [loading, setLoading] = useState(false);
    const [form, setForm] = useState({
        regimenId: 1,
        conDigitacion: 'SI',
    });

    const regimenes = [
        {
            id: 1,
            name: 'Empleados Agrarios'
        },
        {
            id: 2,
            name: 'Empleados Regulares'
        },
        {
            id: 3,
            name: 'Obreros'
        }
    ];

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

    const insertData = (data, mes, anio) => {
        Axios.post(`http://remun-api.test/api/${eTable}/many`,{
            data,
            mes,
            anio
        })
            .then(res => {
                console.log(res.data);
                notification['success']({
                    message: res.data.message
                })
            })
            .catch(err => {
                console.log(err);
            });
    }

    const recoverData = () => {
        setLoading(true);
        Axios.post(`http://192.168.60.16/api/sueldos/horas-jornal`, {
            ...header,
            ...form
        })
            .then(res => {
                const { data, mes, anio } = res.data;
                confirm(data, () => insertData(data, mes, anio));
            })
            .catch(err => {
                console.error(err);
            })
            .finally(() => setLoading(false));
    }

    const handleSubmit = e => {
        e.preventDefault();
        recoverData();
    };

    return (
        <>
            <h5>TARJA</h5>
            <Card>
                <form onSubmit={handleSubmit}>
                    <div className="row">
                        <div className="col-md-6">
                            Regimen:<br />
                            <Select
                                allowClear
                                style={{ width: '100%' }}
                                value={form.regimenId}
                                placeholder="Seleccione REGIMEN"
                                onChange={value => setForm({...form, regimenId: value})}
                                size="small"
                            >
                                {regimenes.map(item => (
                                    <Select.Option key={item.id} value={item.id}>
                                        {`${item.id} - ${item.name}`}
                                    </Select.Option>
                                ))}
                            </Select>
                        </div>
                        <div className="col-md-6">
                            Con Digitacion:<br />
                            <Select
                                allowClear
                                value={form.conDigitacion}
                                style={{ width: '100%' }}
                                onChange={value => setForm({ ...form, conDigitacion: value })}
                                size="small"
                            >
                                {['SI', 'NO'].map(item => (
                                    <Select.Option key={item} value={item}>
                                        {`${item}`}
                                    </Select.Option>
                                ))}
                            </Select>
                        </div>
                    </div>
                    <br />
                    <div className="row">
                        <div className="col-md-12">
                            <button className="btn btn-primary" disabled={loading}>
                                {!loading ? (
                                    <>
                                        <i className="fas fa-sync-alt"></i>{" "}Sincronizar <b>TARJA</b>
                                    </>
                                ) : (
                                    <>
                                        <i className="fas fa-sync-alt fa-spin"></i>{" "}Obteniendo datos
                                    </>
                                )}
                            </button>
                        </div>
                    </div>
                </form>
            </Card>
        </>
    );
}
