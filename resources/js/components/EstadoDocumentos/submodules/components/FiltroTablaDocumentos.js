import React, { useState, useEffect } from 'react';

import { empresa } from '../../../../data/default.json';
import {Select} from "antd";
import Axios from "axios";

export const FiltroTablaDocumentos = ({ reloadData, setReloadData, filter, setFilter }) => {

    const estados = [
        {
            id: 'NO FIRMADO',
            name: 'NO FIRMADO',
        },
        {
            id: 'FIRMADO CONFORME',
            name: 'FIRMADO CONFORME'
        }
    ];

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
        <div className="card">
            <div className="card-body">
                <form>
                    <div className="form-row">
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
                            Estado:<br />
                            <Select
                                value={filter.estado} showSearch
                                style={{ width: '100%' }} optionFilterProp="children"
                                filterOption={(input, option) =>
                                    option.children
                                        .toLowerCase()
                                        .indexOf(input.toLowerCase()) >= 0
                                }
                                onChange={e => setFilter({ ...filter, estado: e })}
                            >
                                {estados.map(e => (
                                    <Select.Option value={e.id} key={e.id}>
                                        {`${e.name}`}
                                    </Select.Option>
                                ))}
                            </Select>
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
                                {zonasLabores.map(e => (
                                    <Select.Option value={e.id} key={e.id}>
                                        {`${e.id} - ${e.name}`}
                                    </Select.Option>
                                ))}
                            </Select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    );
}
