import React, { useState } from 'react';
import Axios from 'axios';
import Swal from "sweetalert2";

export const BusquedaTrabajador = ({ setTrabajador, setPeriodos, setAlertas }) => {

    const [rut, setRut] = useState('');
    const [loading, setLoading] = useState(false);

    const handleSubmit = e => {
        e.preventDefault();
        fetchTrabajador();
    }

    const fetchTrabajador = () => {
        Swal.fire({
            onBeforeOpen: () => {
                Swal.showLoading();
            }
        });

        Axios.get(`http://192.168.60.16/api/trabajador/${rut}/info-periodos`)
            .then(res => {
                const { trabajador, alertas, periodos } = res.data;

                setTrabajador(trabajador);
                setPeriodos(periodos.map(i => {
                    return {
                        ...i,
                        key: `${i.empresa_id}${i.contrato_id}`,
                        empresa: i.empresa_id === '9' ? 'RAPEL' : 'VERFRUT',
                        sueldo: i.sueldo_bruto <= 2000 ? i.sueldo_bruto : <i className="fas fa-ban" />
                    }
                }));
                setAlertas(alertas);

                Swal.fire('Trabajador encontrado', '', 'success');
            })
            .catch(err => {
                setTrabajador(null);
                setPeriodos([]);
                setAlertas([]);

                Swal.fire('No existe trabajador en el sistema', '', 'error');
            });
    }

    return (
        <form onSubmit={handleSubmit}>
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
                        <button className="btn btn-primary" type="submit" disabled={(rut.length < 8 || rut.length > 11) || loading}>
                            <i className="fas fa-search" />
                        </button>
                    </div>
                </div>
            </div>
        </form>
    )
}
