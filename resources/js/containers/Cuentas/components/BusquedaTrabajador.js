import React, { useState, useEffect } from 'react';
import Axios from 'axios';
import Swal from 'sweetalert2';

export const BusquedaTrabajador = ({ form, setForm, setTrabajador }) => {
    const [rut, setRut] = useState('');

    const clearData = data => {
        for (const key in data) {
            if (data[key] === null || data[key] === undefined) {
                data[key] = '';
            }
        }
        return data;
    };

    const handleSubmit = e => {
        e.preventDefault();

        Swal.fire({
            onBeforeOpen: () => {
                Swal.showLoading();
            }
        })

        Axios.get(`http://192.168.60.16/api/trabajador/${rut}?activo=${false}`)
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
                        empresa_id: parseInt(contrato_activo[0].empresa_id),
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
