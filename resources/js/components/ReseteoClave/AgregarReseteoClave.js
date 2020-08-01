import React, { useState, useEffect } from 'react';
import moment from 'moment';

import BuscarTrabajador from '../shared/BuscarTrabajador';
import DatosReseteoClave from './DatosReseteoClave';
import Axios from 'axios';
import TablaPendientes from './TablaPendientes';
import Swal from 'sweetalert2';

const initialState = {
    nombre_completo: '',
    fecha_solicitud: moment().format('YYYY-MM-DD').toString(),
    empresa_id: 9
}

const AgregarReseteoClave = () => {
    const { usuario } = JSON.parse(sessionStorage.getItem('data'));

    const [trabajador, setTrabajador] = useState(null);
    const [contratoActivo, setContratoActivo] = useState(null);
    const [form, setForm] = useState({...initialState});
    const [reloadDatos, setReloadDatos] = useState(false);

    const handleSubmit = e => {
        e.preventDefault();
        form.trabajador = trabajador;
        form.usuario_id = usuario.id;

        console.log(form);

        Axios.post('/api/atencion-reseteo-clave', {...form})
            .then(res => {
                if (res.status >= 400) {
                    Swal.fire({
                        title: 'Algo salió mal',
                        icon: 'error'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Registro guardado correctamente',
                    icon: 'success'
                })
                    .then(() => {
                        setReloadDatos(!reloadDatos);
                        setForm({...initialState});
                    });
            })
            .catch(err => {
                console.error(err);
                Swal.fire({
                    title: err.response.data.message,
                    icon: 'error'
                });
            });
    }

    useEffect(() => {
        setForm({
            ...form,
            nombre_completo: trabajador?.nombre ? `${trabajador.nombre} ${trabajador.apellido_paterno} ${trabajador.apellido_materno}` : ''
        });
    }, [trabajador]);

    useEffect(() => {
        setForm({
            ...form,
            empresa_id: contratoActivo?.empresa_id || ''
        })
    }, [contratoActivo]);

    return (
        <>
            <BuscarTrabajador
                setTrabajador={setTrabajador}
                setContratoActivo={setContratoActivo}
            />
            <DatosReseteoClave
                handleSubmit={handleSubmit}
                form={form}
                setForm={setForm}
            />
            <hr />
            <TablaPendientes
                reloadDatos={reloadDatos}
                setReloadDatos={setReloadDatos}
            />
        </>
    );
}

export default AgregarReseteoClave;
