import React, { useState, useEffect } from 'react';
import moment from 'moment';
import Axios from 'axios';
import Swal from 'sweetalert2';

import BuscarTrabajador from '../../shared/BuscarTrabajador';
import { DatosFormularioPermiso, TablaFormulariosPermisos } from '../components';
import { EtiquetaAdministrador } from '../../shared';

export const Home = () => {
    const { usuario, editar } = JSON.parse(sessionStorage.getItem('data'));

    const [trabajador, setTrabajador] = useState(null);
    const [trabajadorJefe, setTrabajadorJefe] = useState(null);
    const [contratoActivo, setContratoActivo] = useState(null);
    const [motivosPermiso, setMotivosPermiso] = useState([]);

    const [zonasLabor, setZonasLabor] = useState([]);
    const [cuarteles, setCuarteles] = useState([]);

    useEffect(() => {
        if (editar) {
            let intentos = 0;
            function fetchFormularioPermiso() {
                intentos++;
                Axios.get(`/api/formulario-permiso/${editar}`)
                    .then(res => {
                        console.log(res.data);

                        const { data } = res;

                        setForm({ ...data, observacion: data.observacion || '' });
                        setHorario({
                            entrada: data.entrada || '',
                            salida: data.salida || ''
                        });
                    })
                    .catch(err => {
                        if (intentos < 3) {
                            fetchFormularioPermiso();
                        }
                    })
            }

            fetchFormularioPermiso();
        }
    }, []);

    const [form, setForm] = useState({
        nombre_completo: '',
        nombre_completo_jefe: '',
        fecha_solicitud: moment().format('YYYY-MM-DD').toString(),
        empresa_id: '',
        refrigerio: 0,
        jornal: 0,
        fecha_salida: moment().format('YYYY-MM-DD').toString(),
        hora_salida: '',
        fecha_regreso: '',
        hora_regreso: '',
        motivo_permiso_id: '',
        observacion: '',
        zona_labor_id: '',
        cuartel_id: ''
    });

    const [horario, setHorario] = useState({
        entrada: '06:15',
        salida: '15:00'
    });

    const [totalHoras, setTotalHoras] = useState(0);
    const [errorTotalHoras, setErrorTotalHoras] = useState(null);
    const [nocturno, setNocturno] = useState(false);
    const [reloadDatos, setReloadDatos] = useState(false);

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
            jornal: contratoActivo ? contratoActivo.jornal : 0
        });
    }, [contratoActivo]);

    useEffect(() => {
        if (!editar) {
            setForm({
                ...form,
                hora_salida: horario.entrada
            });
        }
    }, [horario.entrada]);

    useEffect(() => {
        if (!editar) {
            setForm({
                ...form,
                hora_regreso: horario.salida
            });
        }
    }, [horario.salida]);

    useEffect(() => {
        if (!editar) {
            setForm({
                ...form,
                fecha_regreso: form.fecha_salida
            });
        }
    }, [form.fecha_salida]);

    const fetchHorasTotales = () => {
        Axios.post('/api/formulario-permiso/calcular-horas', {
            fecha_hora_salida: `${form.fecha_salida} ${form.hora_salida}`,
            fecha_hora_regreso: `${form.fecha_regreso} ${form.hora_regreso}`,
            horario_entrada: horario.entrada,
            horario_salida: horario.salida,
            refrigerio: form.refrigerio,
        })
            .then(res => {
                // console.log(res.data);

                setTotalHoras(res.data.total_horas);
                setErrorTotalHoras(null);
                setNocturno(res.data.nocturno);
                return;
            })
            .catch(err => {
                console.error(err.response);

                if (err.response.data) {
                    setErrorTotalHoras(err.response.data.message);
                }

                setTotalHoras(0);
            });
    }

    useEffect(() => {
        if (
            form.fecha_salida !== '' &&
            form.fecha_regreso !== '' &&
            form.hora_salida !== '' &&
            form.hora_regreso !== '' &&
            horario.entrada !== '' &&
            horario.salida !== '' &&
            moment(form.fecha_salida).year() >= moment().year() - 1 &&
            moment(form.fecha_regreso).year() >= moment().year() - 1
        ) {
            fetchHorasTotales();
        }

    }, [form.fecha_salida, form.fecha_regreso, form.hora_salida, form.hora_regreso, form.refrigerio]);

    useEffect(() => {
        console.log(motivosPermiso);
    }, [motivosPermiso]);

    const handleSubmit = e => {
        e.preventDefault();
        form.trabajador = trabajador;
        form.oficio = contratoActivo?.oficio || null;
        form.regimen = contratoActivo?.regimen || null;

        form.jefe = trabajadorJefe;
        form.horario_entrada = horario.entrada,
        form.horario_salida = horario.salida,
        form.total_horas = totalHoras;
        form.usuario_id = usuario.id;

        const z = zonasLabor.find(e => e.id == form.zona_labor_id);
        const c = cuarteles.find(e => e.id == form.cuartel_id);
        const m = motivosPermiso.find(e => e.id == form.motivo_permiso_id);
        form.zona_labor = z;
        form.cuartel = c;
        form.motivo_permiso = m;

        Swal.fire({
            onBeforeOpen: () => {
                Swal.showLoading();
            },
            title: 'Guardando ...'
        });

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
            <div className="mb-3">
                <h4>
                    Formularios de Permiso{" "}
                    {usuario.permisos === 2 && (
                        <EtiquetaAdministrador />
                    )}
                </h4>
            </div>
            {!editar && (
                <BuscarTrabajador
                    setTrabajador={setTrabajador}
                    setContratoActivo={setContratoActivo}
                    jornal={true}
                />
            )}
            <DatosFormularioPermiso
                handleSubmit={handleSubmit}
                form={form}
                setForm={setForm}
                horario={horario}
                setHorario={setHorario}
                totalHoras={totalHoras}
                errorTotalHoras={errorTotalHoras}
                motivosPermiso={motivosPermiso}
                setMotivosPermiso={setMotivosPermiso}
                trabajadorJefe={trabajadorJefe}
                setTrabajadorJefe={setTrabajadorJefe}
                zonasLabor={zonasLabor}
                setZonasLabor={setZonasLabor}
                cuarteles={cuarteles}
                setCuarteles={setCuarteles}
                nocturno={nocturno}
            />
            <hr />
            {!editar && (
                <TablaFormulariosPermisos
                    reloadDatos={reloadDatos}
                    setReloadDatos={setReloadDatos}
                />
            )}
        </>
    );
}
