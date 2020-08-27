import React, { useEffect, useState } from 'react';
import { Select, message } from 'antd';
import Axios from 'axios';
import { ReporteDiario } from './components/ReporteDiario';

import { empresa } from '../../../data/default.json';
import { TablaAsegurados } from './components/TablaAsegurados';

export const Reportes = () => {

    const [oficiosSctr, setOficiosSctr] = useState([]);
    const [cuartelesSctr, setCuartelesSctr] = useState([]);
    const [asegurados, setAsegurados] = useState([]);

    const [form, setForm] = useState({
        empresa_id: 9,
    });

    useEffect(() => {
        let intentos = 0;
        const fetchOficiosIndexesSctr = empresa_id => {
            intentos++;
            Axios.get(`/api/oficio/get-indexes-with-sctr/${empresa_id}`)
                .then(res => {
                    //console.log(res)
                    setOficiosSctr(res.data);
                })
                .catch(err => {
                    console.error(err);
                    if (intentos < 3) {
                        fetchOficiosIndexesSctr();
                    }
                });
        }

        let intentos1 = 0;
        const fetchCuartelesIndexesSctr = empresa_id => {
            intentos1++;
            Axios.get(`/api/cuartel/get-indexes-with-sctr/${empresa_id}`)
                .then(res => {
                    //console.log(res)
                    setCuartelesSctr(res.data);
                })
                .catch(err => {
                    console.error(err)
                    if (intentos < 3) {
                        fetchCuartelesIndexesSctr();
                    }
                });
        }

        fetchOficiosIndexesSctr(form.empresa_id);
        fetchCuartelesIndexesSctr(form.empresa_id);
    }, [form.empresa_id]);

    const handleSubmit = e => {
        e.preventDefault();

        Axios.post(`http://192.168.60.16/api/planilla/sctr/${form.empresa_id}`, {
            oficios: oficiosSctr,
            cuarteles: cuartelesSctr
        })
            .then(res => {
                message['success']({
                    content: `Se han obtenido ${res.data.length} registros`
                });
                setAsegurados(res.data.map(e => {
                    return {
                        ...e,
                        tipo_documento: e.tipo_documento == '1' ? 'DNI' : 'CE'
                    }
                }))
            })
            .catch(err => console.error(err));
    }

    return (
        <>
            <h4>Reportes</h4>
            <div className="card">
                <div className="card-body">
                    <form onSubmit={handleSubmit}>
                        <div className="form-row">
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
                                >
                                    {empresa.map(e => (
                                        <Select.Option value={e.id} key={e.id}>
                                            {`${e.id} - ${e.name}`}
                                        </Select.Option>
                                    ))}
                                </Select>
                            </div>
                            <div className="col-md-4">
                                <br />
                                <button type="submit" className="btn btn-success">
                                    Buscar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <br />
            <TablaAsegurados
                asegurados={asegurados}
            />
            <ReporteDiario
                oficiosSctr={oficiosSctr}
                cuartelesSctr={cuartelesSctr}
            />
        </>
    );
}
