import React, { useState, useEffect } from 'react';
import moment from 'moment';

import BuscarTrabajador from '../shared/BuscarTrabajador';
import DatosReseteoClave from './DatosReseteoClave';
import Axios from 'axios';
import TablaPendientes from './TablaPendientes';

const intitalState = {
    nombre_completo: '',
    fecha_solicitud: moment().format('YYYY-MM-DD').toString(),
    empresa_id: 9
}

const AgregarReseteoClave = () => {
    const { usuario } = JSON.parse(sessionStorage.getItem('data'));

    const [trabajador, setTrabajador] = useState(null);
    const [contratoActivo, setContratoActivo] = useState(null);
    const [form, setForm] = useState({...intitalState});

    const handleSubmit = e => {
        e.preventDefault();
        form.trabajador = trabajador;
        form.usuario_id = usuario.id;

        console.log(form);

        Axios.post('/api/atencion-reseteo-clave', {...form})
            .then(res => console.log(res.data))
            .catch(err => console.error(err));
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
            <TablaPendientes />
        </>
    );
}

export default AgregarReseteoClave;
