import React, { useState, useEffect } from 'react';
import { DatePicker } from 'antd';
import moment from 'moment';
import Axios from 'axios';
import {SubirArchivo} from "../../shared/SubirArchivo";

export const Main = () => {

    const [loading, setLoading] = useState(false);

    const [form, setForm] = useState({
        desde: moment('2020-01').format('YYYY-MM').toString(),
        hasta: moment().format('YYYY-MM').toString(),
        empresa_id: '9',
    });

    const handleSincronizar = () => {
        console.log('sincronizar');
    }

    const handleExportar = () => {
        console.log('Exportar');
    }

    const handleImportar = () => {
        console.log('importar');
    }

    const handleSubmit = e => {
        e.preventDefault();
        console.log(form);

        const url = `/api/finiquitos/importar-tu-recibo`;
        const formData = new FormData();
        formData.append('tu-recibo', form.file);
        formData.append('empresa_id', form.empresa_id);

        const config = {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }

        Axios.post(url, formData, config)
            .then(res => {
                console.log(res);
            })
            .catch(err => {
                console.error(err);
            })
    }

    return (
        <>
            <h3>Pagos de Liquidaciones y Utilidades</h3>
            <br />
            <div className="card">
                <div className="card-header">
                    <h6>Importación TU RECIBO</h6>
                </div>
                <div className="card-body">
                    <form onSubmit={handleSubmit}>
                        <div className="form-row">
                            <div className="col-md-3">
                                <div className="form-group">
                                    <select
                                        value={form.empresa_id}
                                        onChange={e => setForm({
                                            ...form,
                                            empresa_id: e.target.value
                                        })}
                                        className="form-control"
                                    >
                                        <option key="9" value="9">RAPEL</option>
                                        <option key="14" value="14">VERFRUT</option>
                                    </select>
                                </div>
                            </div>
                            <div className="col-md-3">
                                <SubirArchivo
                                    form={form}
                                    setForm={setForm}
                                />
                            </div>
                        </div>
                        <div className="form-row">
                            <div className="col">
                                <button className="btn btn-primary">
                                    Importar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </>
    );
}
