import React, { useState } from 'react';
import moment from 'moment';

export const ParaPago = ({ finiquitos }) => {

    const [form, setForm] = useState({
        fecha: moment().format('YYYY-MM-DD').toString()
    });

    const handleSubmit = e => {
        e.preventDefault();
        console.log({
            fecha: form.fecha,
            finiquitos
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
                        Programar para pago
                    </button>
                </div>
            </div>
        </form>
    );
}
