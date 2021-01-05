import React, { useState, useEffect } from 'react';
import Axios from 'axios';

export const DatosReseteoClave = ({ contratoActivo, handleSubmit, form, setForm }) => {
    const [empresas, setEmpresas] = useState([]);
    const [loading, setLoading] = useState(false);
    const [validForm, setValidForm] = useState(false);

    useEffect(() => {
        let intento = 0;
        function fetchEmpresas(cb) {
            intento++;
            Axios.get('/api/empresa')
                .then(res => setEmpresas(res.data))
                .catch(err => {
                    if (intento < 5) {
                        fetchEmpresas();
                    }
                })
                .finally(cb);
        }

        setLoading(true);
        fetchEmpresas(() => {
            setLoading(false);
        });
    }, []);

    useEffect(() => {
        if (contratoActivo?.sueldo_bruto >= 2000 || contratoActivo?.zona_labor?.id == 55) {
            if (form.nombre_completo !== '' && form.numero_telefono_trabajador !== '') {
                setValidForm(false);
            } else {
                setValidForm(true);
            }
        } else {
            if (form.nombre_completo !== '') {
                setValidForm(false);
            } else {
                setValidForm(true);
            }
        }
    }, [form, contratoActivo])

    return (
        <form onSubmit={handleSubmit}>
            <div className="row">
                <div className="form-group col-md-6 col-lg-4">
                    Trabajador:<br />
                    <input
                        type="text" name="nombre_completo" placeholder="Trabajador" readOnly={true}
                        className="form-control"
                        value={form.nombre_completo}
                        onChange={e => setForm({ ...form, nombre_completo: e.target.value })}
                    />
                </div>
                <div className="form-group col-md-6 col-lg-4">
                    Fecha Solicitud:<br />
                    <input
                        type="text" name="fecha_solicitud" placeholder="Fecha solicitud" readOnly={true}
                        className="form-control"
                        value={form.fecha_solicitud}
                        onChange={e => setForm({ ...form, fecha_solicitud: e.target.value })}
                    />
                </div>
                <div className="form-group col-md-6 col-lg-4">
                    Empresa:<br />
                    <select
                        name="empresa_id" placeholder="Empresa"
                        className="form-control"
                        value={form.empresa_id}
                        onChange={e => setForm({ ...form, empresa_id: e.target.value })}
                    >
                        {empresas.map(e => <option value={e.id} key={e.id}>{e.id} - {e.name}</option>)}
                    </select>
                </div>
                {(contratoActivo?.sueldo_bruto >= 2000 || contratoActivo?.zona_labor?.id == 55 ) && (
                    <div className="form-group col-md-6 col-lg-4">
                        Telefono Trabajador:<br />
                        <input
                            type="text" name="numero_telefono_trabajador" placeholder="Telefono Trabajador"
                            className="form-control"
                            value={form.numero_telefono_trabajador}
                            onChange={e => setForm({ ...form, numero_telefono_trabajador: e.target.value })}
                        />
                    </div>
                )}
            </div>
            <div className="row">
                <div className="col">
                    {loading ? (
                        <div className="spinner-grow text-info"></div>
                    ) : (
                        <button
                            type="submit" className="btn btn-primary btn-block"
                            disabled={validForm}
                        >
                            Registrar
                        </button>
                    )}
                </div>
            </div>
        </form>
    )
}
