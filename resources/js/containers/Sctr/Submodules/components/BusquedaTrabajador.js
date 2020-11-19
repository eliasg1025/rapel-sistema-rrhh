import React, { useState } from 'react';
import Axios from 'axios';
import Swal from 'sweetalert2';

export const BusquedaTrabajador = ({ setTrabajador, setContratos, setSctr, reloadData, setReloadData }) => {

    const { usuario } = JSON.parse(sessionStorage.getItem('data'));

    const [rut, setRut] = useState('');

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

        Axios.get(`http://192.168.60.16/api/trabajador/${rut}/info-sctr`)
            .then(res => {
                const { trabajador, contrato_activo } = res.data;

                if (trabajador !== null && contrato_activo.length > 0) {
                    const { empresa_id, oficio, zona_labor, cuartel } = contrato_activo[0];

                    Axios.put(`/api/trabajador/${trabajador.rut}/sctr`, {
                        empresa_id,
                        oficio_id: oficio.id,
                        zona_id: zona_labor.id,
                        cuartel_id: cuartel.id
                    })
                        .then(res => {
                            setSctr(res.data.sctr);

                            Axios.post('/api/consulta-sctr', {
                                usuario_id: usuario.id,
                                rut: rut,
                                sctr: res.data.sctr,
                                empresa_id,
                                oficio: oficio.name,
                                zona_labor: zona_labor.name,
                                nombre_completo: `${trabajador.apellido_paterno} ${trabajador.apellido_materno} ${trabajador.nombre}`
                            })
                                .then(res => {
                                    console.log(res);
                                    setReloadData(!reloadData);
                                })
                                .catch(err => console.log(err));
                        })
                        .catch(err => {
                            setSctr(false);
                        });
                }

                setTrabajador(trabajador);
                setContratos(contrato_activo);

                Swal.fire('Trabajador encontrado', '', 'success');
            })
            .catch(err => {
                setTrabajador(null);
                setContratos([]);

                Swal.fire('Error al obtener trabajador', '', 'error');
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
                        <button className="btn btn-primary" type="submit" disabled={(rut.length < 8 || rut.length > 11)}>
                            <i className="fas fa-search" />
                        </button>
                    </div>
                </div>
            </div>
        </form>
    );
}
