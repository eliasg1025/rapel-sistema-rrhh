import React, { useState } from 'react';
import moment from 'moment';

import {empresa} from "../../../../data/default.json";
import {ModalBootstrap} from "../../../shared/ModalBootstrap";
import Axios from "axios";
import Swal from "sweetalert2";

export const CorteMensual = ({ asegurados, empresa_id  }) => {

    const { usuario } = JSON.parse(sessionStorage.getItem('data'));

    const [loading, setLoading] = useState(false);
    const [form, setForm] = useState({
        mes: moment().format('M').toString(),
        ano: moment().format('Y').toString()
    });

    const handleMonthlySave = e => {
        e.preventDefault();

        setLoading(true);

        Axios.post('/api/corte-sctr', {
            asegurados,
            usuario_id: usuario.id,
            empresa_id,
            mes: form.mes,
            ano: form.ano
        })
            .then(res => {
               console.log(res);

               setLoading(false);

                Swal.fire(`Completados ${res.data.correctos} de ${res.data.total}`, '', 'success');
            })
            .catch(err => {
                console.error(res);
                setLoading(false);

                Swal.fire('Error al completar la operación', '', 'error');
            });
    }

    return (
        <ModalBootstrap
            id="corteMensual"
            title="Corte Mensual"
        >
            <form onSubmit={handleMonthlySave}>
                <div className="form-row">
                    <div className="col-md-6">
                        Empresa: <b>{empresa.find(e => parseInt(e.id) === parseInt(empresa_id)).name}</b>
                    </div>
                    <div className="col-md-6">
                        Cantidad: <span style={{ color: asegurados.length === 0 ? 'red' : 'black' }}><b>{asegurados.length} trabajadores</b></span>
                    </div>
                </div>
                <br />
                <div className="form-row">
                    <div className="col-md-6">
                        Escoja el mes:<br/>
                        <select
                            className="form-control"
                            value={form.mes}
                            onChange={e => setForm({ ...form, mes: e.target.value })}
                        >
                            {[1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12].map(m => (
                                <option value={m} key={m}>{ m }</option>
                            ))}
                        </select>
                    </div>
                    <div className="col-md-6">
                        Escoja el año:<br />
                        <input
                            type="number" className="form-control"
                            value={form.ano} readOnly={true}
                            onChange={e => setForm({ ...form, ano: e.target.value })}
                        />
                    </div>
                </div>
                <br />
                <div className="form-row">
                    <div className="col">
                        <button type="submit" className="btn btn-primary btn-block" disabled={asegurados.length === 0 || loading}>
                            {!loading ? 'Realizar Corte' : (
                                <>
                                    <i className="fas fa-spinner fa-spin" />&nbsp;Cargando
                                </>
                            )}
                        </button>
                    </div>
                </div>
            </form>
        </ModalBootstrap>
    );
}
