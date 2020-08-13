import React, { useState, useEffect } from 'react';
import Axios from 'axios';
import {Select} from "antd";

export const DatosSancion = ({
    handleSubmit,
    form,
    setForm,
    incidencias,
    setIncidencias,
    zonasLabor,
    setZonasLabor,
    cuarteles,
    setCuarteles,
}) => {

    const [empresas, setEmpresas] = useState([]);
    const [loading, setLoading] = useState({
        empresas: false,
        incidencias: false,
    });

    const [loadingZonasLabor, setLoadingZonasLabor] = useState(false);
    const [loadingCuarteles, setLoadingCuarteles] = useState(false);

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

    useEffect(() => {
        if (form.empresa_id !== '') {
            let intento2 = 0;
            function fetchZonasLabor() {
                intento2++;
                Axios.get(`http://192.168.60.16/api/zona-labor/${form.empresa_id}`)
                    .then(res => {
                        console.log(res);
                        setZonasLabor(res.data.data);
                        setLoadingZonasLabor(false);
                    })
                    .catch(err => {
                        console.log(err);
                        if (intento2 < 5) {
                            fetchZonasLabor();
                        }
                    })
            }

            fetchZonasLabor();
            setLoadingZonasLabor(true);
        }
    }, [form.empresa_id]);

    useEffect(() => {
        if (form.zona_labor_id !== '' && form.empresa_id !== '') {
            let intento = 0;
            function fetchCuarteles() {
                intento++;
                Axios.get(`http://192.168.60.16/api/cuartel/${form.empresa_id}/${form.zona_labor_id}`)
                    .then(res => {
                        console.log(res);
                        setCuarteles(res.data.data);
                        setLoadingCuarteles(false);
                    })
                    .catch(err => {
                        console.log(err);
                        if (intento < 5) {
                            fetchCuarteles();
                        }
                    });
            }

            setLoadingCuarteles(true);
            fetchCuarteles();
        }
    }, [form.empresa_id, form.zona_labor_id]);

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
                        <option value="" key="0" disabled />
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
                        name="incidencia_id" placeholder="Incidencia"
                        className="form-control"
                        value={form.incidencia_id}
                        onChange={e => setForm({ ...form, incidencia_id: e.target.value })}
                    >
                        <option value="" key="0" disabled />
                        {incidencias.map(e => <option value={e.id} key={e.id}>{e.name}</option>)}
                    </select>
                </div>
                <div className="form-group col-md-6 col-lg-4">
                    Tipo documento: <br />
                    <input
                        type="text" name="tipo_documento" placeholder="Tipo Documento" readOnly={true}
                        className="form-control"
                        value={form.tipo_documento}
                        onChange={e => setForm({ ...form, tipo_documento: e.target.value })}
                    />
                </div>
            </div>
            <div className="row">
                <div className="form-group col-md-6 col-lg-6">
                    {loadingZonasLabor ? (
                        <div className="spinner-grow text-info" />
                    ) : (
                        <>
                            Zona labor:<br />
                            <Select
                                value={form.zona_labor_id}
                                showSearch
                                optionFilterProp="children"
                                filterOption={(input, option) =>
                                    option.children
                                        .toLowerCase()
                                        .indexOf(input.toLowerCase()) >= 0
                                }
                                onChange={e => setForm({ ...form, zona_labor_id: e })}
                                style={{
                                    width: '100%',
                                }}
                            >
                                {zonasLabor.map(e => (
                                    <Select.Option value={e.id} key={e.id}>
                                        {`${e.id} - ${e.name}`}
                                    </Select.Option>
                                ))}
                            </Select>
                        </>
                    )}
                </div>
                <div className="form-group col-md-6 col-lg-6">
                    {loadingCuarteles ? (
                        <div className="spinner-grow text-info" />
                    ) : (
                        <>
                            Área/Campo:<br />
                            <Select
                                value={form.cuartel_id}
                                showSearch
                                optionFilterProp="children"
                                filterOption={(input, option) =>
                                    option.children
                                        .toLowerCase()
                                        .indexOf(input.toLowerCase()) >= 0
                                }
                                onChange={e => setForm({ ...form, cuartel_id: e })}
                                style={{
                                    width: '100%',
                                }}
                            >
                                {cuarteles.map(e => (
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
                    />
                </div>
            </div>
            <div className="row">
                <div className="col">
                    <button
                        type="submit" className="btn btn-primary btn-block"
                        disabled={form.incidencia_id === '' || form.empresa_id === '' || form.nombre_completo === ''}
                    >
                        Registrar
                    </button>
                </div>
            </div>
        </form>
    );
}
