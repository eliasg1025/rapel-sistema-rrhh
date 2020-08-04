import React, { useState, useEffect } from 'react';
import moment from 'moment';
import BuscarTrabajador from '../shared/BuscarTrabajador';
import DatosFormularioPermiso from './DatosFormularioPermiso';
import { TablaFormulariosPermisos } from './TablaFormulariosPermisos';
import Axios from 'axios';
import { message } from 'antd';
import Swal from 'sweetalert2';


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
    const [reloadDatos, setReloadDatos] = useState(false);

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
                fecha_hora_salida: `${form.fecha_salida} ${form.hora_salida}`,
                fecha_hora_regreso: `${form.fecha_regreso} ${form.hora_regreso}`,
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
            fetchHorasTotales();
        }

    }, [form.fecha_salida, form.fecha_regreso, form.hora_salida, form.hora_regreso, form.horario_entrada, form.horario_salida, form.refrigerio]);

    useEffect(() => {
        console.log(motivosPermiso);
    }, [motivosPermiso])

    const handleSubmit = e => {
        e.preventDefault();
        form.trabajador = trabajador;
        form.jefe = trabajadorJefe;
        form.regimen = contratoActivo.regimen;
        form.cuartel = contratoActivo.cuartel;
        form.oficio = contratoActivo.oficio;
        form.zona_labor = contratoActivo.zona_labor;
        form.total_horas = totalHoras;
        form.usuario_id = usuario.id;

        const m = motivosPermiso.find(e => e.id == form.motivo_permiso_id);

        form.motivo_permiso = m;

        console.log(form);

        Axios.post('/api/formulario-permiso', {...form})
            .then(res => {
                const { id, message, error } = res.data;
                const url = `/ficha/formulario-permiso/${id}`;

                Swal.fire({
                    title: message,
                    icon: error ? 'error' : 'success'
                })
                    .then(res => {
                        window.open(url, '_blank');
                        location.reload();
                    });
            })
            .catch(err => {
                console.log(err, err.response);
                if (err.response.status < 500) {
                    Swal.fire({
                        title: err.response.data.error,
                        icon: 'error'
                    });
                    return;
                }
            });
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
            <hr />
            <TablaFormulariosPermisos
                reloadDatos={reloadDatos}
                setReloadDatos={setReloadDatos}
            />
        </>
    );
};

export default AgregarPermiso;
