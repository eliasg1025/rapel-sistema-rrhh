import React, { useState, useEffect } from 'react';
import Axios from 'axios';
import moment from 'moment';
import { trim } from 'jquery';

import AutocompletarTrabajador from '../shared/AutocompletarTrabajador';

const DatosFormularioPermiso = ({
    handleSubmit,
    form,
    setForm,
    hp,
    motivosPermiso,
    setMotivosPermiso,
    setTrabajadorJefe
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

        let intento1 = 0;
        function fetchMotivosPermiso(cb) {
            intento1++;
            Axios.get(`http://192.168.60.16/api/motivo-permiso/${trim(form.empresa_id)}`)
                .then(res => setMotivosPermiso(res.data.data))
                .catch(err => {
                    console.log(err);
                    if (intento1 < 5) {
                        fetchMotivosPermiso();
                    }
                })
                .finally(cb);
        }

        setLoading(true);
        fetchEmpresas(() => {
            setLoading(false);
        });
        fetchMotivosPermiso();
    }, []);

    return (
        <form onSubmit={handleSubmit}>
            <div className="form-row">
                <div className="form-group col-md-6 col-lg-4">
                    Empresa: <br />
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
                    Fecha solicitud: <br />
                    <input
                        type="text" name="fecha_solicitud" placeholder="Fecha Solicitud" readOnly={true}
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
                    <div className="row">
                        <div className="col">
                            <div className="form-check mt-3">
                                <input type="checkbox" className="form-check-input" />
                                <label className="form-check-label">
                                    Considerar refrigerio
                                </label>
                            </div>
                        </div>
                        <div className="col">
                            Hora de entrada:
                            <input
                                type="time" name="horario" placeholder="Hora de entrada"
                                className="form-control"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div className="row">
                <div className="form-group col-md-6 col-lg-4">
                    Fecha y hora salida:<br />
                    <div className="row">
                        <div className="col">
                            <input
                                type="date" name="fecha_salida" placeholder="Fecha Salida"
                                className="form-control" min="2020-01-01" max="2500-01-01"
                                value={form.fecha_salida}
                                onChange={e => setForm({ ...form, [e.target.name]: e.target.value })}
                            />
                        </div>
                        <div className="col">
                            <input
                                type="time" name="hora_salida" placeholder="Hora Salida"
                                className="form-control"
                                value={form.hora_salida}
                                onChange={e => setForm({ ...form, [e.target.name]: e.target.value })}
                            />
                        </div>
                    </div>
                </div>
                <div className="form-group col-md-6 col-lg-4">
                    Fecha y hora regreso:<br />
                    <div className="row">
                        <div className="col">
                            <input
                                type="date" name="fecha_regreso" placeholder="Fecha Regreso"
                                className="form-control" min="2020-06-25" max="2500-01-01"
                                value={form.fecha_regreso}
                                onChange={e => setForm({ ...form, [e.target.name]: e.target.value })}
                            />
                        </div>
                        <div className="col">
                            <input
                                type="time" name="hora_regreso" placeholder="Hora Regreso"
                                className="form-control"
                                value={form.hora_regreso}
                                onChange={e => setForm({ ...form, [e.target.name]: e.target.value })}
                            />
                        </div>
                    </div>
                </div>
                <div className="form-group col-md-6 col-lg-4">
                    Cantidad horas:<br />
                    <input
                        type="number" name="hp" placeholder="H-P" readOnly={true}
                        className="form-control"
                        value={hp || 0}
                    />
                </div>
            </div>
            <div className="row">
                <div className="form-group col-md-6 col-lg-6">
                    Jefe de Zona/Campo:<br />
                    {/*
                        <input
                            type="text" name="jefe" placeholder="Escribe nombre o apellido"
                            className="form-control"
                            value={form.nombre_completo_jefe}
                            onChange={e => setForm({ ...form, nombre_completo_jefe: e.target.value })}
                        />
                        <div className="list-group">
                            {jefes.map(item => <button className="btn" key={item.id}>{item.nombre_completo}</button>)}
                        </div>
                    */}
                    <AutocompletarTrabajador
                        setTrabajador={setTrabajadorJefe}
                    />
                </div>
                <div className="form-group col-md-6 col-lg-6">
                    Motivo de Permiso:<br />
                    <select
                        type="text" name="motivo_permiso_id" placeholder="Motivo Permiso"
                        className="form-control"
                        value={form.motivo_permiso_id}
                        onChange={e => setForm({ ...form, motivo_permiso_id: e.target.value })}
                    >
                        {motivosPermiso.map(e => <option value={e.id} key={e.id}>{e.id} - {e.name}</option>)}
                    </select>
                </div>
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
    );
};

export default DatosFormularioPermiso;
