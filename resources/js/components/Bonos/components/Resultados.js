import React, { useState } from "react";
import { Table, DatePicker, Button, notification, Spin, Tabs } from "antd";
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
            .finally(() => setLoading(false));
    };

    const handleExport = () => {
        Axios({
            method: 'POST',
            url: '/api/bonos/exportar',
            data: {
                actividades: actividades,
                resultados: resultados
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
                <div className="col-md-4">
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
                <div className="col-md-4">
                    <Button
                        type="primary"
                        size="small"
                        onClick={() => getData()}
                        loading={loading}
                    >
                        <i className="fas fa-play"></i>&nbsp;&nbsp;Ejecutar
                    </Button>
                </div>
                <div className="col-md-4 offset-col-md-4">
                    <button
                        className="btn btn-success"
                        onClick={() => handleExport()}
                        disabled={
                            actividades.length === 0 || resultados.length === 0
                        }
                    >
                        <i className="far fa-file-excel"></i> Exportar
                    </button>
                </div>
            </div>
            <Spin spinning={loading}>
                <Tabs defaultActiveKey="1">
                    <Tabs.TabPane tab="Actividades" key="1">
                        <Table
                            size="small"
                            pagination={{ pageSize: 50 }}
                            dataSource={actividades}
                            columns={columnsA}
                            scroll={{ x: 1500 }}
                            bordered
                        />
                    </Tabs.TabPane>
                    <Tabs.TabPane tab="Reporte Publicar" key="2">
                        <Table
                            size="small"
                            pagination={{ pageSize: 50 }}
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
