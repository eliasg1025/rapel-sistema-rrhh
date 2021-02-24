import React, { useState, useEffect } from 'react';
import { Select, Button } from 'antd';
import Axios from 'axios';

export const Datos = ({ trabajador, contratoActivo, form, setForm, handleSubmit, submiting }) => {

    const { usuario, submodule } = JSON.parse(sessionStorage.getItem("data"));

    const [empresas, setEmpresas] = useState([]);
    const [regimenes, setRegimenes] = useState([]);
    const [zonasLabores, setZonasLabores] = useState([]);
    const [coloresFotocheck, setColoresFotocheck] = useState([]);
    const [motivosPerdidaFotocheck, setMotivosPerdidaFotocheck] = useState([]);
    const [loading, setLoading] = useState(false);

    useEffect(() => {
        function fetchEmpresas() {
            Axios.get('/api/empresa')
                .then(res => setEmpresas(res.data))
                .catch(err => {})
        }

        function fetchRegimenes() {
            Axios.get('http://192.168.60.16/api/regimen')
                .then(res => setRegimenes(res.data.data))
                .catch(err => {});
        }

        function fetchColoresFotocheck() {
            Axios.get('/api/colores-fotocheck')
                .then(res => setColoresFotocheck(res.data.data))
                .catch(err => {});
        }

        function fetchMotivosFotocheck() {
            Axios.get('/api/motivos-fotocheck')
                .then(res => setMotivosPerdidaFotocheck(res.data.data))
                .catch(err => {});
        }

        fetchEmpresas();
        fetchRegimenes();
        fetchColoresFotocheck();
        fetchMotivosFotocheck();
    }, []);

    useEffect(() => {
        function fetchZonasLabor() {
            Axios.get(`/api/zona-labor/${form.empresa_id}`)
                .then(res => {
                    setZonasLabores(res.data)
                })
                .catch(err => {});
        }

        if (form.empresa_id !== '') {
            fetchZonasLabor();
        }
    }, [form.empresa_id]);

    useEffect(() => {
        if (contratoActivo) {
            setForm({
                ...form,
                empresa_id: parseInt(contratoActivo.empresa_id),
                regimen_id: parseInt(contratoActivo.regimen_id),
                zona_labor_id: contratoActivo.zona_labor.id,
            });
        }
    }, [contratoActivo]);

    return (
        <>
            <form onSubmitCapture={handleSubmit}>
                <div className="row">
                    <div className="col-md-4">
                        Trabajador:
                        <br />
                        <input
                            className="form-control"
                            value={`${trabajador?.nombre ||
                                ""} ${trabajador?.apellido_paterno ||
                                ""} ${trabajador?.apellido_materno || ""}`}
                            readOnly={true}
                        />
                    </div>
                    <div className="col-md-4">
                        Fecha Solicitud:<br />
                        <input
                            type="text" name="fecha_solicitud" placeholder="Fecha solicitud" readOnly={true}
                            className="form-control"
                            value={form.fecha_solicitud}
                            onChange={e => setForm({ ...form, fecha_solicitud: e.target.value })}
                        />
                    </div>
                    <div className="col-md-4">
                        Empresa:<br />
                        <Select
                            value={form.empresa_id}
                            showSearch
                            size="small"
                            optionFilterProp="children"
                            filterOption={(input, option) =>
                                option.children
                                    .toLowerCase()
                                    .indexOf(input.toLowerCase()) >= 0
                            }
                            style={{
                                width: '100%',
                            }}
                            disabled
                        >
                            {empresas.map(e => (
                                <Select.Option value={e.id} key={e.id}>
                                    {`${e.id} - ${e.name}`}
                                </Select.Option>
                            ))}
                        </Select>
                    </div>
                    <div className="col-md-4">
                        Regimen:<br />
                        <Select
                            value={form.regimen_id}
                            showSearch
                            size="small"
                            optionFilterProp="children"
                            filterOption={(input, option) =>
                                option.children
                                    .toLowerCase()
                                    .indexOf(input.toLowerCase()) >= 0
                            }
                            onChange={e => setForm({ ...form, regimen_id: e })}
                            style={{
                                width: '100%',
                            }}
                            disabled
                        >
                            {regimenes.map(e => (
                                <Select.Option value={e.id} key={e.id}>
                                    {`${e.id} - ${e.name}`}
                                </Select.Option>
                            ))}
                        </Select>
                    </div>
                    <div className="col-md-4">
                        Zona Labor:<br />
                        <Select
                            value={form.zona_labor_id}
                            showSearch
                            size="small"
                            optionFilterProp="children"
                            filterOption={(input, option) =>
                                option.children
                                    .toLowerCase()
                                    .indexOf(input.toLowerCase()) >= 0
                            }
                            onChange={e => setForm({ ...form, zona_labor_id: e })}
                            style={{
                                width: '100%',
                            }}
                        >
                            {zonasLabores.map(e => (
                                <Select.Option value={e.id} key={e.id}>
                                    {`${e.id} - ${e.name}`}
                                </Select.Option>
                            ))}
                        </Select>
                    </div>
                    <div className="col-md-4">
                        Color:<br />
                        <Select
                            value={form.color_fotocheck_id}
                            showSearch
                            size="small"
                            optionFilterProp="children"
                            filterOption={(input, option) =>
                                option.children
                                    .toLowerCase()
                                    .indexOf(input.toLowerCase()) >= 0
                            }
                            onChange={e => setForm({ ...form, color_fotocheck_id: e })}
                            style={{
                                width: '100%',
                            }}
                        >
                            {coloresFotocheck.map(e => (
                                <Select.Option value={e.id} key={e.id}>
                                    {`${e.id} - ${e.color} - ${e.area}`}
                                </Select.Option>
                            ))}
                        </Select>
                    </div>
                    <div className="col-md-4">
                        Motivo:<br />
                        <Select
                            value={form.motivo_perdida_fotocheck_id}
                            showSearch
                            size="small"
                            optionFilterProp="children"
                            filterOption={(input, option) =>
                                option.children
                                    .toLowerCase()
                                    .indexOf(input.toLowerCase()) >= 0
                            }
                            onChange={e => setForm({ ...form, motivo_perdida_fotocheck_id: e })}
                            style={{
                                width: '100%',
                            }}
                        >
                            {motivosPerdidaFotocheck.map(e => (
                                <Select.Option value={e.id} key={e.id}>
                                    {`${e.id} - ${e.descripcion}`}
                                </Select.Option>
                            ))}
                        </Select>
                    </div>
                </div>
                <div className="row">
                    <div className="form-group col">
                        Observación:<br />
                        <textarea
                            className="form-control"
                            value={form.observacion}
                            onChange={e => setForm({ ...form, observacion: e.target.value })}
                        ></textarea>
                    </div>
                </div>
                <br />
                <div className="row">
                    <div className="col-md-12">
                        <Button htmlType="submit" type="primary" block loading={submiting}>
                            Guardar
                        </Button>
                    </div>
                </div>
            </form>
        </>
    );
}
