import React, { useState, useEffect } from 'react';
import moment from 'moment';
import Axios from 'axios';
import Swal from 'sweetalert2';

import BuscarTrabajador from '../../shared/BuscarTrabajador';
import { DatosEpp } from './components/DatosEpp';
import { TablaEpp } from './components/TablaEpp';


export const EPP = () => {

    const { usuario, editar } = JSON.parse(sessionStorage.getItem('data'));

    const [trabajador, setTrabajador] = useState(null);
    const [contratoActivo, setContratoActivo] = useState(null);

    const [form, setForm] = useState({
        usuario_id: usuario.id,
        empresa_id: '',
        nombre_completo: '',
        zona_labor_id: '',
        cuartel_id: '',
        fecha_incidencia: moment().format('YYYY-MM-DD').toString(),
        motivo: '',
        epps: [],
    });
    const [reloadData, setReloadData] = useState(false);
    const [empresas, setEmpresas] = useState([]);
    const [zonasLabor, setZonasLabor] = useState([]);
    const [cuarteles, setCuarteles] = useState([]);

    useEffect(() => {
        fetchEmpresas();
    }, []);

    useEffect(() => {
        if (form.empresa_id !== '') {
            fetchZonasLabor();
        }
    }, [form.empresa_id]);

    useEffect(() => {
        if (form.empresa_id !== '' && form.zona_labor_id !== '') {
            fetchCuarteles();
        }
    }, [form.empresa_id, form.zona_labor_id]);

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

    function fetchEmpresas() {
        Axios.get("/api/empresa")
            .then(res => {
                setEmpresas(res.data);
            })
            .catch(err => {
                console.log(err);
            });
    }

    function fetchZonasLabor() {
        Axios.get(
            `http://192.168.60.16/api/zona-labor/${form.empresa_id}`
        )
            .then(res => {
                // console.log(res);
                setZonasLabor(res.data.data);
            })
            .catch(err => {
                console.log(err);
            });
    }

    function fetchCuarteles() {
        Axios.get(
            `http://192.168.60.16/api/cuartel/${form.empresa_id}/${form.zona_labor_id}`
        )
            .then(res => {
                setCuarteles(res.data.data);
            })
            .catch(err => {
                console.log(err);
            });
    }

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

        Axios.post('/api/sancion-epp', {...form})
            .then(res => {
                console.log(res.data);

                const { id, message, error,  } = res.data;

                setReloadData(!reloadData);

                Swal.fire({
                    title: message,
                    icon: error ? 'error' : 'success'
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
                <h4>EPP</h4>
            </div>
            <BuscarTrabajador
                setTrabajador={setTrabajador}
                setContratoActivo={setContratoActivo}
                jornal={true}
            />
            <DatosEpp
                handleSubmit={handleSubmit}
                trabajador={trabajador}
                contratoActivo={contratoActivo}
                form={form}
                setForm={setForm}
                empresas={empresas}
                zonasLabor={zonasLabor}
                cuarteles={cuarteles}
            />
            <hr />
            <TablaEpp
                reloadData={reloadData}
                setReloadData={setReloadData}
            />
        </>
    );
}
