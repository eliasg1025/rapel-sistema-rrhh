import React, { useState } from "react";
import { Table, DatePicker, Button, notification, Spin, Tabs, Space } from "antd";
import moment from "moment";
import Axios from "axios";

export const Resultados = ({ bono }) => {
    const [loading, setLoading] = useState(false);
    const [filtro, setFiltro] = useState({
        desde: moment()
            .format("YYYY-MM-DD")
            .toString(),
        hasta: moment()
            .format("YYYY-MM-DD")
            .toString()
    });
    const [columnsA, setColumnsA] = useState([]);
    const [columnsR, setColumnsR] = useState([]);

    const [actividades, setActividades] = useState([]);
    const [resultados, setResultados] = useState([]);

    const [data, setData] = useState([]);

    const [dataToExport, setDataToExport] = useState(null);
    const [columns, setColumns] = useState(initialStateColumns);

    const initialStateColumns = [
        {
            title: "FUNDO",
            dataIndex: "zona_labor"
        }
    ];

    const getData = () => {
        setLoading(true);
        Axios.get(
            `/api/bonos/${bono.id}/planilla?desde=${filtro.desde}&hasta=${filtro.hasta}`
        )
            .then(res => {
                const { data, message } = res.data;

                notification["success"]({
                    message: message
                });

                const dias = Array.from(
                    new Set(data.rows.map(item => item.dia))
                ).sort();

                const columnDias = {
                    title: "DIAS",
                    children: dias.map(color => {
                        return {
                            title: color,
                            dataIndex: color
                        };
                    })
                };

                setColumns([...initialStateColumns, columnDias]);

                const zonas = Array.from(
                    new Set(data.rows.map(item => item.zona_labor))
                ).sort();

                const dataPorZona = zonas.map(zona => {
                    const tempData = data.rows.filter(
                        item => item.zona_labor === zona
                    );

                    let sumValorPorDia = {};
                    for (const dia of dias) {
                        // sumValorPorDia[dia] = tempData.filter(item => item.dia === dia).length;
                        sumValorPorDia[dia] = Math.round(tempData.filter(item => item.dia === dia).reduce((acc, cur) => acc + cur.valor, 0) * 100) / 100;
                    }

                    return {
                        key: zona,
                        zona_labor: zona,
                        ...sumValorPorDia
                    }
                });

                setData(dataPorZona);

                setDataToExport(data);

                setActividades(
                    data.output.map(item => {
                        return {
                            ...item,
                            key: item.codigo,
                            ...item.fechas
                        };
                    })
                );
                setResultados(
                    data.output.map(item => {
                        return {
                            ...item,
                            key: item.codigo,
                            ...item.resultado
                        };
                    })
                );
                setColumnsA(data.info.columnas.actividades);
                setColumnsR(data.info.columnas.resultados);
            })
            .catch(err => {
                console.error(err);
                notification["error"]({
                    message: err.response.message
                });
            })
            .finally(() => {
                setLoading(false);
            });
    };

    const handleExport = () => {
        Axios({
            method: 'POST',
            url: `/api/bonos/exportar`,
            data: {
                ...dataToExport,
                bono_id: bono.id,
                desde: filtro.desde,
                hasta: filtro.hasta
            },
            responseType: 'blob'
        })
            .then(res => {
                console.log(res);
                let blob = new Blob([res.data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' })
                let link = document.createElement('a')
                link.href = window.URL.createObjectURL(blob)
                link.download = `${bono.name}-${filtro.desde}-${filtro.hasta}.xlsx`
                link.click();
            })
            .catch(err => {
                console.log(err);
                notification['error']({
                    message: 'Error al descargar el excel'
                });
            });
    }

    return (
        <>
            <div className="row">
                <div className="col-md-4 col-sm-6">
                    <DatePicker.RangePicker
                        allowClear={false}
                        style={{ width: "100%" }}
                        placeholder={["Desde", "Hasta"]}
                        onChange={(date, dateString) => {
                            setFiltro({
                                ...filtro,
                                desde: dateString[0],
                                hasta: dateString[1]
                            });
                        }}
                        value={[moment(filtro.desde), moment(filtro.hasta)]}
                        size="small"
                    />
                </div>
            </div>
            <br />
            <div className="row">
                <div className="col-md-12">
                    <button
                        onClick={() => getData()}
                        className="btn btn-primary"
                        disabled={loading}
                    >
                        <i className="fas fa-play"></i>&nbsp;&nbsp;Ejecutar
                    </button>
                    <button
                        className="btn btn-export mr-3"
                        onClick={() => handleExport()}
                        disabled={
                            actividades.length === 0 || resultados.length === 0
                        }
                    >
                        <i className="far fa-file-excel"></i>&nbsp;&nbsp;Exportar
                    </button>
                </div>
            </div>
            <Spin spinning={loading} tip="Generando Planilla de Bonos">
                <Tabs defaultActiveKey="1">
                    <Tabs.TabPane tab="Resumen" key="1">
                        <Table
                            size="small"
                            dataSource={data}
                            columns={columns}
                            scroll={{ x: 1100 }}
                            bordered
                        />
                    </Tabs.TabPane>
                    <Tabs.TabPane tab="Actividades" key="2">
                        <Table
                            size="small"
                            dataSource={actividades}
                            columns={columnsA}
                            scroll={{ x: 1500 }}
                            bordered
                        />
                    </Tabs.TabPane>
                    <Tabs.TabPane tab="Reporte Publicar" key="3">
                        <Table
                            size="small"
                            dataSource={resultados}
                            columns={columnsR}
                            scroll={{ x: 1500 }}
                            bordered
                        />
                    </Tabs.TabPane>
                </Tabs>
            </Spin>
        </>
    );
};
