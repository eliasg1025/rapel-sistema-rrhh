import React, { useState, useEffect } from "react";
import { Card, DatePicker, Select, Tabs, Modal, notification } from "antd";
import moment from 'moment';
import Axios from 'axios';

import { TablaPlanillasPendientes, TablaPlanillasGeneradas } from "../components";

export const PlanillasManuales = () => {

    const { usuario, submodule } = JSON.parse(sessionStorage.getItem("data"));

    const [loading, setLoading] = useState(false);
    const [empresas, setEmpresas] = useState([]);
    const [planillas, setPlanillas] = useState([]);
    const [planillasG, setPlanillasG] = useState([]);
    const [form, setForm] = useState({
        desde: moment()
            .subtract(7, 'days')
            .format("YYYY-MM-DD")
            .toString(),
        hasta: moment()
            .format("YYYY-MM-DD")
            .toString(),
        empresa_id: 9,
    });
    const [reload, setReload] = useState(false);

    useEffect(() => {
        function fetchEmpresas() {
            Axios.get('/api/empresa')
                .then(res => setEmpresas(res.data))
                .catch(err => {})
        }

        fetchEmpresas();
    }, []);

    useEffect(() => {
        setLoading(true);
        function fetchPlanillas(estado) {
            Axios.get(`/api/planillas-manuales?tipo=renovaciones_fotocheck&empresa_id=${form.empresa_id}&estado=${estado}&desde=${form.desde}&hasta=${form.hasta}&usuario_id=${usuario.id}`)
                .then(res => {
                    const _data = res.data.data.map(item => {
                        return {
                            ...item,
                            key: item.id,
                        }
                    });

                    if (estado === 0) {
                        setPlanillas(_data);
                    } else {
                        setPlanillasG(_data);
                    }
                })
                .catch(err => {})
                .finally(() => setLoading(false))
        }

        fetchPlanillas(0);
        fetchPlanillas(1);
    }, [form, reload]);

    const handleDelete = (id) => {
        Modal.confirm({
            title: 'Borrar registros',
            content: '¿Desea borrar este registro correctamente?',
            onOk: () => {
                Axios.delete(`/api/planillas-manuales/${id}`)
                    .then(res => {
                        notification['success']({
                            message: res.data.message,
                        });

                        setReload(!reload);
                    })
                    .catch(err => {
                        console.log(err);
                        notification['error']({
                            message: 'Error al eliminar registro'
                        });
                    })
            }
        })
    }

    return (
        <>
            <h4>Planillas Manuales</h4>
            <br />
            <Tabs defaultActiveKey="1">
                <Tabs.TabPane key="1" tab="Pendientes">
                    <Card>
                        <form>
                            <div className="row">
                                <div className="col-md-4">
                                    Empresa:
                                    <br />
                                    <Select
                                        value={form.empresa_id}
                                        showSearch
                                        optionFilterProp="children"
                                        filterOption={(input, option) =>
                                            option.children
                                                .toLowerCase()
                                                .indexOf(input.toLowerCase()) >= 0
                                        }
                                        onChange={e =>
                                            setForm({ ...form, empresa_id: e })
                                        }
                                        style={{
                                            width: "100%"
                                        }}
                                    >
                                        {/* <Select.Option value={0} key={0}>TODOS</Select.Option> */}
                                        {empresas.map(e => (
                                            <Select.Option value={e.id} key={e.id}>
                                                {`${e.id} - ${e.name}`}
                                            </Select.Option>
                                        ))}
                                    </Select>
                                </div>
                            </div>
                        </form>
                    </Card>
                    <br />
                    <div className="alert alert-primary">
                        Registro de trabajadores pendientes de planilla manual, <b>asigna</b> fecha(s) para hacer válida la planilla dando click en <i className="fas fa-calendar-plus"></i>
                    </div>
                    <TablaPlanillasPendientes
                        data={planillas}
                        loading={loading}
                        reload={reload}
                        setReload={setReload}
                        handleDelete={handleDelete}
                    />
                </Tabs.TabPane>
                <Tabs.TabPane key="2" tab="Generados">
                    <Card>
                        <form>
                            <div className="row">
                                <div className="col-md-4">
                                    Desde - Hasta:
                                    <br />
                                    <DatePicker.RangePicker
                                        placeholder={["Desde", "Hasta"]}
                                        style={{ width: "100%" }}
                                        onChange={(date, dateString) => {
                                            setForm({
                                                ...form,
                                                desde: dateString[0],
                                                hasta: dateString[1]
                                            });
                                        }}
                                        value={[moment(form.desde), moment(form.hasta)]}
                                    />
                                </div>
                                <div className="col-md-4">
                                    Empresa:
                                    <br />
                                    <Select
                                        value={form.empresa_id}
                                        showSearch
                                        optionFilterProp="children"
                                        filterOption={(input, option) =>
                                            option.children
                                                .toLowerCase()
                                                .indexOf(input.toLowerCase()) >= 0
                                        }
                                        onChange={e =>
                                            setForm({ ...form, empresa_id: e })
                                        }
                                        style={{
                                            width: "100%"
                                        }}
                                    >
                                        {/* <Select.Option value={0} key={0}>TODOS</Select.Option> */}
                                        {empresas.map(e => (
                                            <Select.Option value={e.id} key={e.id}>
                                                {`${e.id} - ${e.name}`}
                                            </Select.Option>
                                        ))}
                                    </Select>
                                </div>
                            </div>
                        </form>
                    </Card>
                    <br />
                    <TablaPlanillasGeneradas
                        data={planillasG}
                        loading={loading}
                        reload={reload}
                        setReload={setReload}
                        handleDelete={handleDelete}
                    />
                </Tabs.TabPane>
            </Tabs>
        </>
    );
};
