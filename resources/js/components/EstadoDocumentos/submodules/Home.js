import React, { useState, useEffect } from 'react';
import { DatePicker, Select } from 'antd';
import moment from 'moment';

import { GraficoDocumentos } from './components/GraficoDocumentos';
import { BuscarTrabajador } from './components/BuscarTrabajador';
import Axios from 'axios';

import { empresa } from '../../../data/default.json';

export const Home = () => {

    const [filter, setFilter] = useState({
        desde: moment().subtract(1, 'M').format('YYYY-MM-DD').toString(),
        hasta: moment().format('YYYY-MM-DD').toString(),
        empresa_id: 9,
        regimen_id: 1,
        zona_labor_id: 0,
    });

    const [regimenes, setRegimenes] = useState([]);
    const [zonasLabores, setZonasLabores] = useState([]);

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

    return (
        <>
            <h4>Estado de Documentos - TU RECIBO</h4>
            <br />
            <div className="row">
                <div className="col">
                    <GraficoDocumentos
                        filter={filter}
                    />
                </div>
            </div>
            <br />
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
        </>
    );
}
