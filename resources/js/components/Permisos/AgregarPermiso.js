import React, { useState } from 'react';
import BuscarTrabajador from '../shared/BuscarTrabajador';
import DatosFormularioPermiso from './DatosFormularioPermiso';

import moment from 'moment';

const AgregarPermiso = () => {
    const { usuario } = JSON.parse(sessionStorage.getItem('data'));
    const [trabajador, setTrabajador] = useState(null);
    const [contratoActivo, setContratoActivo] = useState(null);
    const [form, setForm] = useState({
        nombre_completo: '',
        fecha_solicitud: moment().format('YYYY-MM-DD').toString(),
        empresa_id: '9',
        fecha_salida: '',
        fecha_regreso: '',
        hora_salida: '',
        hora_regreso: '',
        motivo_permiso_id: '',
        observacion: ''
    })

    const handleSubmit = () => {
        console.log('submit');
    };

    return (
        <>
            <BuscarTrabajador
                setTrabajador={setTrabajador}
                setContratoActivo={setContratoActivo}
            />
            <DatosFormularioPermiso
                handleSubmit={handleSubmit}
                form={form}
                setForm={setForm}
            />
        </>
    );
};

export default AgregarPermiso;
