import React, { useState, useEffect } from 'react';
import { Select, message } from 'antd';
import Axios from 'axios';

import { empresa } from '../../../../data/default.json';
import { TablaHabilitados } from './TablaHabilitados';
import Swal from 'sweetalert2';
import { SubidaImportacion } from './SubidaImportacion';

export const HabilitarOficios = () => {
    const [oficios, setOficios] = useState([]);
    const [oficiosSctr, setOficiosSctr] = useState([]);
    const [reloadData, setReloadData] = useState(false);
    const [form, setForm] = useState({
        empresa_id: 9,
        oficio_id: '',
    });

    useEffect(() => {
        setForm({ ...form, oficio_id: '' });
        fetchOficios();
    }, [form.empresa_id]);

    useEffect(() => {
        fetchOficiosSctr();
    }, [reloadData]);

    const fetchOficiosSctr = () => {
        Axios.get('/api/oficio/get-with-sctr')
            .then(res => {
                setOficiosSctr(res.data.map(o => {
                    return {
                        ...o,
                        key: o.id
                    }
                }));
            })
            .catch(err => console.error(err));
    }

    const fetchOficios = () => {
        Axios.get(`http://192.168.60.16/api/oficio/${form.empresa_id}`)
            .then(res => setOficios(res.data.data))
            .catch(err => console.error(err));
    }

    const handleDelete = id => {
        console.log(id);
        Swal.fire({
            title: '¿Deseas deshabilitar este registro?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, borrarlo',
            cancelButtonText: 'Cancelar'
        })
            .then(result => {
                if (result.value) {
                    Axios.put(`/api/oficio/${id}/disable-sctr`)
                        .then(res => {
                            message['success']({
                                content: res.data.message
                            });
                            setReloadData(!reloadData);
                        })
                        .catch(err => console.log(err));
                }
            });

    }

    const handleSubmit = e => {
        e.preventDefault();
        const oficio = oficios.find(o => parseInt(o.id) === parseInt(form.oficio_id) && parseInt(o.empresa_id) === parseInt(form.empresa_id));
        oficio.sctr = 1;

        Axios.post('/api/oficio', { ...oficio })
            .then(res => {
                message['success']({
                    content: res.data.message
                });
                setForm({ ...form, oficio_id: '' })
                setReloadData(!reloadData);
            })
            .catch(err => console.error(err));
    }

    const handleImport = e => {
        e.preventDefault();
        console.log('import');
    }

    const columns = [
        {
            title: 'Empresa',
            dataIndex: 'empresa'
        },
        {
            title: 'Oficio',
            dataIndex: 'oficio'
        },
        {
            title: '',
            render: (_, record) => (
                <button className="btn btn-danger btn-sm" onClick={() => handleDelete(record.id)}>
                    <i className="far fa-times-circle"></i>
                </button>
            )
        }
    ];

    return (
        <>
            <h5>Habilitar Oficios</h5>
            <div className="row">
                <div className="col">
                    <div className="card">
                        <div className="card-body">
                            <form onSubmit={handleSubmit}>
                                <div className="form-row">
                                    <div className="col-md-6">
                                        Empresa:<br />
                                        <Select
                                            value={form.empresa_id} showSearch
                                            style={{ width: '100%' }} optionFilterProp="children"
                                            filterOption={(input, option) =>
                                                option.children
                                                    .toLowerCase()
                                                    .indexOf(input.toLowerCase()) >= 0
                                            }
                                            onChange={e => setForm({ ...form, empresa_id: e })}
                                        >
                                            {empresa.map(e => (
                                                <Select.Option value={e.id} key={e.id}>
                                                    {`${e.id} - ${e.name}`}
                                                </Select.Option>
                                            ))}
                                        </Select>
                                    </div>
                                    <div className="col-md-6">
                                        Oficio:<br />
                                        <Select
                                            value={form.oficio_id} showSearch
                                            style={{ width: '100%' }} optionFilterProp="children"
                                            filterOption={(input, option) =>
                                                option.children
                                                    .toLowerCase()
                                                    .indexOf(input.toLowerCase()) >= 0
                                            }
                                            onChange={e => setForm({ ...form, oficio_id: e })}
                                        >
                                            {oficios.map(e => (
                                                <Select.Option value={e.id} key={e.id}>
                                                    {`${e.id} - ${e.name}`}
                                                </Select.Option>
                                            ))}
                                        </Select>
                                    </div>
                                </div>
                                <br />
                                <div className="form-row">
                                    <div className="col">
                                        <button type="submit" className="btn btn-success">
                                            Habilitar Oficio
                                        </button>
                                        <button type="button" className="btn btn-primary" data-toggle="modal" data-target="#importacion">
                                            <i className="fas fa-file-import"></i> Importación
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <br />
            <div className="row">
                <div className="col">
                    <TablaHabilitados
                        columns={columns}
                        data={oficiosSctr}
                    />
                </div>
            </div>

            <div className="modal fade" id="importacion">
                <div className="modal-dialog">
                    <div className="modal-content">
                        <div className="modal-header">
                            <h5 className="modal-title">Importación</h5>
                            <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div className="modal-body">
                            <SubidaImportacion
                                handleImport={handleImport}
                            />
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
