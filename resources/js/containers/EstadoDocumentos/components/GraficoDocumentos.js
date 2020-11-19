import React, { useState, useEffect } from 'react';
import { Line } from 'react-chartjs-2'

import moment from 'moment';
import Axios from 'axios';
import {Collapse, DatePicker, Select} from "antd";
import {empresa} from "../../../data/default.json";

export const GraficoDocumentos = () => {

    const [regimenes, setRegimenes] = useState([]);
    const [zonasLabores, setZonasLabores] = useState([]);


    const [dias, setDias] = useState([]);
    const [firmasBoletas, setFirmasBoletas] = useState([]);
    const [firmasProrrogas, setFirmasProrrogas] = useState([]);

    const [filter, setFilter] = useState({
        desde: moment().subtract(1, 'M').format('YYYY-MM-DD').toString(),
        hasta: moment().format('YYYY-MM-DD').toString(),
        empresa_id: 9,
        regimen_id: 1,
        zona_labor_id: 0,
        periodo: moment().format('YYYY-MM').toString()
    });


    useEffect(() => {
        Axios.get('http://192.168.60.16/api/regimen')
            .then(res => {
                setRegimenes(res.data.data);
            })
            .catch(err => {
                console.error(err);
            });
    }, []);

    useEffect(() => {
        if (filter.empresa_id !== '') {
            Axios.get(`http://192.168.60.16/api/zona-labor/${filter.empresa_id}`)
                .then(res => {
                    setZonasLabores(res.data.data);
                })
                .catch(err => {
                    console.error(err);
                });
        }

    }, [filter.empresa_id]);

    const getDates = (startDate, stopDate) => {
        var dateArray = [];
        var currentDate = moment(startDate);
        var stopDate = moment(stopDate);
        while (currentDate <= stopDate) {
            dateArray.push( moment(currentDate).format('YYYY-MM-DD') )
            currentDate = moment(currentDate).add(1, 'days');
        }
        return dateArray;
    }

    const data = () => {
        return {
            labels: dias,
            datasets: [
                {
                    label: '# de Firmas BOLETAS',
                    data: firmasBoletas,
                    backgroundColor:  'rgba(54, 162, 235, 0.2)',
                    borderColor:  'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                },
                {
                    label: '# de Firmas PRORROGAS',
                    data: firmasProrrogas,
                    backgroundColor:  'rgba(255, 99, 132, 0.2)',
                    borderColor:  'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        }
    }

    const options = () => {
        return {
            responsive: true,
            title: {
                display: true,
                text: 'Cantidad de firmas por día'
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
        Axios.get(`/api/documentos-turecibo/cantidad-firmados-dia?tipo_documento_turecibo_id=${2}&desde=${filter.desde}&hasta=${filter.hasta}&empresa_id=${filter.empresa_id}&regimen_id=${filter.regimen_id}&zona_labor_id=${filter.zona_labor_id}&periodo=${filter.periodo}`)
            .then(res => {
                const { dias, cantidades } = res.data;

                setDias(dias);
                setFirmasBoletas(cantidades);
            })
            .catch(err => console.error(err))

        Axios.get(`/api/documentos-turecibo/cantidad-firmados-dia?tipo_documento_turecibo_id=${1}&desde=${filter.desde}&hasta=${filter.hasta}&empresa_id=${filter.empresa_id}&regimen_id=${filter.regimen_id}&zona_labor_id=${filter.zona_labor_id}&periodo=${filter.periodo}`)
            .then(res => {
                const { dias, cantidades } = res.data;

                setFirmasProrrogas(cantidades);
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
                                        {/*
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
                                        */}
                                        <div className="col-md-3">
                                            Régimen:<br />
                                            <Select
                                                value={filter.regimen_id} showSearch
                                                style={{ width: '100%' }} optionFilterProp="children"
                                                filterOption={(input, option) =>
                                                    option.children
                                                        .toLowerCase()
                                                        .indexOf(input.toLowerCase()) >= 0
                                                }
                                                onChange={e => setFilter({ ...filter, regimen_id: e })}
                                            >
                                                <Select.Option value={0} key={0}>
                                                    {`${0} - Todos`}
                                                </Select.Option>
                                                {regimenes.map(e => (
                                                    <Select.Option value={e.id} key={e.id}>
                                                        {`${e.id} - ${e.name}`}
                                                    </Select.Option>
                                                ))}
                                            </Select>
                                        </div>
                                        <div className="col-md-3">
                                            Zona Labor:<br />
                                            <Select
                                                value={filter.zona_labor_id} showSearch
                                                style={{ width: '100%' }} optionFilterProp="children"
                                                filterOption={(input, option) =>
                                                    option.children
                                                        .toLowerCase()
                                                        .indexOf(input.toLowerCase()) >= 0
                                                }
                                                onChange={e => setFilter({ ...filter, zona_labor_id: e })}
                                            >
                                                <Select.Option value={0} key={0}>
                                                    {`${0} - TODOS`}
                                                </Select.Option>
                                                {zonasLabores.map(e => (
                                                    <Select.Option value={e.id} key={e.id}>
                                                        {`${e.id} - ${e.name}`}
                                                    </Select.Option>
                                                ))}
                                            </Select>
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
    )
}
