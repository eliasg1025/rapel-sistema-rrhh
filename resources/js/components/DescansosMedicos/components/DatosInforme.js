import React, { useState } from 'react';
import { DatePicker, message, Select, notification } from 'antd';
import moment from 'moment';

import { empresa } from '../../../data/default.json';
import Axios from 'axios';

export const DatosInforme = ({ reloadData, setReloadData }) => {

    const { usuario } = JSON.parse(sessionStorage.getItem('data'));

    const [form, setForm] = useState({
        empresa_id: '',
        fecha_inicio: moment().format('YYYY-MM-DD').toString(),
    });

    const handleSubmit = e => {
        e.preventDefault();

        Axios.post(`/api/informes-descansos`, {
            usuarioId: usuario.id,
            empresaId: form.empresa_id,
            fechaInicio: form.fecha_inicio
        })
            .then(res => {
                notification['success']({
                    message: res.data.message
                });
                setReloadData(!reloadData)
            })
            .catch(err => {
                console.error(err);
                notification['error']({
                    message: err.response.data.message
                });
            });
    }

    return (
        <form onSubmit={handleSubmit} className="card">
            <div className="card-body">
                <div className="row">
                    <div className="form-group col-md-4">
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
                    <div className="form-group col-md-4">
                        Fecha Informe:<br />
                        <input
                            type="text" name="fecha_inicio" placeholder="Fecha Informe" readOnly={true}
                            className="form-control"
                            value={form.fecha_inicio}
                            onChange={e => setForm({ ...form, fecha_inicio: e.target.value })}
                        />
                    </div>
                </div>
                <div className="row">
                    <div className="form-group col-md-4">
                        <button type="submit" className="btn btn-primary">
                            Comenzar Informe
                        </button>
                    </div>
                </div>
            </div>
        </form>
    );
}
