import React, { useEffect, useState } from 'react';
import { Select, message } from 'antd';
import Axios from 'axios';
import { ReporteDiario } from './components/ReporteDiario';

import { empresa } from '../../../data/default.json';
import { TablaAsegurados } from './components/TablaAsegurados';
import { filter } from 'lodash';

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

    const handleExport = () => {
        const headings = [
            'Item', 'Apellido Paterno', 'Apellido Materno', 'Nombres', 'Sexo', 'Fecha Nac.', 'Nacionalidad',
            'Tipo Doc.', 'Numero Doc.', 'DC', 'Condición', 'Cargo', 'Moneda Sueldo', 'Sueldo', 'Tasa', 'Fec. Ingreso'
        ];

        const data = asegurados.map((a, i) => {
            return {
                item: i,
                apellido_paterno: a.apellido_paterno,
                apellido_materno: a.apellido_materno,
                nombre: a.nombres,
                sexo: a.sexo,
                fecha_nacimiento: a.fecha_nacimiento,
                nacionalidad: '',
                tipo_documento: a.tipo_documento,
                numero_documento: a.rut,
                dc: '',
                condicion: 'P',
                cargo: a.cargo,
                moneda_sueldo: '0',
                sueldo: a.sueldo,
                tasa: '',
                fecha_ingreso: a.fecha_ingreso
            }
        });

        Axios({
            url: '/descargar',
            data: {headings, data},
            method: 'POST',
            responseType: 'blob'
        })
            .then(response => {
                console.log(response);
                let blob = new Blob([response.data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' })
                let link = document.createElement('a')
                link.href = window.URL.createObjectURL(blob)
                link.download = `PLANILLA-SCTR-${parseInt(form.empresa_id) === 9  ? 'RAPEL' : 'VERFRUT'}-ACTUAL.xlsx`
                link.click();
            })
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
                                <button type="submit" className="btn btn-primary">
                                    Buscar
                                </button>
                            </div>
                            <div className="col-md-4">
                                <br />
                                <button type="button" className="btn btn-success" onClick={handleExport}>
                                    Exportar
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
