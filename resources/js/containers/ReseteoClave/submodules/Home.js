import React, { useState, useEffect } from 'react';
import moment from 'moment';
import Axios from 'axios';
import Swal from 'sweetalert2';

import { EtiquetaAdministrador } from "../../shared";
import BuscarTrabajador from '../../shared/BuscarTrabajador'
import { DatosReseteoClave, TablaPendientes } from '../components'

const initialState = {
    nombre_completo: '',
    fecha_solicitud: moment().format('YYYY-MM-DD').toString(),
    empresa_id: 9,
    numero_telefono_trabajador: '',
}

export const Home = () => {
    const { usuario, submodule } = JSON.parse(sessionStorage.getItem("data"));

    const [trabajador, setTrabajador] = useState(null);
    const [contratoActivo, setContratoActivo] = useState(null);
    const [form, setForm] = useState({...initialState});
    const [reloadDatos, setReloadDatos] = useState(false);

    const handleSubmit = e => {
        e.preventDefault();
        form.trabajador = trabajador;
        form.usuario_id = usuario.id;
        form.contratoActivo = contratoActivo;

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
            <div className="mb-3">
                <h4>
                    Atención Reseteo Clave{" "}
                    {(usuario.reseteo_clave === 2 || usuario.reseteo_clave === 3) && (
                        <EtiquetaAdministrador />
                    )}
                </h4>
            </div>
            <BuscarTrabajador
                setTrabajador={setTrabajador}
                setContratoActivo={setContratoActivo}
                activo={false}
            />
            <DatosReseteoClave
                contratoActivo={contratoActivo}
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
};
