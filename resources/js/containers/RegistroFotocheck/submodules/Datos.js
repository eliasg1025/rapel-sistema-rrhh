import React, { useState, useEffect } from "react";
import { Card, DatePicker, Select, Table } from "antd";
import moment from 'moment';
import Axios from 'axios';
import { TablaResumen } from "../components";

export const Datos = () => {

    const { usuario, submodule } = JSON.parse(sessionStorage.getItem("data"));

    const [empresas, setEmpresas] = useState([]);
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
    const [data, setData] = useState([]);
    const [dataResumen, setDataResumen] = useState([]);
    const [loading, setLoading] = useState(false);
    const [columns, setColumns] = useState(initialStateColumns);

    const initialStateColumns = [
        {
            title: 'FUNDO',
            dataIndex: 'zona_labor',
        },
        {
            title: 'SOLICITANTE',
            dataIndex: 'solicitante'
        },
        {
            title: 'DNI/RUT',
            dataIndex: 'rut'
        },
        {
            title: 'APELLIDOS Y NOMBRES',
            dataIndex: 'trabajador'
        },
    ];

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
        Axios.get(`/api/renovacion-fotocheck/resumen?desde=${form.desde}&hasta=${form.hasta}&empresa_id=${form.empresa_id}`)
            .then(res => {
                const data = res.data.data;

                setData(data.map(item => {
                    return {
                        ...item,
                        key: item.id
                    }
                }));

                const colores = Array.from(new Set(data.map(item => item.color))).sort();

                const columnColores = {
                    title: 'COLORES',
                    children: colores.map(color => {
                        return {
                            title: color,
                            dataIndex: color
                        }
                    })
                };

                setColumns([...initialStateColumns, columnColores]);

                const zonas = Array.from(new Set(data.map(item => item.zona_labor))).sort();

                const dataPorZona = zonas.map(zona => {
                    const tempData = data.filter(item => item.zona_labor === zona);

                    const solicitantes = Array.from(new Set(tempData.map(item => item.solicitante))).sort()

                    let cantColores = {};
                    for (const color of colores) {
                        cantColores[color] = tempData.filter(item => item.color === color).length;
                    }

                    return {
                        key: zona,
                        zona_labor: zona,
                        ...cantColores,
                        children: solicitantes.map(solicitante => {
                            const tempData2 = tempData.filter(item => item.solicitante === solicitante);

                            let cantColores = {};
                            for (const color of colores) {
                                cantColores[color] = tempData2.filter(item => item.color === color).length;
                            }

                            return {
                                key: solicitante,
                                solicitante,
                                zona_labor: zona,
                                ...cantColores,
                                children: tempData2.map(item => {
                                    return {
                                        ...item,
                                        key: item.rut,
                                    }
                                })
                            }
                        }),
                    }
                });


                setDataResumen(dataPorZona);
            })
            .catch(err => {})
            .finally(() => setLoading(false));
    }, [form]);

    return (
        <>
            <h4>Resumen de datos</h4>
            <br />
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
            <hr />
            <b style={{ fontSize: "13px" }}>
                Cantidad: {data.length} registros&nbsp;
                <button
                    className="btn btn-success btn-sm"
                    onClick={() => console.log('hi')}
                >
                    <i className="fas fa-file-excel" /> Exportar
                </button>
            </b>
            <br />
            <br />
            <TablaResumen
                loading={loading}
                data={dataResumen}
                columns={columns}
            />
        </>
    );
};
