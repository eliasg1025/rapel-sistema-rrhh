import React, { useState, useEffect } from 'react';
import ReactDOM from "react-dom";
import moment from 'moment';
import Swal from 'sweetalert2';
import { notification } from "antd";
import DatosCuenta from "./DatosCuenta";

const AgregarCuenta = props => {
    const { usuario, empresas, cuenta } = JSON.parse(sessionStorage.getItem('data'));

    const [bancos, setBancos] = useState([]);
    const [trabajador, setTrabajador] = useState(null);
    const [loadingSubmit, setLoadingSubmit] = useState(false);

    let initialState = {};
    if (!cuenta) {
        initialState = {
            rut: '',
            nombre_trabajador: '',
            fecha_solicitud: moment().format('YYYY-MM-DD').toString(),
            empresa_id: '9',
            numero_cuenta: '',
            banco_id: '',
            apertura: false
        };
    } else {
        initialState = {...cuenta, numero_cuenta: cuenta.numero_cuenta || ''}
    }
    const [form, setForm] = useState(initialState);

    const handleSubmit = e => {
        e.preventDefault();
        const banco = bancos.find(e => e.id == form.banco_id);
        form.banco = banco;
        form.trabajador = trabajador;
        form.usuario_id = usuario.id;

        console.log(form);
        setLoadingSubmit(true);
        axios.post('/api/cuenta', {...form})
            .then(res => {
                console.log(res);
                if (res.status >= 400) {
                    Swal.fire({
                        title: 'Algo salió mal',
                        icon: 'error'
                    });
                    return;
                }
                const url = `/ficha/cambio-cuenta/${res.data.cuenta_id}`;

                Swal.fire({
                    title: 'Cuenta guardada correctamente',
                    icon: 'success'
                })
                    .then(() => {
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
            })
            .finally(() => {
                setLoadingSubmit(false);
            });
    }

    return (
        <div>
            {!cuenta && (
                <>
                    <BuscarTrabajador
                        form={form}
                        setForm={setForm}
                        setTrabajador={setTrabajador}
                    />
                    <br />
                </>
            )}
            <DatosCuenta
                handleSubmit={handleSubmit}
                form={form}
                setForm={setForm}
                bancos={bancos}
                setBancos={setBancos}
                empresas={empresas}
                loadingSubmit={loadingSubmit}
            />
        </div>
    )
};

const clearData = data => {
    for (const key in data) {
        if (data[key] === null || data[key] === undefined) {
            data[key] = '';
        }
    }
    return data;
};

const BuscarTrabajador = props => {
    const { form, setForm, setTrabajador } = props;
    const [rut, setRut] = useState('');

    const handleSubmit = e => {
        e.preventDefault();

        Swal.fire({
            onBeforeOpen: () => {
                Swal.showLoading();
            }
        })

        axios.get(`http://192.168.60.16/api/trabajador/${rut}?activo=${false}`)
                .then(res => {
                    const { trabajador, contrato_activo } = res.data.data;

                    Swal.fire({
                        title: 'Trabajador encontrado' + (trabajador.banco_id ? ', ya tiene cuenta' : ''),
                        icon: 'success'
                    });
                    setForm({
                        ...form,
                        rut: trabajador.rut,
                        nombre_trabajador: `${trabajador.apellido_paterno} ${trabajador.apellido_materno}, ${trabajador.nombre}`,
                        numero_cuenta: trabajador.numero_cuenta,
                        empresa_id: contrato_activo[0].empresa_id,
                        banco_id: trabajador.banco_id || '59'
                    });
                    setTrabajador({ ...clearData(trabajador) });
                })
                .catch(err => {
                    console.log(err);
                    setForm({
                        ...form,
                        rut: '',
                        nombre_trabajador: '',
                        numero_cuenta: ''
                    });
                    Swal.fire({
                        title: 'No encontrado en el sistema',
                        icon: 'warning'
                    });
                });
    };
    return (
        <form id="form-buscar-trabajador" onSubmit={handleSubmit}>
            <div className="row">
                <div className="input-group mb-3 col">
                    <input
                        type="text"
                        className="form-control"
                        name="_rut"
                        autoComplete="off"
                        placeholder="Buscar por RUT"
                        value={rut}
                        onChange={e => setRut(e.target.value)}
                    />
                    <div className="input-group-append">
                        <button className="btn btn-primary" type="submit">
                            <i className="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    );
};

export default AgregarCuenta;

