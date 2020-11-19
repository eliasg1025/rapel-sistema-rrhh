import React, { useState } from 'react';
import Axios from 'axios';
import Swal from 'sweetalert2';

const BuscarTrabajador = ({
    setTrabajador,
    setContratoActivo,
    activo=true,
    jornal=false,
}) => {
    const [rut, setRut] = useState('');
    const [loading, setLoading] = useState(false);

    const handleSubmit = e => {
        e.preventDefault();

        function fetchTrabajador(cb) {
            Swal.fire({
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });

            Axios.get(`http://192.168.60.16/api/trabajador/${rut}/info?activo=${activo}&jornal=${jornal}`)
                .then(res => {
                    const { contrato_activo, trabajador } = res.data.data;
                    //console.log(trabajador, contrato_activo);

                    if (contrato_activo.length === 0) {
                        Swal.fire('El trabajador no tiene contrato activo', '', 'warning');
                        setTrabajador(null);
                        setContratoActivo(null);
                        return;
                    }

                    Swal.fire('Trabajador encontrado', '', 'success');
                    setTrabajador(trabajador);
                    // console.log(contrato_activo[0]);
                    setContratoActivo(contrato_activo[0]);
                    return;
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire('No existe trabajador en el sistema', '', 'error');
                    setTrabajador(null);
                    setContratoActivo(null);
                    return;
                }).finally(() => {
                    cb();
                });
        }

        setLoading(true);
        fetchTrabajador(() => {
            setLoading(false);
        });
    };

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
                        <button className="btn btn-primary" type="submit" disabled={rut.length !== 8 || loading}>
                            <i className="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    );
};

export default BuscarTrabajador;
