import React, { useState, useEffect } from 'react';
import moment from 'moment';

import BuscarTrabajador from '../shared/BuscarTrabajador';
import DatosAfp from './DatosAfp';
import Axios from 'axios';
import TablaAfps from './TablaAfps';

const initialFormState = {
    nombre_completo: '',
    fecha_inicio: '',
    empresa_id: 9,
    afp_id: '2'
};

const AgregarAfp = () => {
    const { usuario } = JSON.parse(sessionStorage.getItem('data'));

    const [afps, setAfps] = useState([]);
    const [trabajador, setTrabajador] = useState(null);
    const [contratoActivo, setContratoActivo] = useState(null);
    const [form, setForm] = useState({...initialFormState});

    useEffect(() => {
        setForm({
            ...form,
            nombre_completo: trabajador?.nombre ? `${trabajador.nombre} ${trabajador.apellido_paterno} ${trabajador.apellido_materno}` : ''
        });
    }, [trabajador]);

    useEffect(() => {
        if (contratoActivo !== null && contratoActivo.afp_id !== '30') {
            Swal.fire({
                title: `El trabajador ya esta afiliado a una AFP: ${contratoActivo.afp.name}`,
                icon: 'warning'
            })
                .then(() => {
                    setTrabajador(initialFormState);
                    setContratoActivo(null);
                });
            return;
        }

        setForm({
            ...form,
            fecha_inicio: contratoActivo ? moment(contratoActivo.fecha_inicio).format('YYYY-MM-DD').toString() : '',
            empresa_id: contratoActivo ? contratoActivo.empresa_id : ''
        });
    }, [contratoActivo]);

    const handleSubmit = e => {
        e.preventDefault();
        const afp = afps.filter(item => item.id === form.afp_id)[0];
        form.trabajador = trabajador;
        form.afp = afp;
        form.usuario_id = usuario.id;

        console.log(form);
        Axios.post('/api/eleccion-afp', {...form})
            .then(res => {
                console.log(res);
                if (res.status >= 400) {
                    Swal.fire({
                        title: 'Algo salió mal',
                        icon: 'error'
                    });
                    return;
                }

                const url = `/ficha/eleccion-afp/${res.data.id}`;

                Swal.fire({
                    title: 'Registro guardado correctamente',
                    icon: 'success'
                })
                    .then(() => {
                        window.open(url, '_blank');
                        location.reload();
                    });
            })
            .catch(err => {
                console.log(err);
            });
    };

    return (
        <>
            <BuscarTrabajador
                setTrabajador={setTrabajador}
                setContratoActivo={setContratoActivo}
            />
            <DatosAfp
                handleSubmit={handleSubmit}
                form={form}
                setForm={setForm}
                afps={afps}
                setAfps={setAfps}
            />
            <hr />
            <TablaAfps
                usuario={usuario}
            />
        </>
    );
};

export default AgregarAfp;
