import React, { useState, useEffect } from 'react';
import moment from 'moment';
import BuscarTrabajador from '../shared/BuscarTrabajador';
import DatosFormularioPermiso from './DatosFormularioPermiso';
import Axios from 'axios';
import { message } from 'antd';


const AgregarPermiso = () => {
    const { usuario } = JSON.parse(sessionStorage.getItem('data'));
    const [trabajador, setTrabajador] = useState(null);
    const [trabajadorJefe, setTrabajadorJefe] = useState(null);
    const [contratoActivo, setContratoActivo] = useState(null);
    const [motivosPermiso, setMotivosPermiso] = useState([]);
    const [form, setForm] = useState({
        nombre_completo: '',
        fecha_solicitud: moment().format('YYYY-MM-DD').toString(),
        empresa_id: '',
        horario_entrada: '06:15',
        horario_salida: '',
        refrigerio: 0,
        fecha_salida: '',
        hora_salida: '00:00',
        fecha_regreso: '',
        hora_regreso: '00:00',
        motivo_permiso_id: '',
        observacion: '',
    });

    const [totalHoras, setTotalHoras] = useState(0);

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
        setForm({
            ...form,
            hora_regreso: form.horario_salida
        });
    }, [form.horario_salida]);

    useEffect(() => {
        setForm({
            ...form,
            fecha_regreso: form.fecha_salida
        });
    }, [form.fecha_salida]);

    useEffect(() => {
        function fetchHorasTotales() {
            Axios.post('/api/formulario-permiso/calcular-horas', {
                fecha_hora_salida: moment(`${form.fecha_salida} ${form.hora_salida}`).format('YYYY-MM-DD HH:mm:ss').toString(),
                fecha_hora_regreso: moment(`${form.fecha_regreso} ${form.hora_regreso}`).format('YYYY-MM-DD HH:mm:ss').toString(),
                horario_entrada: form.horario_entrada,
                horario_salida: form.horario_salida,
                refrigerio: form.refrigerio,
            })
                .then(res => {
                    console.log(res.data);

                    message['success']({
                        content: res.data.message
                    });

                    setTotalHoras(res.data.total_horas);
                })
                .catch(err => {
                    console.error(err.response);

                    if (err.response.data) {
                        message['error']({
                            content: err.response.data.message
                        });
                    }

                    setTotalHoras(0);
                });
        }

        if (
            form.fecha_salida !== '' &&
            form.fecha_regreso !== '' &&
            form.hora_salida !== '' &&
            form.hora_regreso !== '' &&
            form.horario_entrada !== '' &&
            form.horario_salida !== '' &&
            moment(form.fecha_salida).year() >= moment().year() - 1 &&
            moment(form.fecha_regreso).year() >= moment().year() - 1
        ) {
            console.log('effect')
            fetchHorasTotales();
        }

    }, [form.fecha_salida, form.fecha_regreso, form.hora_salida, form.hora_regreso, form.horario_entrada, form.horario_salida, form.refrigerio]);

    const handleSubmit = e => {
        e.preventDefault();
        form.trabajador = trabajador;
        form.jefe = trabajadorJefe;
        form.contratoActivo = contratoActivo;
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
                totalHoras={totalHoras}
                motivosPermiso={motivosPermiso}
                setMotivosPermiso={setMotivosPermiso}
                setTrabajadorJefe={setTrabajadorJefe}
            />
        </>
    );
};

export default AgregarPermiso;
