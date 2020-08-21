import React, { useState, useEffect } from 'react';
import moment from 'moment';
import Axios from 'axios';

import BuscarTrabajador from '../shared/BuscarTrabajador';
import { DatosSancion } from './DatosSancion';
import { TablaSancion } from './TablaSancion';

const AgregarSancion = () => {
    const { usuario, editar } = JSON.parse(sessionStorage.getItem('data'));

    const [trabajador, setTrabajador] = useState(null);
    const [contratoActivo, setContratoActivo] = useState(null);
    const [incidencias, setIncidencias] = useState([]);
    const [form, setForm] = useState({
        nombre_completo: '',
        fecha_solicitud: moment().format('YYYY-MM-DD').toString(),
        empresa_id: '',
        fecha_incidencia: moment().format('YYYY-MM-DD').toString(),
        incidencia_id: '',
        tipo_documento: '',
        observacion: '',
        zona_labor_id: '',
        cuartel_id: '',
    });
    const [reloadDatos, setReloadDatos] = useState(false);

    const [zonasLabor, setZonasLabor] = useState([]);
    const [cuarteles, setCuarteles] = useState([]);

    useEffect(() => {
        if (editar) {
            let intentos = 0;
            function fetchSancion() {
                intentos++;
                Axios.get(`/api/sancion/${editar}`)
                    .then(res => {
                        console.log(res.data);

                        const { data } = res;
                        setForm({ ...data, observacion: data.observacion || '' });
                    })
                    .catch(err => {
                        if (intentos < 3) {
                            fetchSancion();
                        }
                    })
            }

            fetchSancion();
        }
    }, []);

    const handleSubmit = e => {
        e.preventDefault();

        form.trabajador = trabajador;
        form.regimen = contratoActivo?.regimen || null;
        form.oficio = contratoActivo?.oficio || null;
        form.usuario_id = usuario.id;

        const z = zonasLabor.find(e => e.id == form.zona_labor_id);
        const c = cuarteles.find(e => e.id == form.cuartel_id);

        form.zona_labor = z;
        form.cuartel = c;

        Swal.fire({
            onBeforeOpen: () => {
                Swal.showLoading();
            },
            title: 'Guardando ...'
        });

        Axios.post('/api/sancion', {...form})
            .then(res => {
                console.log(res.data);

                const { id, message, error, desvinculacion } = res.data;

                const url = `/ficha/sancion/${id}`;

                Swal.fire({
                    title: message,
                    icon: error ? 'error' : 'success'
                })
                    .then(res => {
                        if (!desvinculacion) {
                            window.open(url, '_blank');
                            location.reload();
                        } else {
                            setReloadDatos(!reloadDatos);
                        }
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
    }

    useEffect(() => {
        setForm({
            ...form,
            nombre_completo: trabajador?.nombre ? `${trabajador.nombre} ${trabajador.apellido_paterno} ${trabajador.apellido_materno}` : '',
        });
    }, [trabajador]);

    useEffect(() => {
        setForm({
            ...form,
            empresa_id: contratoActivo ? contratoActivo.empresa_id : '',
            zona_labor_id: contratoActivo ? contratoActivo.zona_labor.id : '',
            cuartel_id: contratoActivo ? contratoActivo.cuartel?.id : '',
        });
    }, [contratoActivo]);

    useEffect(() => {
        if (incidencias.length > 0) {
            setForm({
                ...form,
                tipo_documento: form.incidencia_id !== '' ? incidencias.find(item => item.id == form.incidencia_id)?.documento : ''
            });
        }
    }, [form.incidencia_id]);

    return (
        <>
            {!editar && (
                <BuscarTrabajador
                    setTrabajador={setTrabajador}
                    setContratoActivo={setContratoActivo}
                    jornal={true}
                />
            )}
            <DatosSancion
                handleSubmit={handleSubmit}
                form={form}
                setForm={setForm}
                incidencias={incidencias}
                setIncidencias={setIncidencias}
                zonasLabor={zonasLabor}
                setZonasLabor={setZonasLabor}
                cuarteles={cuarteles}
                setCuarteles={setCuarteles}
            />
            <hr />
            {!editar && (
                <TablaSancion
                    reloadDatos={reloadDatos}
                    setReloadDatos={setReloadDatos}
                />
            )}
        </>
    );
}

export default AgregarSancion;
