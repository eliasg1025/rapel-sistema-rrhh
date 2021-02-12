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
        .format("YYYY-MM-DD")
        .toString(),
        hasta: moment()
            .add(7, "days")
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
                        "Empleados": tempData.filter(item => ["Empleados Agrarios", "Empleados Regulares", "Administrativos"].includes(item.Regimen)).length,
                        "Obreros": tempData.filter(item => item.Regimen === "Obreros").length,
                        children: zonasLabor.map(zonaLabor => {
                            const tempData2 = tempData.filter(item => item.ZonaLabor === zonaLabor);

                            return {
                                key: `${fecha}-${zonaLabor}`,
                                fecha_retorno: fecha,
                                zona_labor: zonaLabor,
                                data: tempData2,
                                "Empleados": tempData2.filter(item => ["Empleados Agrarios", "Empleados Regulares", "Administrativos"].includes(item.Regimen)).length,
                                "Obreros": tempData2.filter(item => item.Regimen === "Obreros").length,
                            }
                        })
                    }
                })

                setDataResumen(dataPorFechas);
            })
            .catch(err => {})
            .finally(() => setLoading(false));
    }, [form]);

    const handleExportar = () => {
        const headings = [
            "EMPRESA",
            "RUT",
            "TRABAJADOR",
            "FECHA INICIO",
            "FECHA RETORNO",
            "DIAS",
            "OFICIO",
            "REGIMEN",
            "ZONA LABOR",
        ];

        const d = data.map(item => {
            return {
                empresa: item.Empresa,
                rut: item.RutTrabajador,
                trabajador: item.Trabajador,
                fecha_inicio: item.FechaInicio,
                fehca_retorno: item.FechaRetorno,
                dias: item.Dias,
                oficio: item.Oficio,
                regimen: item.Regimen,
                zona_labor: item.ZonaLabor
            };
        });

        Axios({
            url: "/descargar",
            data: { headings, data: d },
            method: "POST",
            responseType: "blob"
        }).then(response => {
            let blob = new Blob([response.data], {
                type:
                    "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
            });
            let link = document.createElement("a");
            link.href = window.URL.createObjectURL(blob);
            link.download = `PROGRAMACION-RETORNO-VACACIONES_${form.empresa_id}_${form.desde}_${form.hasta}.xlsx`;
            link.click();
        });
    }

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
            <b style={{ fontSize: "13px" }}>
                Cantidad: {data.length} registros&nbsp;
                <button
                    className="btn btn-success btn-sm"
                    onClick={handleExportar}
                >
                    <i className="fas fa-file-excel" /> Exportar
                </button>
            </b>
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
