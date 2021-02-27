import React, { useState, useEffect } from "react";
import { Card, DatePicker, notification, Select, Table, Tag } from "antd";
import moment from "moment";
import Axios from "axios";
import { TablaResumen } from "../components";
import { isNull, isNumber, isUndefined } from "lodash";

export const Datos = () => {
    const { usuario, submodule } = JSON.parse(sessionStorage.getItem("data"));

    const [selectedRowKeys, setSelectedRowKeys] = useState([]);
    const [selectedRowKeysCorte, setSelectedRowKeysCorte] = useState([]);

    const [reload, setReload] = useState(false);
    const [empresas, setEmpresas] = useState([]);
    const [form, setForm] = useState({
        desde: moment()
            .subtract(7, "days")
            .format("YYYY-MM-DD")
            .toString(),
        hasta: moment()
            .format("YYYY-MM-DD")
            .toString(),
        empresa_id: 9,
        tipo: "CON DESCUENTO"
    });
    const [data, setData] = useState([]);
    const [dataCorte, setDataCorte] = useState([]);
    const [dataResumen, setDataResumen] = useState([]);
    const [dataResumenCorte, setDataResumenCorte] = useState([]);
    const [loading, setLoading] = useState(false);
    const [columns, setColumns] = useState(initialStateColumns);
    const [columnsCorte, setColumnsCorte] = useState(initialStateColumns);

    const [ultimoCorte, setUltimoCorte] = useState(null);

    const initialStateColumns = [
        {
            title: "FUNDO",
            dataIndex: "zona_labor"
        },
        {
            title: "SOLICITANTE",
            dataIndex: "solicitante"
        },
        {
            title: "DNI/RUT",
            dataIndex: "rut"
        },
        {
            title: "APELLIDOS Y NOMBRES",
            dataIndex: "trabajador"
        },
        {
            title: "ESTADO",
            dataIndex: "estado",
            render: item =>
                !isUndefined(item) && !isNull(item) ? (
                    item === 0 ? (
                        <Tag color="default">SOLICITADO</Tag>
                    ) : (
                        <Tag color="blue">IMPRESO</Tag>
                    )
                ) : (
                    "-"
                )
        },
        {
            title: "ESTADO DOC.",
            dataIndex: "estado_documento",
            render: item =>
                !isUndefined(item) && !isNull(item) ? (
                    item == 0 ? (
                        <Tag color="default">PENDIENTE</Tag>
                    ) : (
                        <Tag color="blue">ENVIADO</Tag>
                    )
                ) : (
                    "-"
                )
        }
    ];

    useEffect(() => {
        function fetchEmpresas() {
            Axios.get("/api/empresa")
                .then(res => setEmpresas(res.data))
                .catch(err => {});
        }

        function fetchUltimoCorte() {
            Axios.get("/api/cortes-renovaciones-fotocheck/ultimo")
                .then(res => {
                    setUltimoCorte(res.data.data);
                })
                .catch(err => {
                    console.log(err);
                })
        }

        fetchEmpresas();
        fetchUltimoCorte();
    }, []);

    useEffect(() => {
        setLoading(true);
        Axios.get(
            `/api/renovacion-fotocheck/resumen?desde=${form.desde}&hasta=${form.hasta}&empresa_id=${form.empresa_id}&tipo=${form.tipo}`
        )
            .then(res => {
                const data = res.data.data;

                setData(
                    data.map(item => {
                        return {
                            ...item,
                            key: item.id
                        };
                    })
                );

                const colores = Array.from(
                    new Set(data.map(item => item.color))
                ).sort();

                const columnColores = {
                    title: "COLORES",
                    children: colores.map(color => {
                        return {
                            title: color,
                            dataIndex: color
                        };
                    })
                };

                setColumns([
                    ...initialStateColumns,
                    columnColores,
                    { title: "TOTAL", dataIndex: "total" }
                ]);

                const zonas = Array.from(
                    new Set(data.map(item => item.zona_labor))
                ).sort();

                const dataPorZona = zonas.map(zona => {
                    const tempData = data.filter(
                        item => item.zona_labor === zona
                    );

                    const solicitantes = Array.from(
                        new Set(tempData.map(item => item.solicitante))
                    ).sort();

                    let cantColores = {};
                    let totalPorFila = 0;
                    for (const color of colores) {
                        cantColores[color] = tempData.filter(
                            item => item.color === color
                        ).length;
                        totalPorFila += cantColores[color];
                    }

                    return {
                        key: zona,
                        zona_labor: zona,
                        ...cantColores,
                        total: totalPorFila,
                        children: solicitantes.map(solicitante => {
                            const tempData2 = tempData.filter(
                                item => item.solicitante === solicitante
                            );

                            let cantColores = {};
                            for (const color of colores) {
                                cantColores[color] = tempData2.filter(
                                    item => item.color === color
                                ).length;
                            }

                            return {
                                key: zona + " - " + solicitante,
                                solicitante,
                                zona_labor: zona,
                                ...cantColores,
                                children: tempData2.map(item => {
                                    return {
                                        ...item,
                                        key: item.id
                                    };
                                })
                            };
                        })
                    };
                });

                let cantColores = {};
                let totalPorFila = 0;
                for (const color of colores) {
                    cantColores[color] = data.filter(
                        item => item.color === color
                    ).length;
                    totalPorFila += cantColores[color];
                }

                dataPorZona.push({
                    key: "TOTAL",
                    zona_labor: "TOTAL",
                    ...cantColores,
                    total: totalPorFila
                });

                setDataResumen(dataPorZona);
            })
            .catch(err => {})
            .finally(() => setLoading(false));

        Axios.get(
            `/api/renovacion-fotocheck/resumen?desde=${form.desde}&hasta=${form.hasta}&empresa_id=${form.empresa_id}&tipo=${form.tipo}&corte=${true}`
        )
            .then(res => {
                const data = res.data.data;

                setDataCorte(
                    data.map(item => {
                        return {
                            ...item,
                            key: item.id
                        };
                    })
                );

                const colores = Array.from(
                    new Set(data.map(item => item.color))
                ).sort();

                const columnColores = {
                    title: "COLORES",
                    children: colores.map(color => {
                        return {
                            title: color,
                            dataIndex: color
                        };
                    })
                };

                setColumnsCorte([
                    ...initialStateColumns,
                    columnColores,
                    { title: "TOTAL", dataIndex: "total" }
                ]);

                const zonas = Array.from(
                    new Set(data.map(item => item.zona_labor))
                ).sort();

                const dataPorZona = zonas.map(zona => {
                    const tempData = data.filter(
                        item => item.zona_labor === zona
                    );

                    const solicitantes = Array.from(
                        new Set(tempData.map(item => item.solicitante))
                    ).sort();

                    let cantColores = {};
                    let totalPorFila = 0;
                    for (const color of colores) {
                        cantColores[color] = tempData.filter(
                            item => item.color === color
                        ).length;
                        totalPorFila += cantColores[color];
                    }

                    return {
                        key: zona,
                        zona_labor: zona,
                        ...cantColores,
                        total: totalPorFila,
                        children: solicitantes.map(solicitante => {
                            const tempData2 = tempData.filter(
                                item => item.solicitante === solicitante
                            );

                            let cantColores = {};
                            for (const color of colores) {
                                cantColores[color] = tempData2.filter(
                                    item => item.color === color
                                ).length;
                            }

                            return {
                                key: zona + " - " + solicitante,
                                solicitante,
                                zona_labor: zona,
                                ...cantColores,
                                children: tempData2.map(item => {
                                    return {
                                        ...item,
                                        key: item.id
                                    };
                                })
                            };
                        })
                    };
                });

                let cantColores = {};
                let totalPorFila = 0;
                for (const color of colores) {
                    cantColores[color] = data.filter(
                        item => item.color === color
                    ).length;
                    totalPorFila += cantColores[color];
                }

                dataPorZona.push({
                    key: "TOTAL",
                    zona_labor: "TOTAL",
                    ...cantColores,
                    total: totalPorFila
                });

                setDataResumenCorte(dataPorZona);
            })
            .catch(err => {})
            .finally(() => setLoading(false));
    }, [form, reload]);

    const handleExportar = () => {
        const headings = [
            "CODIGO",
            "FECHA SOLICITUD",
            "RUT",
            "TRABAJADOR",
            "FUNDO",
            "SOLICITANTE",
            "MOTIVO",
            "COLOR",
            "OBSERVACION"
        ];

        const d = data.map(item => {
            return {
                codigo: item.id,
                fecha_solicitud: item.fecha_solicitud,
                dni: item.rut,
                trabajador: item.trabajador,
                zona_labor: item.zona_labor,
                solicitante: item.solicitante,
                motivo: item.motivo,
                color: item.color,
                observacion: item?.observacion || ""
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
            link.download =
                "REGISTROS-FOTOCHECKS_" +
                form.desde +
                "_" +
                form.hasta +
                ".xlsx";
            link.click();
        });
    };

    const handleCortar = () => {
        const keys = selectedRowKeys.filter(key => isNumber(key));

        Axios.post("/api/cortes-renovaciones-fotocheck", {
            renovaciones_ids: keys,
            usuario_id: usuario.id
        })
            .then(res => {
                setReload(!reload);

                notification["success"]({
                    message: res.data.message
                });
            })
            .catch(err => {
                notification["error"]({
                    message: err.response.data.message
                });
            });
    };

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
                        <div className="col-md-4">
                            Tipo:
                            <br />
                            <Select
                                value={form.tipo}
                                showSearch
                                optionFilterProp="children"
                                filterOption={(input, option) =>
                                    option.children
                                        .toLowerCase()
                                        .indexOf(input.toLowerCase()) >= 0
                                }
                                onChange={e => setForm({ ...form, tipo: e })}
                                style={{
                                    width: "100%"
                                }}
                            >
                                {[
                                    { id: "CON DESCUENTO" },
                                    { id: "SIN DESCUENTO" }
                                ].map(e => (
                                    <Select.Option value={e.id} key={e.id}>
                                        {`${e.id}`}
                                    </Select.Option>
                                ))}
                            </Select>
                        </div>
                    </div>
                </form>
            </Card>
            <br />
            <hr />
            <br />
            {ultimoCorte ? (
                <>
                    <h4 style={{ textDecoration: 'underline' }}>Último Corte:</h4>
                    <b style={{ fontSize: "13px" }}>
                        Cantidad: {dataCorte.length} registros&nbsp;
                        <button
                            className="btn btn-success btn-sm mr-1"
                            onClick={handleExportar}
                        >
                            <i className="fas fa-file-excel" /> Exportar
                        </button>
                        <button
                            className="btn btn-primary btn-sm mr-1"
                            onClick={handleCortar}
                            disabled={selectedRowKeysCorte.length === 0}
                        >
                            <i className="fas fa-table" /> Realizar corte
                        </button>
                    </b>
                    <br />
                    <br />
                    <TablaResumen
                        loading={loading}
                        data={dataResumenCorte}
                        columns={columnsCorte}
                    />
                </>
            ) : (
                <>
                    <div className="alert alert-secondary" role="alert">
                        <b>No hay último corte disponible</b>
                    </div>
                </>
            )}
            <br />
            <h4 style={{ textDecoration: 'underline' }}>Pendientes</h4>
            <b style={{ fontSize: "13px" }}>
                Cantidad: {data.length} registros&nbsp;
                <button
                    className="btn btn-success btn-sm mr-1"
                    onClick={handleExportar}
                >
                    <i className="fas fa-file-excel" /> Exportar
                </button>
                <button
                    className="btn btn-primary btn-sm mr-1"
                    onClick={handleCortar}
                    disabled={selectedRowKeys.length === 0}
                >
                    <i className="fas fa-table" /> Realizar corte
                </button>
            </b>
            <br />
            <br />
            <TablaResumen
                loading={loading}
                data={dataResumen}
                columns={columns}
                selectedRowKeys={selectedRowKeys}
                setSelectedRowKeys={setSelectedRowKeys}
            />
        </>
    );
};
