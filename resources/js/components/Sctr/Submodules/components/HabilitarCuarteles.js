import React, { useState, useEffect } from 'react';
import { Select, message } from 'antd';
import Axios from 'axios';

import { empresa } from '../../../../data/default.json';
import { TablaHabilitados } from './TablaHabilitados';

export const HabilitarCuarteles = () => {
    const [zonasLabor, setZonasLabor] = useState([]);
    const [cuarteles, setCuarteles] = useState([]);
    const [cuartelesSctr, setCuartelesSctr] = useState([]);
    const [reloadData, setReloadData] = useState(false);
    const [form, setForm] = useState({
        empresa_id: 9,
        zona_labor_id: '',
        cuartel_id: '',
    });

    useEffect(() => {
        setForm({ ...form, zona_labor_id: '', cuartel_id: '' });
        fetchZonasLabor();
    }, [form.empresa_id]);

    useEffect(() => {
        setForm({ ...form, cuartel_id: '' });
        if (form.zona_labor_id !== '') {
            fetchCuarteles();
        }
    }, [form.empresa_id, form.zona_labor_id]);

    useEffect(() => {
        fetchCuartelesSctr();
    }, [reloadData]);

    const fetchCuartelesSctr = () => {
        Axios.get('/api/cuartel/get-with-sctr')
            .then(res => {
                setCuartelesSctr(res.data.map(o => {
                    return {
                        ...o,
                        key: o.id
                    }
                }));
            })
            .catch(err => console.error(err));
    }

    const fetchZonasLabor = () => {
        Axios.get(`http://192.168.60.16/api/zona-labor/${form.empresa_id}`)
            .then(res => setZonasLabor(res.data.data))
            .catch(err =>  console.error(err));
    }

    const fetchCuarteles = () => {
        Axios.get(`http://192.168.60.16/api/cuartel/${form.empresa_id}/${form.zona_labor_id}`)
            .then(res => setCuarteles(res.data.data))
            .catch(err => console.error(err));
    }

    const handleDelete = id => {
        console.log(id);
        Axios.put(`/api/cuartel/${id}/disable-sctr`)
            .then(res => {
                message['success']({
                    content: res.data.message
                });
                setReloadData(!reloadData);
            })
            .catch(err => console.log(err));
    }

    const handleSubmit = e => {
        e.preventDefault();
        const zona_labor = zonasLabor.find(z => parseInt(z.id) === parseInt(form.zona_labor_id) && parseInt(z.empresa_id) === parseInt(form.empresa_id));
        const cuartel = cuarteles.find(c => c.id === form.cuartel_id && parseInt(c.empresa_id) === parseInt(form.empresa_id) && parseInt(c.zona_labor_id) === parseInt(form.zona_labor_id));
        cuartel.sctr = true;

        Axios.post('/api/cuartel', { zona_labor, cuartel })
            .then(res => {
                message['success']({
                    content: res.data.message
                });
                setForm({ ...form, oficio_id: '' })
                setReloadData(!reloadData);
            })
            .catch(err => console.error(err));
    }

    const columns = [
        {
            title: 'Empresa',
            dataIndex: 'empresa'
        },
        {
            title: 'Zona Labor',
            dataIndex: 'zona_labor'
        },
        {
            title: 'Cuartel',
            dataIndex: 'cuartel'
        },
        {
            title: '',
            render: (_, record) => (
                <button className="btn btn-danger btn-sm" onClick={() => handleDelete(record.id)}>
                    <i className="far fa-times-circle"></i>
                </button>
            )
        }
    ];

    return (
        <>
            <h5>Habilitar Cuarteles</h5>
            <div className="row">
                <div className="col">
                    <div className="card">
                        <div className="card-body">
                            <form onSubmit={handleSubmit}>
                                <div className="form-row">
                                    <div className="col-md-6">
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
                                        >
                                            {empresa.map(e => (
                                                <Select.Option value={e.id} key={e.id}>
                                                    {`${e.id} - ${e.name}`}
                                                </Select.Option>
                                            ))}
                                        </Select>
                                    </div>
                                    <div className="col-md-6">
                                        Zona Labor:<br />
                                        <Select
                                            value={form.zona_labor_id} showSearch
                                            style={{ width: '100%' }} optionFilterProp="children"
                                            filterOption={(input, option) =>
                                                option.children
                                                    .toLowerCase()
                                                    .indexOf(input.toLowerCase()) >= 0
                                            }
                                            onChange={e => setForm({ ...form, zona_labor_id: e })}
                                        >
                                            {zonasLabor.map(e => (
                                                <Select.Option value={e.id} key={e.id}>
                                                    {`${e.id} - ${e.name}`}
                                                </Select.Option>
                                            ))}
                                        </Select>
                                    </div>
                                </div>
                                <div className="form-row">
                                    <div className="col-md-6">
                                        Cuartel:<br />
                                        <Select
                                            value={form.cuartel_id} showSearch
                                            style={{ width: '100%' }} optionFilterProp="children"
                                            filterOption={(input, option) =>
                                                option.children
                                                    .toLowerCase()
                                                    .indexOf(input.toLowerCase()) >= 0
                                            }
                                            onChange={e => setForm({ ...form, cuartel_id: e })}
                                        >
                                            {cuarteles.map(e => (
                                                <Select.Option value={e.id} key={e.id}>
                                                    {`${e.id} - ${e.name}`}
                                                </Select.Option>
                                            ))}
                                        </Select>
                                    </div>
                                    <div className="col">
                                        <br />
                                        <button type="submit" className="btn btn-success">
                                            Habilitar Cuartel
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            <br />
            <div className="row">
                <div className="col">
                    <TablaHabilitados
                        columns={columns}
                        data={cuartelesSctr}
                    />
                </div>
            </div>
        </>
    );
}
