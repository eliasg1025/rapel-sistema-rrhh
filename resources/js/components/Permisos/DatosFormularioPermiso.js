import React, { useState, useEffect } from 'react';
import Axios from 'axios';
import moment from 'moment';

import AutocompletarTrabajador from '../shared/AutocompletarTrabajador';
import { Select, Tooltip } from 'antd';

const DatosFormularioPermiso = ({
    handleSubmit,
    form,
    setForm,
    horario,
    setHorario,
    motivosPermiso,
    setMotivosPermiso,
    trabajadorJefe,
    setTrabajadorJefe,
    totalHoras,
    errorTotalHoras
}) => {

    const [empresas, setEmpresas] = useState([]);
    const [loading, setLoading] = useState({
        empresas: false,
        motivos: false,
    });
    const [loadingRegistro, setLoadingRegistro] = useState(false);

    useEffect(() => {
        let intento = 0;
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

        fetchEmpresas();
    }, []);

    useEffect(() => {
        if (form.empresa_id !== '') {
            let intento1 = 0;
            function fetchMotivosPermiso(cb) {
                intento1++;
                Axios.get(`http://192.168.60.16/api/motivo-permiso/${form.empresa_id}`)
                    .then(res => {
                        setMotivosPermiso(res.data.data);
                        setLoading({ ...loading, motivos: false });
                    })
                    .catch(err => {
                        console.log(err);
                        if (intento1 < 5) {
                            fetchMotivosPermiso();
                        }
                    });
            }
            setLoading({ ...loading, motivos: true });
            fetchMotivosPermiso();;
        }
    }, [form.empresa_id])

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
                        <option value="" key="0" disabled></option>
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
                    Horario del trabajador&nbsp;
                    <Tooltip title="Ingrese la hora de entrada y salida que tiene el trabajador">
                        <span><i className="far fa-question-circle"></i></span>
                    </Tooltip>: <br />
                    <div className="row">
                        <div className="col">
                            <input
                                type="time" name="horario"
                                className="form-control"
                                value={horario.entrada}
                                onChange={e => setHorario({ ...horario, entrada: e.target.value })}
                            />
                        </div>
                        <div className="col">
                            <input
                                type="time" name="horario"
                                className="form-control"
                                value={horario.salida}
                                onChange={e => setHorario({ ...horario, salida: e.target.value })}
                            />
                        </div>
                    </div>
                </div>
                <div className="form-group col-md-6 col-lg-4">
                    Fecha y hora salida&nbsp;
                    <Tooltip title="DESDE que fecha y hora se considerará en el formulario">
                        <span><i className="far fa-question-circle"></i></span>
                    </Tooltip>
                    :<br />
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
                    Fecha y hora regreso&nbsp;
                    <Tooltip title="HASTA que fecha y hora se considerará en el formulario">
                        <span><i className="far fa-question-circle"></i></span>
                    </Tooltip>
                    :<br />
                    <div className="row">
                        <div className="col">
                            <input
                                type="date" name="fecha_regreso" placeholder="Fecha Regreso"
                                className="form-control" min={form.fecha_salida} max="2500-01-01"
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
            </div>
            <div className="row">
                <div className="form-group col-md-6 col-lg-6">
                    Refrigerio<br />
                    <select
                        className="form-control"
                        value={form.refrigerio}
                        onChange={e => setForm({ ...form, refrigerio: e.target.value })}
                    >
                        <option value={0} key={0}>NO CONSIDERAR</option>
                        <option value={1} key={1}>1 HORA</option>
                        <option value={0.75} key={2}>45 MIN</option>
                    </select>
                </div>
                <div className="form-group col-md-6 col-lg-6">
                    Total horas:<br />
                    <input
                        type="number" name="hp" placeholder="H-P" readOnly={true}
                        className={errorTotalHoras ? "form-control is-invalid" : "form-control is-valid"}
                        value={totalHoras}
                    />
                    {errorTotalHoras && (
                        <div className="invalid-feedback">{ errorTotalHoras }</div>
                    )}
                </div>
            </div>
            <div className="row">
                <div className="form-group col-md-6 col-lg-6">
                    Jefe de Zona/Campo:<br />
                    <AutocompletarTrabajador
                        setTrabajador={setTrabajadorJefe}
                        form={form}
                        setForm={setForm}
                    />
                </div>
                <div className="form-group col-md-6 col-lg-6">
                    {loading.motivos ? (
                        <div className="spinner-grow text-info"></div>
                    ) : (
                        <>
                            Motivo de Permiso&nbsp;
                            <Tooltip title="Todos los motivos de permiso exceptuando el 3 y el 4 cuentan con goce de sueldo">
                                <span><i class="fas fa-info-circle"></i></span>
                            </Tooltip>
                            :<br />
                            <Select
                                value={form.motivo_permiso_id}
                                showSearch
                                optionFilterProp="children"
                                filterOption={(input, option) =>
                                    option.children
                                        .toLowerCase()
                                        .indexOf(input.toLowerCase()) >= 0
                                }
                                onChange={e => setForm({ ...form, motivo_permiso_id: e })}
                                style={{
                                    width: '100%',
                                }}
                            >
                                {motivosPermiso.map(e => (
                                    <Select.Option value={e.id} key={e.id}>
                                        {`${e.id} - ${e.name}`}
                                    </Select.Option>
                                ))}
                            </Select>
                        </>
                    )}
                </div>
            </div>
            <div className="row">
                <div className="form-group col">
                    Observación:<br />
                    <textarea
                        className="form-control"
                        value={form.observacion}
                        onChange={e => setForm({ ...form, observacion: e.target.value })}
                    ></textarea>
                </div>
            </div>
            <div className="row">
                <div className="col">
                    {loadingRegistro ? (
                        <div className="spinner-grow text-info"></div>
                    ) : (
                        <button
                            type="submit" className="btn btn-primary btn-block"
                            disabled={form.motivo_permiso_id == '' || form.empresa_id == '' || totalHoras <= 0 || form.nombre_completo == ''}
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
