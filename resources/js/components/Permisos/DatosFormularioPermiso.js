import React, { useState, useEffect } from 'react';
import Axios from 'axios';

const DatosFormularioPermiso = ({
    handleSubmit,
    form,
    setForm,
}) => {

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

    return (
        <form onSubmit={handleSubmit}>
            <div className="row">
                <div className="form-group col-md-6 col-lg-4">
                    <select
                        type="text" name="empresa_id" placeholder="Empresa"
                        className="form-control"
                        value={form.empresa_id}
                        onChange={e => setForm({ ...form, empresa_id: e.target.value })}
                    >
                        {empresas.map(e => <option value={e.id} key={e.id}>{e.id} - {e.name}</option>)}
                    </select>
                </div>
                <div className="form-group col-md-6 col-lg-4">
                    <input
                        type="text" name="fecha_solicitud" placeholder="Fecha Solicitud" readOnly={true}
                        className="form-control"
                        value={form.fecha_solicitud}
                        onChange={e => setForm({ ...form, fecha_solicitud: e.target.value })}
                    />
                </div>
                <div className="form-group col-md-6 col-lg-4">
                    <input
                        type="text" name="nombre_completo" placeholder="Trabajador" readOnly={true}
                        className="form-control"
                        value={form.nombre_completo}
                        onChange={e => setForm({ ...form, nombre_completo: e.target.value })}
                    />
                </div>
            </div>
            <div className="row">
                <div className="form-group col-xs-6 col-sm-6 col-md-3 col-lg-2">
                    <input
                        type="date" name="fecha_salida" placeholder="Fecha Salida"
                        className="form-control"
                    />
                </div>
                <div className="form-group col-xs-6 col-sm-6 col-md-3 col-lg-2">
                    <input
                        type="date" name="fecha_salida" placeholder="Fecha Salida"
                        className="form-control"
                    />
                </div>
                <div className="form-group col-xs-6 col-sm-6 col-md-3 col-lg-2">
                    <input
                        type="time" name="hora_salida" placeholder="Hora Salida"
                        className="form-control"
                    />
                </div>
                <div className="form-group col-xs-6 col-sm-6 col-md-3 col-lg-2">
                    <input
                        type="time" name="hora_salida" placeholder="Hora Salida"
                        className="form-control"
                    />
                </div>
                <div className="form-group col-md-6 col-lg-4">
                    <input
                        type="number" name="hp" placeholder="H-P" readOnly={true}
                        className="form-control" min={0}
                    />
                </div>
            </div>
            <div className="row">
                <div className="form-group col-md-6 col-lg-6">
                    <input
                        type="text" name="jefe" placeholder="Jefe de Zona/Campo"
                        className="form-control"
                    />
                </div>
                <div className="form-group col-md-6 col-lg-6">
                    <select
                        type="text" name="motivo_permiso_id" placeholder="Motivo Permiso"
                        className="form-control"
                        value={form.motivo_permiso_id}
                        onChange={e => setForm({ ...form, motivo_permiso_id: e.target.value })}
                    >
                        {[].map(e => <option value={e.id} key={e.id}>{e.id} - {e.name}</option>)}
                    </select>
                </div>
            </div>
        </form>
    );
};

export default DatosFormularioPermiso;
