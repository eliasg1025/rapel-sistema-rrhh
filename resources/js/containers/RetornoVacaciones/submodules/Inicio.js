import React, { useState, useEffect } from "react";
import { Card, DatePicker, Button, Select, Tabs } from "antd";
import moment from "moment";
import Axios from 'axios';
import { TablaResumen } from "../components/TablaResumen";
import { Tab } from "bootstrap";
import { TablaDatos } from "../components/TablaDatos";

export const Inicio = () => {

    const { usuario, submodule } = JSON.parse(sessionStorage.getItem("data"));

    const [empresas, setEmpresas] = useState([]);
    const [form, setForm] = useState({
        desde: moment()
            .subtract(7, "days")
            .format("YYYY-MM-DD")
            .toString(),
        hasta: moment()
            .format("YYYY-MM-DD")
            .toString(),
        empresa_id: 9
    });
    const [data, setData] = useState([]);
    const [dataResumen, setDataResumen] = useState([]);
    const [loading, setLoading] = useState(false);

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
        Axios.get(`/api/sqlsrv/vacaciones/programacion-retornos?desde=${form.desde}&hasta=${form.hasta}&empresa_id=${form.empresa_id}`)
            .then(res => {
                setData(res.data.data.map(item => {
                    return {
                        ...item,
                        key: item.IdVacacion
                    };
                }));


                const data = res.data.data;

                const fechas = Array.from(new Set(data.map(item => item.FechaRetorno))).sort();

                const dataPorFechas = fechas.map(fecha => {
                    const tempData = data.filter(item => item.FechaRetorno === fecha);
                    const zonasLabor = Array.from(new Set(tempData.map(item => item.ZonaLabor))).sort()

                    return {
                        key: fecha,
                        fecha_retorno: fecha,
                        data: tempData,
                        "Empleados Agrarios": tempData.filter(item => item.Regimen === "Empleados Agrarios").length,
                        "Empleados Regulares": tempData.filter(item => item.Regimen === "Empleados Regulares").length,
                        "Obreros": tempData.filter(item => item.Regimen === "Obreros").length,
                        "Administrativos": tempData.filter(item => item.Regimen === "Administrativos").length,
                        children: zonasLabor.map(zonaLabor => {
                            const tempData2 = tempData.filter(item => item.ZonaLabor === zonaLabor);

                            return {
                                key: `${fecha}-${zonaLabor}`,
                                fecha_retorno: fecha,
                                zona_labor: zonaLabor,
                                data: tempData2,
                                "Empleados Agrarios": tempData2.filter(item => item.Regimen === "Empleados Agrarios").length,
                                "Empleados Regulares": tempData2.filter(item => item.Regimen === "Empleados Regulares").length,
                                "Obreros": tempData2.filter(item => item.Regimen === "Obreros").length,
                                "Administrativos": tempData2.filter(item => item.Regimen === "Administrativos").length,
                            }
                        })
                    }
                })

                setDataResumen(dataPorFechas);
            })
            .catch(err => {})
            .finally(() => setLoading(false));
    }, [form]);

    return (
        <>
            <h4>Programación de Retornos</h4>
            <br />
            <Card>
                <div className="alert alert-primary">
                    Obetener trabajadores de retorno de vacaciones en un rango de fechas
                </div>
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
                                onChange={e => setForm({ ...form, empresa_id: e })}
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
                    {/* <br />
                    <div className="row">
                        <div className="col-md-4">
                            <Button type="primary">Consultar</Button>
                        </div>
                    </div> */}
                </form>
            </Card>
            <br />
            <hr />
            <br />
            <Tabs defaultActiveKey="1">
                <Tabs.TabPane tab="Resumen" key="1">
                    <TablaResumen
                        data={dataResumen}
                        loading={loading}
                    />
                </Tabs.TabPane>
                <Tabs.TabPane tab="Data" key="2">
                    <TablaDatos
                        data={data}
                        loading={loading}
                    />
                </Tabs.TabPane>
            </Tabs>
        </>
    );
};
