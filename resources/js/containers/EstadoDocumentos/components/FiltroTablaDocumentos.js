import React, { useState, useEffect } from 'react';

import { empresa } from '../../../data/default.json';
import {Select} from "antd";
import Axios from "axios";

export const FiltroTablaDocumentos = ({ reloadData, setReloadData, filter, setFilter }) => {

    const { usuario } = JSON.parse(sessionStorage.getItem('data'));

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

    const zonasBloqueadas = {
        rapel: [
            '50', '51', '52', '53', '56', '57', '58', '70', '80', '81', '90'
        ],
        verfrut: [
            '31', '40', '41', '50', '51', '52', '53', '54', '56', '57', '58', '59', '80', '81', '90'
        ]
    }

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
                                {
                                    usuario.estado_documentos === 2 ? (
                                        regimenes.map(e => (
                                            <Select.Option value={e.id} key={e.id}>
                                                {`${e.id} - ${e.name}`}
                                            </Select.Option>
                                        ))
                                    ) : (
                                        <>
                                            <Select.Option value={1} key={1}>
                                                {`${1} - Empleados Agrarios`}
                                            </Select.Option>
                                            <Select.Option value={3} key={3}>
                                                {`${3} - Obreros`}
                                            </Select.Option>
                                        </>
                                    )
                                }
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
                                {
                                    usuario.estado_documentos === 2 && (
                                        <Select.Option value={0} key={0}>
                                            {`${0} - TODOS`}
                                        </Select.Option>
                                    )
                                }
                                {
                                    usuario.estado_documentos === 2 ? (
                                        zonasLabores.map(e => (
                                            <Select.Option value={e.id} key={e.id}>
                                                {`${e.id} - ${e.name}`}
                                            </Select.Option>
                                        ))
                                    ) : (
                                        zonasLabores.map(z => {
                                            if (z.empresa_id == 9) {
                                                if (zonasBloqueadas.rapel.find(i => i == z.id)) {
                                                    return (
                                                        <Select.Option value={z.id} key={z.id}>
                                                            {`${z.id} - ${z.name}`}
                                                        </Select.Option>
                                                    )
                                                }
                                            } else {
                                                if (zonasBloqueadas.verfrut.find(i => i == z.id)) {
                                                    return (
                                                        <Select.Option value={z.id} key={z.id}>
                                                            {`${z.id} - ${z.name}`}
                                                        </Select.Option>
                                                    )
                                                }
                                            }
                                        })
                                    )
                                }
                            </Select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    );
}
