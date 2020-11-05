import React, { useState, useEffect } from 'react';
import { Bar } from 'react-chartjs-2'

import Axios from 'axios';
import {Collapse, DatePicker, Select} from "antd";
import {empresa} from "../../../data/default.json";
import moment from "moment";

export const GraficoBarrasDocumentos = () => {

    const [zonas, setZonas] = useState([]);

    const [filter, setFilter] = useState({
        empresa_id: 9,
        periodo: moment().subtract(1, 'M').format('YYYY-MM').toString()
    });

    const data = () => {
        return {
            labels: zonas.map(e => `${e.zona_labor} (${e.procentaje_firmados} %)`),
            datasets: [
                {
                    label: ['No Firmados'],
                    data: zonas.map(e => e.no_firmados),
                    backgroundColor:  '#caf270',
                    borderWidth: 1
                },
                {
                    label: ['Firmado'],
                    data: zonas.map(e => e.firmados),
                    backgroundColor:  '#45c490',
                    borderWidth: 1,
                }
            ]
        }
    }

    const options = () => {
        return {
            title: {
                display: true,
                text: 'Cantidad de documentos por área (% firmados)'
            },
            scales: {
                yAxes: [{
                    stacked: true,
                    ticks: {
                        beginAtZero: true
                    }
                }],
                xAxes: [{
                    stacked: true,
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    }

    useEffect(() => {
        Axios.get(`/api/documentos-turecibo/cantidad-firmados-zona-labor?empresa_id=${filter.empresa_id}&periodo=${filter.periodo}`)
            .then(res => {
                console.log(res.data);
                setZonas(res.data);
            })
            .catch(err => console.error(err))
    }, [filter]);

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
                                            Período:<br />
                                            <DatePicker
                                                style={{ width: '100%' }}
                                                placeholder={'Período'}
                                                allowClear={false}
                                                picker="month"
                                                onChange={(date, dateString) => setFilter({ ...filter, periodo: dateString })}
                                                value={moment(filter.periodo)}
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
                    <Bar
                        data={data()} options={options()} height={100}
                    />
                </div>
            </div>
        </>

    );
}
