import React, { useState, useEffect } from 'react';
import { notification, Select } from 'antd';
import Axios from 'axios';

export const CreateUsuarioZonaForm = ({ reload, setReload }) => {

    const [zonasLabor, setZonasLabor] = useState([]);
    const [usuarios, setUsuarios] = useState([]);
    const [form, setForm] = useState({
        usuario_id: "",
        zona_labor: ""
    });

    useEffect(() => {
        Axios.get('/api/zona-labor')
            .then(res => {
                setZonasLabor(res.data);
            })
            .catch(err => {
                console.error(err);
            });


        Axios.get('/api/modulos/16/usuarios?rol=ANALISTA DE GESTION')
            .then(res => {
                setUsuarios(res.data.data);
            })
            .catch(err => {
                console.error(err);
            });
    }, []);

    const asignarZona = () => {

        Axios.post('/api/grupos-finiquitos/usuarios-zonas', form)
            .then(res => {
                const { data, message } = res.data;
                setReload(!reload);
                notification['success']({
                    message
                });
            })
            .catch(err => {
                console.log(err);
                notification['error']({
                    message: err.response.data.message
                });
            });
    }

    return (
        <div>
            <div className="row">
                <div className="col-md-4">
                    Usuarios:<br />
                    <Select
                        value={form?.usuario_id || ''} showSearch
                        style={{ width: '100%' }} optionFilterProp="children"
                        filterOption={(input, option) =>
                            option.children
                                .toLowerCase()
                                .indexOf(input.toLowerCase()) >= 0
                        }
                        onChange={e => setForm({ ...form, usuario_id: e })}
                        size="small"
                    >
                        {usuarios.map(e => (
                            <Select.Option value={e.usuario_id} key={e.usuario_id}>
                                {`${e.usuario.trabajador.apellido_paterno} ${e.usuario.trabajador.apellido_materno} ${e.usuario.trabajador.nombre}`}
                            </Select.Option>
                        ))}
                    </Select>
                </div>
                <div className="col-md-4">
                    Zona Labor:<br />
                    <Select
                        value={form?.zona_labor || ''} showSearch
                        style={{ width: '100%' }} optionFilterProp="children"
                        filterOption={(input, option) =>
                            option.children
                                .toLowerCase()
                                .indexOf(input.toLowerCase()) >= 0
                        }
                        onChange={e => setForm({ ...form, zona_labor: e })}
                        size="small"
                    >
                        {zonasLabor.map(e => (
                            <Select.Option value={e.name} key={e.name}>
                                {`${e.name}`}
                            </Select.Option>
                        ))}
                    </Select>
                </div>
            </div>
            <div className="row mt-4">
                <div className="col">
                    <button
                        type="button"
                        className="btn btn-primary btn-sm btn-block"
                        onClick={asignarZona}
                    >
                        Asignar
                    </button>
                </div>
            </div>
        </div>
    );
}
