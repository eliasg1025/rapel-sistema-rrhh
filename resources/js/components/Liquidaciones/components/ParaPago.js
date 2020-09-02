import React, { useState } from 'react';
import moment from 'moment';
import Axios from 'axios';
import Swal from 'sweetalert2';

export const ParaPago = ({ finiquitos, reloadData, setReloadData }) => {

    const [loading, setLoading] = useState(false);
    const [form, setForm] = useState({
        fecha: moment().format('YYYY-MM-DD').toString()
    });

    const handleSubmit = e => {
        e.preventDefault();

        setLoading(true);
        Axios.post('/api/finiquitos/programar-para-pago', {
            fecha: form.fecha,
            finiquitos
        })
            .then(res => {
                const { message } = res.data;

                setLoading(false);
                Swal.fire(message, '', 'success')
                    .then(res => {
                        setReloadData(!reloadData);
                    });
            })
            .catch(err => {
                console.error(err);
                setLoading(false);
                Swal.fire('Error al actualizar el estado', '', 'error');
            });
    }

    return (
        <form onSubmit={handleSubmit}>
            <div className="form-row">
                <div className="col">
                    <input
                        type="date" className="form-control"
                        value={form.fecha} onChange={e => setForm({ ...form, fecha: e.target.value })}
                    />
                </div>
                <div className="col">
                    <button className="btn btn-primary" type="submit">
                        {!loading ? 'Programar para pago' : (
                            <>
                                <i className="fas fa-spinner fa-spin" />&nbsp;Cargando
                            </>
                        )}
                    </button>
                </div>
            </div>
        </form>
    );
}
