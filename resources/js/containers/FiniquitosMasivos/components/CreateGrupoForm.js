import React, { useState, useEffect } from 'react';
import moment from "moment";
import { Button, Card, DatePicker, notification, Select } from "antd";
import { empresa } from "../../../data/default.json";
import Axios from "axios";

export const CreateGrupoForm = ({ reload, setReload }) => {

    const { usuario, submodule } = JSON.parse(sessionStorage.getItem('data'));

    const [zonasLabor, setZonasLabor] = useState([]);
    const [rutas, setRutas] = useState([]);
    const [form, setForm] = useState({
        //empresa_id: '',
        fecha_finiquito: moment().format('YYYY-MM-DD').toString(),
        zona_labor: '',
        ruta: '',
        codigo_bus: ''
    });

    const isValidForm = Object.values(form).indexOf('') !== -1;

    useEffect(() => {
        Axios.get('/api/zona-labor')
            .then(res => {
                setZonasLabor(res.data);
            })
            .catch(err => {
                console.error(err);
            });

        Axios.get('/api/sqlsrv/rutas')
            .then(res => {
                setRutas(res.data);
            })
            .catch(err => {
                console.error(err);
            });
    }, []);

    const handleSubmit = e => {
        e.preventDefault();

        Axios.post('/api/grupos-finiquitos', {
            ...form,
            usuario_id: usuario.id
        })
            .then(res => {
                notification['success']({
                    message: res.data.message
                });

                setReload(!reload);
            })
            .catch(err => {
                console.error(err);
            });
    }

    return (
        <Card>
            <form onSubmit={handleSubmit}>
                <div className="row">
                    <div className="col-md-4">
                        Zona Labor:<br />
                        <Select
                            value={form.zona_labor} showSearch
                            style={{ width: '100%' }} optionFilterProp="children"
                            filterOption={(input, option) =>
                                option.children
                                    .toLowerCase()
                                    .indexOf(input.toLowerCase()) >= 0
                            }
                            onChange={e => setForm({ ...form, zona_labor: e })}
                            size="small"
                        >
                            {zonasLabor.map(e => (
                                <Select.Option value={e.name} key={e.name}>
                                    {`${e.name}`}
                                </Select.Option>
                            ))}
                        </Select>
                    </div>
                    <div className="col-md-4">
                        Ruta:<br />
                        <Select
                            value={form.ruta} showSearch
                            style={{ width: '100%' }} optionFilterProp="children"
                            filterOption={(input, option) =>
                                option.children
                                    .toLowerCase()
                                    .indexOf(input.toLowerCase()) >= 0
                            }
                            onChange={e => setForm({ ...form, ruta: e })}
                            size="small"
                        >
                            {rutas.map(e => (
                                <Select.Option value={e.name} key={e.name}>
                                    {`${e.name}`}
                                </Select.Option>
                            ))}
                        </Select>
                    </div>
                    <div className="col-md-4">
                        Código Bus:<br />
                        <input
                            type="text"
                            className="form-control"
                            value={form.codigo_bus}
                            onChange={e => setForm({ ...form, codigo_bus: e.target.value })}
                        />
                    </div>
                </div>
                <br />
                <div className="row">
                    {/* <div className="col-md-4">
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
                    </div> */}
                    <div className="col-md-4">
                        Fecha Finiquito:<br />
                        <DatePicker
                            style={{ width: '100%' }}
                            size="small"
                            value={moment(form.fecha_finiquito)}
                            allowClear={false}
                            onChange={(date, dateString) => setForm({ ...form, fecha_finiquito: dateString })}
                        />
                    </div>
                    <div className="col-md-4">
                        Generado Por:<br />
                        <input
                            type="text"
                            className="form-control"
                            readOnly={true}
                            value={`${usuario.trabajador.apellido_paterno} ${usuario.trabajador.apellido_paterno} ${usuario.trabajador.nombre}`}
                        />
                    </div>
                </div>
                <br />
                <div className="row">
                    <div className="col-md-12">
                        <Button
                            type="primary"
                            htmlType="submit"
                            block
                            disabled={isValidForm}
                        >
                            Crear
                        </Button>
                    </div>
                </div>
            </form>
        </Card>
    );
}
