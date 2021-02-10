import React, { useState, useEffect } from 'react';
import { notification, message } from 'antd';
import moment from 'moment';
import Axios from 'axios';

import BuscarTrabajador from '../../shared/BuscarTrabajador';
import { TablaRegistros, Datos } from '../components';

const initialState = {
    fecha_solicitud: moment().format('YYYY-MM-DD').toString(),
    empresa_id: '',
    regimen_id: '',
    zona_labor_id: '',
    motivo_perdida_fotocheck_id: '',
    color_fotocheck_id: '',
}

export const Inicio = () => {

    const { usuario, submodule } = JSON.parse(sessionStorage.getItem("data"));

    const [trabajador, setTrabajador] = useState(null);
    const [contratoActivo, setContratoActivo] = useState(null);
    const [form, setForm] = useState({...initialState});
    const [data, setData] = useState([]);
    const [reloadDatos, setReloadDatos] = useState(false);

    const [filtro, setFiltro] = useState({
        desde: moment().subtract(7, 'days').format('YYYY-MM-DD').toString(),
        hasta: moment().format('YYYY-MM-DD').toString(),
        usuario_carga_id: '',
        tipo: 'TODOS'
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        console.log(form);

        Axios.post('/api/renovacion-fotocheck', {
            ...form,
            usuario_id: usuario.id,
            trabajador
        })
            .then(res => {
                setReloadDatos(!reloadDatos);
                notification['success']({
                    message: res.data.message
                });
            })
            .catch(err => {
                notification['error']({
                    message: err.response.data.message
                });
            });
    }

    const handleEliminar = (id) => {
        Axios.delete(`/api/renovacion-fotocheck/${id}`)
            .then(res => {
                notification['success']({
                    message: res.data.message
                });

                setReloadDatos(!reloadDatos);
            })
            .catch(err => {

            });
    }

    useEffect(() => {
        Axios.get(`/api/renovacion-fotocheck?desde=${filtro.desde}&hasta=${filtro.hasta}&usuario_id=${usuario.id}&tipo=${filtro.tipo}`)
            .then(res => {
                message['success']({
                    content: 'Se encontraron ' + res.data.data.length + ' registros'
                });

                setData(res.data.data.map(item => {
                    return {
                        ...item,
                        key: item.id
                    }
                }));
            })
            .catch(err => {
                console.error(err);
            });
    }, [reloadDatos, filtro]);

    return (
        <>
            <div className="mb-3">
                <h4>Registro de Fotochecks</h4>
            </div>
            <BuscarTrabajador
                setTrabajador={setTrabajador}
                setContratoActivo={setContratoActivo}
                activo={true}
            />
            <Datos
                trabajador={trabajador}
                contratoActivo={contratoActivo}
                form={form}
                setForm={setForm}
                handleSubmit={handleSubmit}
            />
            <hr />
            <TablaRegistros
                data={data}
                setData={setData}
                filtro={filtro}
                setFiltro={setFiltro}
                handleEliminar={handleEliminar}
            />
        </>
    );
}
