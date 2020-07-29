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
        empresa_id: 9,
        fecha_salida: '',
        fecha_regreso: '',
        hora_salida: '00:00',
        hora_regreso: '00:00',
        motivo_permiso_id: '',
        observacion: '',
    });
    const [hp, setHp] = useState(0);

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
        const start = moment(`${form.fecha_salida} ${form.hora_salida}`);
        const end = moment(`${form.fecha_regreso} ${form.hora_regreso}`);
        /*

        const diff = moment.duration(end.diff(start));

        const days = Math.floor(diff.asDays());

        const hours = Math.ceil(( diff.asDays() - days ) * 24);

        const differenceOnHours = (days * 8) + hours;

        setHp(differenceOnHours);*/

    }, [form.fecha_salida, form.fecha_regreso, form.hora_regreso, form.hora_salida]);

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
                hp={hp}
                motivosPermiso={motivosPermiso}
                setMotivosPermiso={setMotivosPermiso}
                setTrabajadorJefe={setTrabajadorJefe}
            />
        </>
    );
};

export default AgregarPermiso;
