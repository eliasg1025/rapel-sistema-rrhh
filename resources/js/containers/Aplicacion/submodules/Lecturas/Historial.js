import React, { useEffect, useState } from 'react';
import { DatePicker, Card, Table, Tooltip, notification } from 'antd';
import moment from 'moment';
import Axios from 'axios';

export const Historial = () => {

    const [loading, setLoading] = useState(false);
    const [filtro, setFiltro] = useState({
        desde: moment()
            .format("YYYY-MM-DD")
            .toString(),
        hasta: moment()
            .format("YYYY-MM-DD")
            .toString()
    });
    const [lecturas, setLecturas] = useState([]);

    const columns = [
        {
            title: 'Fecha',
            dataIndex: 'fecha'
        },
        {
            title: 'Hora',
            dataIndex: 'hora'
        },
        {
            title: 'Usuario',
            dataIndex: 'username',
            render: (value, record) => (
                <Tooltip placement="top" title={`${record.usuario}`}>
                    <span style={{ textDecoration: 'underline', color: '#1890FF' }}>{value}</span>
                </Tooltip>
            )
        },
        {
            title: 'Pago',
            dataIndex: 'pago'
        },
        {
            title: 'RUT consultado',
            dataIndex: 'rut'
        },
        {
            title: 'Trabajador consultado',
            dataIndex: 'trabajador'
        },
        {
            title: 'Empresa',
            dataIndex: 'empresa'
        },
    ];

    useEffect(() => {
        setLoading(true);
        Axios.get(`http://209.151.144.74/api/lecturas-sueldos?desde='${filtro.desde}'&hasta='${filtro.hasta}'`)
            .then(res => {
                //console.log(res);
                setLecturas(res.data.map(item => {
                    return {
                        ...item,
                        key: item.id
                    }
                }));
            })
            .catch(err => {
                console.log(err);
            })
            .finally(() => setLoading(false));
    }, [filtro]);

    return (
        <>
            <h4>Historial de consultas</h4>
            <br />
            <div className="row">
                <div className="col-md-6">
                    <Card>
                        <form>
                            <div className="row">
                                <div className="col-md-6">
                                    Desde - Hasta:<br />
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
                        </form>
                    </Card>

                </div>
                <div className="col-md-6">
                    <TablaLecturasPorDia />
                </div>
            </div>
            <br />
            <Table
                bordered
                loading={loading}
                pagination={{ size: 5 }}
                size="small"
                dataSource={lecturas}
                columns={columns}
            />
        </>
    );
}


const TablaLecturasPorDia = () => {

    const [loading, setLoading] = useState(false);
    const [lecturasPorDia, setLecturasPorDia] = useState([]);

    const columns = [
        {
            title: 'Fecha',
            dataIndex: 'fecha_lectura',
        },
        {
            title: 'Cantidad',
            dataIndex: 'cantidad'
        }
    ];

    useEffect(() => {
        setLoading(false);
        Axios.get(`http://209.151.144.74/api/lecturas-sueldos/get-cantidad-por-dia`)
            .then(res => {
                setLecturasPorDia(res.data.map(item => {
                    return {
                        ...item,
                        key: item.fecha_lectura
                    }
                }));
            })
            .catch(err => {
                notification['error']({
                    message: 'Error al obtener las lecturas por dia'
                });
            })
            .finally(() => setLoading(false));
    }, []);

    return (
        <Table
            bordered
            size="small"
            loading={loading}
            dataSource={lecturasPorDia}
            columns={columns}
        >

        </Table>
    );
}
