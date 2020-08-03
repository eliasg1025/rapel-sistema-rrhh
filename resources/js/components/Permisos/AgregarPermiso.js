import React, { useState, useEffect } from 'react';
import moment from 'moment';
import BuscarTrabajador from '../shared/BuscarTrabajador';
import DatosFormularioPermiso from './DatosFormularioPermiso';


const AgregarPermiso = () => {
    const { usuario } = JSON.parse(sessionStorage.getItem('data'));
    const [trabajador, setTrabajador] = useState(null);
    const [trabajadorJefe, setTrabajadorJefe] = useState(null);
    const [contratoActivo, setContratoActivo] = useState(null);
    const [motivosPermiso, setMotivosPermiso] = useState([]);
    const [form, setForm] = useState({
        nombre_completo: '',
        nombre_completo_jefe: '',
        fecha_solicitud: moment().format('YYYY-MM-DD').toString(),
        empresa_id: '',
        horario_entrada: '06:15',
        considerar_refrigerio: false,
        fecha_salida: '',
        hora_salida: '00:00',
        fecha_regreso: '',
        hora_regreso: '00:00',
        motivo_permiso_id: '',
        total_horas: 0,
        observacion: '',
    });

    useEffect(() => {
        setForm({
            ...form,
            nombre_completo: trabajador?.nombre ? `${trabajador.nombre} ${trabajador.apellido_paterno} ${trabajador.apellido_materno}` : ''
        });
    }, [trabajador]);

    useEffect(() => {
        setForm({
            ...form,
            empresa_id: contratoActivo ? contratoActivo.empresa_id : ''
        });
    }, [contratoActivo]);

    useEffect(() => {
        if (
            form.fecha_salida !== '' &&
            form.fecha_regreso !== '' &&
            form.hora_salida !== '' &&
            form.hora_regreso !== '' &&
            form.horario_entrada !== ''
        ) {
            const start = moment(`${form.fecha_salida} ${form.hora_salida}`).format('YYYY-MM-DD HH:mm:ss').toString();
            const end = moment(`${form.fecha_regreso} ${form.hora_regreso}`).format('YYYY-MM-DD HH:mm:ss').toString();

            console.log(start, end);
        }

    }, [trabajador, contratoActivo, form.fecha_salida, form.fecha_regreso, form.hora_regreso, form.hora_salida, form.considerar_refrigerio, form.horario_entrada ]);

    const handleSubmit = e => {
        e.preventDefault();
        console.log(form);
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
                motivosPermiso={motivosPermiso}
                setMotivosPermiso={setMotivosPermiso}
                setTrabajadorJefe={setTrabajadorJefe}
            />
        </>
    );
};

export default AgregarPermiso;
