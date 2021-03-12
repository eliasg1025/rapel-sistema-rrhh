import React, { useState, useEffect } from "react";
import { Select, Button } from "antd";
import Axios from "axios";

export const Datos = ({
    trabajador,
    contratoActivo,
    form,
    setForm,
    handleSubmit,
    submiting
}) => {
    const { usuario, submodule } = JSON.parse(sessionStorage.getItem("data"));

    const [empresas, setEmpresas] = useState([]);
    const [regimenes, setRegimenes] = useState([]);
    const [zonasLabores, setZonasLabores] = useState([]);
    const [motivos, setMotivos] = useState([]);

    useEffect(() => {
        function fetchEmpresas() {
            Axios.get("/api/empresa")
                .then(res => setEmpresas(res.data))
                .catch(err => {});
        }

        function fetchRegimenes() {
            Axios.get("http://192.168.60.16/api/regimen")
                .then(res => setRegimenes(res.data.data))
                .catch(err => {});
        }

        function fetchMotivosFotocheck() {
            Axios.get("/api/motivos-planillas-manuales")
                .then(res => setMotivos(res.data.data))
                .catch(err => {});
        }

        fetchEmpresas();
        fetchRegimenes();
        fetchMotivosFotocheck();
    }, []);

    useEffect(() => {
        if (contratoActivo) {
            setForm({
                ...form,
                empresa_id: parseInt(contratoActivo.empresa_id),
                regimen_id: parseInt(contratoActivo.regimen_id),
                zona_labor_id: contratoActivo.zona_labor.id
            });
        }
    }, [contratoActivo]);

    useEffect(() => {
        function fetchZonasLabor() {
            Axios.get(`/api/zona-labor/${form.empresa_id}`)
                .then(res => {
                    setZonasLabores(res.data);
                })
                .catch(err => {});
        }

        if (form.empresa_id !== "") {
            fetchZonasLabor();
        }
    }, [form.empresa_id]);

    return (
        <>
            <form onSubmit={handleSubmit}>
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
                        Empresa:
                        <br />
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
                                width: "100%"
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
                    {/* <div className="col-md-4">
                        Regimen:
                        <br />
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
                                width: "100%"
                            }}
                            disabled
                        >
                            {regimenes.map(e => (
                                <Select.Option value={e.id} key={e.id}>
                                    {`${e.id} - ${e.name}`}
                                </Select.Option>
                            ))}
                        </Select>
                    </div> */}
                    <div className="col-md-4">
                        Zona Labor:
                        <br />
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
                            onChange={e =>
                                setForm({ ...form, zona_labor_id: e })
                            }
                            style={{
                                width: "100%"
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
                        Fecha Planilla: <br />
                        <input
                            type="date"
                            className="form-control"
                            value={form.fecha_planilla}
                            onChange={e =>
                                setForm({
                                    ...form,
                                    fecha_planilla: e.target.value
                                })
                            }
                        />
                    </div>
                    <div className="col-md-4">
                        Hora Entrada: <br />
                        <input
                            type="time"
                            className="form-control"
                            value={form.hora_entrada}
                            onChange={e =>
                                setForm({
                                    ...form,
                                    hora_entrada: e.target.value
                                })
                            }
                        />
                    </div>
                    <div className="col-md-4">
                        Hora Salida: <br />
                        <input
                            type="time"
                            className="form-control"
                            value={form.hora_salida}
                            onChange={e =>
                                setForm({
                                    ...form,
                                    hora_salida: e.target.value
                                })
                            }
                        />
                    </div>
                    <div className="col-md-4">
                        Motivo:
                        <br />
                        <Select
                            value={form.motivo_planilla_manual_id}
                            showSearch
                            size="small"
                            optionFilterProp="children"
                            filterOption={(input, option) =>
                                option.children
                                    .toLowerCase()
                                    .indexOf(input.toLowerCase()) >= 0
                            }
                            onChange={e => setForm({ ...form, motivo_planilla_manual_id: e })}
                            style={{
                                width: "100%"
                            }}
                        >
                            {motivos.map(e => (
                                <Select.Option value={e.id} key={e.id}>
                                    {`${e.id} - ${e.descripcion}`}
                                </Select.Option>
                            ))}
                        </Select>
                    </div>
                </div>
                <br />
                <div className="row">
                    <div className="col-md-12">
                        <Button
                            htmlType="submit"
                            type="primary"
                            block
                            loading={submiting}
                        >
                            Guardar
                        </Button>
                    </div>
                </div>
            </form>
        </>
    );
};
