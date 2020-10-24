import React, { useEffect, useState } from 'react';
import { Card, Select } from 'antd';

import { empresa } from '../../../data/default.json';
import Axios from 'axios';

export const Sincronizacion = () => {

    const [zonasLabor, setZonasLabor] = useState([]);
    const [form, setForm] =useState({
        empresa_id: ''
    });

    useEffect(() => {
        if (form.empresa_id) {
            Axios.get(`http://192.168.60.16/api/zona-labor/${form.empresa_id}`)
                .then(res => {
                    setZonasLabor(res.data.data);
                })
                .catch(err => console.error(err));
        }
    }, [form.empresa_id]);

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
                                    value={form.empresa_id} showSearch
                                    style={{ width: '100%' }} optionFilterProp="children"
                                    filterOption={(input, option) =>
                                        option.children
                                            .toLowerCase()
                                            .indexOf(input.toLowerCase()) >= 0
                                    }
                                    onChange={e => setForm({ ...form, empresa_id: e })}
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
                                <input
                                    className="form-control"
                                />
                            </div>
                        </div>
                    </Card>
                </div>
            </div>
            <br />
            <div className="row">
                <div className="col-md-6">
                    <h5>Trabajadores:</h5><br />
                    <Card>
                        <SyncForm
                            table="trabajadores"
                            zonasLabor={zonasLabor}
                        />
                    </Card>
                </div>
                <div className="col-md-6">
                    <h5>Pagos:</h5><br />
                    <Card>
                        <SyncForm
                            table="pagos"
                            zonasLabor={zonasLabor}
                        />
                    </Card>
                </div>
            </div>
        </>
    );
}


const SyncForm = ({ table, zonasLabor }) => {

    const handleSubmit = e => {
        e.preventDefault();
        console.log('submit ' + table);
    }

    return (
        <form onSubmit={handleSubmit}>
            <div className="row">
                <div className="col-md-6">
                    <Select
                        mode="multiple"
                        allowClear
                        style={{ width: '100%' }}
                        placeholder="Seleccione ZONA LABOR"
                        size="small"
                    >
                        {zonasLabor.map(item => (
                            <Select.Option key={item.id} value={item.id}>{item.name}</Select.Option>
                        ))}
                    </Select>
                </div>
                <div className="col-md-6">
                    <input
                        type="text" className="form-control"
                    />
                </div>
            </div>
            <br />
            <div className="row">
                <div className="col-md-12">
                    <button type="submit" className="btn btn-primary">
                        <i className="fas fa-sync-alt"></i>{" "}Sincronizar <b>{ table.toUpperCase() }</b>
                    </button>
                </div>
            </div>
        </form>
    );
}
