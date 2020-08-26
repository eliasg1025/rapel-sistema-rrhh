import React, { useState, useEffect } from 'react';
import { Select } from 'antd';
import Axios from 'axios';

import { empresa } from '../../../../data/default.json';

export const HabilitarCuarteles = () => {
    const [zonasLabor, setZonasLabor] = useState([]);
    const [cuarteles, setCuarteles] = useState([]);
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

    const handleSubmit = e => {
        e.preventDefault();
        console.log(form);
    }

    return (
        <>
            <h5>Habilitar Cuarteles</h5>
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
        </>
    );
}
