import React, { useState, useEffect } from 'react';
import { Tag, Button, Select } from 'antd';
import moment from 'moment';
import Axios from 'axios';
import Swal from 'sweetalert2';

import BuscarTrabajador from '../../shared/BuscarTrabajador';
import { DatosEpp } from './components/DatosEpp';
import { TablaEpp } from './components/TablaEpp';
import Modal from '../../Modal';

export const EPP = () => {

    const { usuario, editar } = JSON.parse(sessionStorage.getItem('data'));

    const [trabajador, setTrabajador] = useState(null);
    const [contratoActivo, setContratoActivo] = useState(null);

    const [form, setForm] = useState({
        usuario_id: usuario.id,
        empresa_id: '',
        nombre_completo: '',
        zona_labor_id: '',
        cuartel_id: '',
        fecha_incidencia: moment().format('YYYY-MM-DD').toString(),
        fecha_solicitud: moment().format('YYYY-MM-DD').toString(),
        motivo: '',
        epps: [],
        mismo_dia: false,
        incidencia_id: '',
        observacion: '',
    });
    const [dataSancion, setDataSancion] = useState({
        id: '',
        tipo: '',
    });
    const [isVisible, setIsVisible] = useState(false);
    const [reloadData, setReloadData] = useState(false);
    const [empresas, setEmpresas] = useState([]);
    const [zonasLabor, setZonasLabor] = useState([]);
    const [cuarteles, setCuarteles] = useState([]);
    const [incidencias, setIncidencias] = useState([]);

    useEffect(() => {
        fetchEmpresas();
        fetchIncidencias();
    }, []);

    useEffect(() => {
        if (form.empresa_id !== '') {
            fetchZonasLabor();
        }
    }, [form.empresa_id]);

    useEffect(() => {
        if (form.empresa_id !== '' && form.zona_labor_id !== '') {
            fetchCuarteles();
        }
    }, [form.empresa_id, form.zona_labor_id]);

    useEffect(() => {
        setForm({
            ...form,
            nombre_completo: trabajador?.nombre ? `${trabajador.nombre} ${trabajador.apellido_paterno} ${trabajador.apellido_materno}` : '',
        });
    }, [trabajador]);

    useEffect(() => {
        setForm({
            ...form,
            empresa_id: contratoActivo ? contratoActivo.empresa_id : '',
            zona_labor_id: contratoActivo ? contratoActivo.zona_labor.id : '',
            cuartel_id: contratoActivo ? contratoActivo.cuartel?.id : '',
        });
    }, [contratoActivo]);

    function clearForm() {
        setForm({
            usuario_id: usuario.id,
            empresa_id: '',
            nombre_completo: '',
            zona_labor_id: '',
            cuartel_id: '',
            fecha_incidencia: moment().format('YYYY-MM-DD').toString(),
            fecha_solicitud: moment().format('YYYY-MM-DD').toString(),
            motivo: '',
            epps: [],
            mismo_dia: false,
            incidencia_id: '',
            observacion: '',
        });
    }

    function fetchEmpresas() {
        Axios.get("/api/empresa")
            .then(res => {
                setEmpresas(res.data);
            })
            .catch(err => {
                console.log(err);
            });
    }

    function fetchZonasLabor() {
        Axios.get(
            `http://192.168.60.16/api/zona-labor/${form.empresa_id}`
        )
            .then(res => {
                // console.log(res);
                setZonasLabor(res.data.data);
            })
            .catch(err => {
                console.log(err);
            });
    }

    function fetchCuarteles() {
        Axios.get(
            `http://192.168.60.16/api/cuartel/${form.empresa_id}/${form.zona_labor_id}`
        )
            .then(res => {
                setCuarteles(res.data.data);
            })
            .catch(err => {
                console.log(err);
            });
    }

    function fetchIncidencias() {
        Axios.get("/api/incidencia")
            .then(res => {
                setIncidencias(res.data);
            })
            .catch(err => {
                console.log(err);
            });
    }

    const handleSubmit = e => {
        e.preventDefault();

        form.trabajador = trabajador;
        form.regimen = contratoActivo?.regimen || null;
        form.oficio = contratoActivo?.oficio || null;
        form.usuario_id = usuario.id;

        const z = zonasLabor.find(e => e.id == form.zona_labor_id);
        const c = cuarteles.find(e => e.id == form.cuartel_id);

        form.zona_labor = z;
        form.cuartel = c;

        Swal.fire({
            onBeforeOpen: () => {
                Swal.showLoading();
            },
            title: 'Guardando ...'
        });

        Axios.post('/api/sancion-epp', {...form})
            .then(res => {
                console.log(res.data);

                const { id, message, error, info_sancion  } = res.data;

                setReloadData(!reloadData);

                Swal.fire({
                    title: message,
                    icon: error ? 'error' : 'success'
                })
                .then(() => {
                    if (info_sancion?.generar) {
                        setIsVisible(true);
                        setDataSancion({
                            id: id,
                            ...info_sancion
                        });
                        setForm({
                            ...form,
                            incidencia_id: info_sancion.incidencia_id
                        });
                    } else {
                        clearForm();
                    }
                });
            })
            .catch(err => {
                console.log(err, err.response);
                if (err.response.status < 500) {
                    Swal.fire({
                        title: err.response.data.error,
                        icon: 'error'
                    });
                    return;
                }
            });
    };

    const generarSancion = e => {
        e.preventDefault();

        e.preventDefault();

        form.trabajador = trabajador;
        form.regimen = contratoActivo?.regimen || null;
        form.oficio = contratoActivo?.oficio || null;
        form.usuario_id = usuario.id;

        const z = zonasLabor.find(e => e.id == form.zona_labor_id);
        const c = cuarteles.find(e => e.id == form.cuartel_id);

        form.zona_labor = z;
        form.cuartel = c;

        Swal.fire({
            onBeforeOpen: () => {
                Swal.showLoading();
            },
            title: 'Guardando ...'
        });

        Axios.post(`/api/sancion-epp/${dataSancion.id}/generar-sancion`, {...form})
            .then(res => {
                console.log(res.data);

                const { id, message, error } = res.data;

                setReloadData(!reloadData);

                Swal.fire({
                    title: message,
                    icon: error ? 'error' : 'success'
                })
                .then(() => {
                    setReloadData(!reloadData);
                    setIsVisible(false);
                    clearForm();
                });
            })
            .catch(err => {
                console.log(err, err.response);
                if (err.response.status < 500) {
                    Swal.fire({
                        title: err.response.data.error,
                        icon: 'error'
                    });
                    return;
                }
            });
    };

    return (
        <>
            <div className="mb-3">
                <h4>EPP</h4>
            </div>
            <BuscarTrabajador
                setTrabajador={setTrabajador}
                setContratoActivo={setContratoActivo}
                jornal={true}
            />
            <DatosEpp
                handleSubmit={handleSubmit}
                trabajador={trabajador}
                contratoActivo={contratoActivo}
                form={form}
                setForm={setForm}
                empresas={empresas}
                zonasLabor={zonasLabor}
                cuarteles={cuarteles}
            />
            <hr />
            <TablaEpp
                reloadData={reloadData}
                setReloadData={setReloadData}
            />
            <Modal
                isVisible={isVisible}
                setIsVisible={setIsVisible}
                title="Generar Suspención/Memorandum"
            >
                <p>Debido a las reiteradas faltas se le va a generar a este trabajador un(a) <Tag>{ dataSancion?.tipo }</Tag></p>
                <form onSubmit={generarSancion}>
                    <div className="row">
                        <div className="col-md-12">
                            Trabajador:<br />
                            <input
                                type="text"
                                name="nombre_completo"
                                placeholder="Trabajador"
                                readOnly={true}
                                className="form-control"
                                value={form.nombre_completo}
                                onChange={e =>
                                    setForm({
                                        ...form,
                                        nombre_completo: e.target.value
                                    })
                                }
                            />
                        </div>
                        <div className="col-md-12">
                            Incidencia:<br />
                            <Select
                                value={form.incidencia_id}
                                showSearch
                                size="small"
                                optionFilterProp="children"
                                filterOption={(input, option) =>
                                    option.children
                                        .toLowerCase()
                                        .indexOf(input.toLowerCase()) >= 0
                                }
                                onChange={e => setForm({ ...form, incidencia_id: e })}
                                style={{
                                    width: "100%"
                                }}
                            >
                                {incidencias.map(e => (
                                    <Select.Option value={e.id} key={e.id}>
                                        {`${e.name}`}
                                    </Select.Option>
                                ))}
                            </Select>
                        </div>
                        <div className="col-md-12">
                            <div className="form-group">
                                Observación:
                                <br />
                                <textarea
                                    className="form-control"
                                    value={form.observacion}
                                    onChange={e =>
                                        setForm({ ...form, observacion: e.target.value })
                                    }
                                />
                            </div>
                        </div>
                    </div>
                    <br />
                    <div className="row">
                        <div className="col">
                            <Button
                                htmlType="submit"
                                block
                                type="primary"
                            >
                                Registrar
                            </Button>
                        </div>
                    </div>
                </form>
            </Modal>
        </>
    );
}
