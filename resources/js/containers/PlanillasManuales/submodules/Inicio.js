import React, { useEffect, useState } from 'react';
import { notification } from 'antd';
import Axios from 'axios';

import { Datos, TablaRegistros } from '../components';
import BuscarTrabajador from '../../shared/BuscarTrabajador';

const initialState = {
    empresa_id: '',
    regimen_id: '',
    zona_labor_id: '',
    motivo_planilla_manual_id: '',
    fecha_planilla: '',
    hora_entrada: '',
    hora_salida: '',
}

export const Inicio = () => {

    const { usuario, submodule } = JSON.parse(sessionStorage.getItem("data"));

    const [trabajador, setTrabajador] = useState(null);
    const [contratoActivo, setContratoActivo] = useState(null);
    const [form, setForm] = useState({...initialState});
    const [submiting, setSubmiting] = useState(false);
    const [reload, setReload] = useState(false);

    const handleSubmit = e => {
        e.preventDefault();

        setSubmiting(true);
        Axios.post('/api/planillas-manuales', {
            ...form,
            usuario_id: usuario.id,
            trabajador
        })
            .then(res => {
                const data = res.data.data;
                setReload(!reload);

                setForm({ ...initialState });
                setTrabajador(null);
                setContratoActivo(null);

                notification['success']({
                    message: res.data.message
                });
            })
            .catch(err => {
                console.log(err);
                notification['error']({
                    message: err.response.data.message
                });
            })
            .finally(() => setSubmiting(false));
    }

    const handleEliminar = (id) => {
        Axios.delete(`/api/planillas-manuales/${id}`)
            .then(res => {
                notification['success']({
                    message: res.data.message,
                });

                setReload(!reload);
            })
            .catch(err => {
                console.log(err);
                notification['error']({
                    message: 'Error al eliminar registro'
                });
        })
    }

    return (
        <>
            <div className="mb-3">
                <h4>Planillas Manuales</h4>
            </div>
            <BuscarTrabajador
                setTrabajador={setTrabajador}
                setContratoActivo={setContratoActivo}
                activo={true}
            />
            <Datos
                handleSubmit={handleSubmit}
                trabajador={trabajador}
                contratoActivo={contratoActivo}
                form={form}
                setForm={setForm}
                submiting={submiting}
            />
            <hr />
            <TablaRegistros
                reload={reload}
                setReload={setReload}
                handleEliminar={handleEliminar}
            />
        </>
    );
}
