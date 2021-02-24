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
    observacion: '',
}

export const Inicio = () => {

    const { usuario, submodule } = JSON.parse(sessionStorage.getItem("data"));

    const [trabajador, setTrabajador] = useState(null);
    const [contratoActivo, setContratoActivo] = useState(null);
    const [form, setForm] = useState({...initialState});
    const [data, setData] = useState([]);
    const [reloadDatos, setReloadDatos] = useState(false);
    const [loading, setLoading] = useState(false);

    const [filtro, setFiltro] = useState({
        desde: moment().subtract(7, 'days').format('YYYY-MM-DD').toString(),
        hasta: moment().format('YYYY-MM-DD').toString(),
        usuario_carga_id: '',
        tipo: 'TODOS',
        rut: '',
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
                const data = res.data.data;
                setReloadDatos(!reloadDatos);

                setForm({ ... initialState });
                setTrabajador(null);
                setContratoActivo(null);

                if (data.motivo.costo > 0) {
                    window.open(`/ficha/carta-descuento/${data.id}`, '_blank');
                }

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

    const handleEnviar = () => {
        console.log('enviar');
    }

    const handleEliminar = (id) => {
        Axios.delete(`/api/renovacion-fotocheck/${id}`)
            .then(res => {
                notification['success']({
                    message: res.data.message
                });

                setReloadDatos(!reloadDatos);
            })
            .catch(err => {});
    }

    const handleCambiarEstado = (id, estado) => {
        Axios.put(`/api/renovacion-fotocheck/${id}`, {
            estado,
        })
            .then(res => {
                notification['success']({
                    message: res.data.message
                });

                setReloadDatos(!reloadDatos);
            })
            .catch(err => {});
    }

    useEffect(() => {
        function fetchRenovaciones() {
            setLoading(true);
            Axios.get(`/api/renovacion-fotocheck?desde=${filtro.desde}&hasta=${filtro.hasta}&usuario_id=${usuario.id}&tipo=${filtro.tipo}&rut=${filtro.rut}`)
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
                })
                .finally(() => setLoading(false));
        }

        if (filtro.rut === '' || filtro.rut.length >= 8) {
            fetchRenovaciones();
        }
    }, [reloadDatos, filtro.desde, filtro.hasta, filtro.tipo, filtro.rut]);

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
                handleCambiarEstado={handleCambiarEstado}
                loading={loading}
            />
        </>
    );
}
