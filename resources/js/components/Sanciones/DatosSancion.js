import React, { useState, useEffect } from 'react';
import Axios from 'axios';

export const DatosSancion = ({
    handleSubmit,
    form,
    setForm
}) => {

    const [empresas, setEmpresas] = useState([]);
    const [incidencias, setIncidencias] = useState([]);
    const [loading, setLoading] = useState({
        empresas: false,
        incidencias: false,
    });

    useEffect(() => {
        let intento = 0;
        let intento1 = 0;
        function fetchEmpresas() {
            intento++;
            Axios.get('/api/empresa')
                .then(res => {
                    setEmpresas(res.data);
                    setLoading({ ...loading, empresas: false });
                })
                .catch(err => {
                    if (intento < 5) {
                        fetchEmpresas();
                    }
                });
        }

        function fetchIncidencias() {
            intento1++;
            Axios.get('/api/incidencia')
                .then(res => {
                    setIncidencias(res.data);
                    setLoading({ ...loading, incidencias: false })
                })
                .catch(err => {
                    if (intento1 < 5) {
                        fetchIncidencias();
                    }
                });
        }

        fetchEmpresas();
        fetchIncidencias();
    }, []);

    return (
        <form onSubmit={handleSubmit}>
            <div className="row">
                <div className="form-group col-md-6 col-lg-4">
                    Empresa: <br />
                    <select
                        type="text" name="empresa_id" placeholder="Empresa"
                        className="form-control"
                        value={form.empresa_id}
                        onChange={e => setForm({ ...form, empresa_id: e.target.value })}
                    >
                        <option value="" key="0" disabled></option>
                        {empresas.map(e => <option value={e.id} key={e.id}>{e.id} - {e.name}</option>)}
                    </select>
                </div>
                <div className="form-group col-md-6 col-lg-4">
                    Fecha solicitud: <br />
                    <input
                        type="date" name="fecha_solicitud" placeholder="Fecha Solicitud" readOnly={true}
                        className="form-control"
                        value={form.fecha_solicitud}
                        onChange={e => setForm({ ...form, fecha_solicitud: e.target.value })}
                    />
                </div>
                <div className="form-group col-md-6 col-lg-4">
                    Trabajador: <br/>
                    <input
                        type="text" name="nombre_completo" placeholder="Trabajador" readOnly={true}
                        className="form-control"
                        value={form.nombre_completo}
                        onChange={e => setForm({ ...form, nombre_completo: e.target.value })}
                    />
                </div>
            </div>
            <div className="row">
                <div className="form-group col-md-6 col-lg-4">
                    Fecha incidencia: <br />
                    <input
                        type="date" name="fecha_incidencia" placeholder="Fecha Incidencia"
                        className="form-control"
                        value={form.fecha_incidencia}
                        onChange={e => setForm({ ...form, fecha_incidencia: e.target.value })}
                    />
                </div>
                <div className="form-group col-md-6 col-lg-4">
                    Incidencia: <br />
                    <select
                        type="text" name="incidencia_id" placeholder="Incidencia"
                        className="form-control"
                        value={form.incidencia_id}
                        onChange={e => setForm({ ...form, incidencia_id: e.target.value })}
                    >
                        <option value="" key="0" disabled></option>
                        {incidencias.map(e => <option value={e.id} key={e.id}>{e.name}</option>)}
                    </select>
                </div>
            </div>
            <div className="row">
                <div className="col">
                    <button
                        type="submit" className="btn btn-primary btn-block"
                        disabled={form.incidencia_id == '' || form.empresa_id == '' || form.nombre_completo == ''}
                    >
                        Registrar
                    </button>
                </div>
            </div>
        </form>
    );
}
