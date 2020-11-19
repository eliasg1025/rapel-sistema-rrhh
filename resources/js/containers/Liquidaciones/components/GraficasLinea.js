import React, { useState, useEffect } from 'react';
import moment from 'moment';
import { Collapse, Select, DatePicker } from 'antd';
import { Line } from 'react-chartjs-2';

import {empresa} from "../../../data/default.json";
import Axios from 'axios';

export const GraficaLinea = () => {

    const [cantidadPagosPorDia, setCantidadPagosPorDia] = useState([]);
    const [filter, setFilter] = useState({
        desde: moment().subtract(1, 'M').format('YYYY-MM-DD').toString(),
        hasta: moment().add(7, 'days').format('YYYY-MM-DD').toString(),
        empresa_id: 9,
    });

    const data = () => {
        return {
            labels: cantidadPagosPorDia.map(e => e.dia),
            datasets: [
                {
                    label: '# de Pagos de LIQUIDACIÓN',
                    data: cantidadPagosPorDia.map(e => e.cantidad),
                    backgroundColor:  'rgba(54, 162, 235, 0.2)',
                    borderColor:  'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                },
                {
                    label: '# de Pagos de UTILIDADES',
                    data: [],
                    backgroundColor:  'rgba(255, 99, 132, 0.2)',
                    borderColor:  'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                }
            ]
        }
    }

    const options = () => {
        return {
            responsive: true,
            title: {
                display: true,
                text: 'Cantidad de pagos por día'
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    }

    useEffect(() => {
        function fetchCantidadPagos() {
            Axios.get(`/api/pagos/cantidad-pagos-por-dia/${filter.empresa_id}?desde=${filter.desde}&hasta=${filter.hasta}`)
                .then(res => {
                    //console.log(res);
                    setCantidadPagosPorDia(res.data);
                })
                .catch(err => {
                    console.error(err);
                })
        }

        fetchCantidadPagos();
    }, [filter])

    return (
        <>
            <div className="row">
                <div className="col">
                    <Collapse ghost>
                        <Collapse.Panel header="Filtros">
                            <div className="card">
                                <div className="card-body">
                                    <div className="row">
                                        <div className="col-md-3">
                                            Empresa:<br />
                                            <Select
                                                value={filter.empresa_id} showSearch
                                                style={{ width: '100%' }} optionFilterProp="children"
                                                filterOption={(input, option) =>
                                                    option.children
                                                        .toLowerCase()
                                                        .indexOf(input.toLowerCase()) >= 0
                                                }
                                                onChange={e => setFilter({ ...filter, empresa_id: e })}
                                            >
                                                {empresa.map(e => (
                                                    <Select.Option value={e.id} key={e.id}>
                                                        {`${e.id} - ${e.name}`}
                                                    </Select.Option>
                                                ))}
                                            </Select>
                                        </div>
                                        <div className="col-md-3">
                                            Desde - Hasta:<br />
                                            <DatePicker.RangePicker
                                                style={{ width: '100%' }}
                                                placeholder={['Desde', 'Hasta']}
                                                allowClear={false}
                                                onChange={(date, dateString) => {
                                                    setFilter({
                                                        ...filter,
                                                        desde: dateString[0],
                                                        hasta: dateString[1],
                                                    });
                                                }}
                                                value={[moment(filter.desde), moment(filter.hasta)]}
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </Collapse.Panel>
                    </Collapse>
                </div>
            </div>
            <div className="row">
                <div className="col">
                    <Line data={data()} options={options()} height={100} />
                </div>
            </div>
        </>
    );
}
