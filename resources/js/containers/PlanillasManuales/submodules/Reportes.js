import React, { useState, useEffect } from 'react';
import { Button, Card, DatePicker } from 'antd';
import moment from 'moment';
import Axios from 'axios';
import { TablaReporte } from '../components';

export const Reportes = () => {

    const [loading, setLoading] = useState(false);
    const [filtro, setFiltro] = useState({
        fecha: moment().format('YYYY-MM-DD').toString(),
        empresa_id: 9,
    });
    const [registros, setRegistros] = useState([]);

    async function fetchRegistros() {
        setLoading(true);
        try {
            const { data: res} = await Axios.get(`/api/sqlsrv/marcaciones-android/registro?desde=${filtro.desde}&hasta=${filtro.hasta}&empresa_id=${filtro.empresa_id}`)
            setRegistros(res.data.map(item => {
                return {
                    ...item,
                    key: `${item['DNI']}_${item['FECHA']}`
                };
            }));
        } catch (err) {
            console.log(err);
        } finally {
            setLoading(false);
        }
    }

    return (
        <>
            <div className="mb-3">
                <h4>Reportes</h4>
            </div>
            <br />
            <Card>
                <div className="row">
                    <div className="col-md-4">
                        Desde - Hasta:
                        <br />
                        <DatePicker.RangePicker
                            placeholder={["Desde", "Hasta"]}
                            style={{ width: "100%" }}
                            onChange={(date, dateString) => {
                                setFiltro({
                                    ...filtro,
                                    desde: dateString[0],
                                    hasta: dateString[1]
                                });
                            }}
                            value={[moment(filtro.desde), moment(filtro.hasta)]}
                        />
                    </div>
                </div>
                <br />
                <div className="row">
                    <div className="col">
                        <Button onClick={fetchRegistros}>
                            Generar Reporte
                        </Button>
                    </div>
                </div>
            </Card>
            <br />
            <TablaReporte
                registros={registros}
                loading={loading}
            />
        </>
    );
}
