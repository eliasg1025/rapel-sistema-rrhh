import React, { useState } from 'react';
import moment from 'moment';

export const Sincronizar = () => {

    const [form, setForm] = useState({
        empresa_id: 9,
        periodo: moment().format('YYYY-MM').toString()
    });

    const handleSubmit = e => {
        e.preventDefault();
        console.log(form);
    }

    return (
        <div className="card">
            <div className="card-header">
                <h6>Sincronización DB</h6>
            </div>
            <div className="card-body">
                <form onSubmit={handleSubmit}>
                    <div className="form-row">
                        <div className="col">
                            <div className="form-group">
                                <select
                                    value={form.empresa_id}
                                    onChange={e => setForm({
                                        ...form,
                                        empresa_id: e.target.value
                                    })}
                                    className="form-control"
                                >
                                    <option key="9" value="9">RAPEL</option>
                                    <option key="14" value="14">VERFRUT</option>
                                </select>
                            </div>
                        </div>
                        <div className="col">

                        </div>
                    </div>
                    <div className="form-row">
                        <div className="col">
                            <button type="submit" className="btn btn-primary">
                                Cargar liquidaciones
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    );
}
