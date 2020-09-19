import React, { useState, useEffect } from 'react';
import moment from 'moment';
import { DatePicker, Input, message } from 'antd';
import Axios from 'axios';
import Swal from 'sweetalert2';
import { TablaFP } from './TablaFP';
import {TablaR} from "../ReseteoClave/TablaR";

export const TablaFormulariosPermisos = ({ reloadDatos, setReloadDatos }) => {
    const { usuario } = JSON.parse(sessionStorage.getItem('data'));
    const [filtro, setFiltro] = useState({
        desde: moment().format('YYYY-MM-DD').toString(),
        hasta: moment().format('YYYY-MM-DD').toString(),
        estado: 0,
        goce: 2,
        usuario_carga_id: 0,
        rut: '',
    });

    const [data, setData] = useState([]);
    const [usuariosCarga, setUsuariosCarga] = useState([]);

    const handleExportar = (selected=[]) => {
        const headings = [
            'EMPRESA',
            'CON DIGITACION',
            'COD.',
            'APELLIDOS Y NOMBRES',
            'RESPONSABLE',
            'DNI',
            'DESDE',
            'HASTA',
            'MOTIVO DEL PERMISO',
            'PREDIO',
            'HORAS',
            'HORA SALIDA',
            'HORA REGRESO',
            'CON GOCE',
            'CARGADO POR',
            'FECHA SOLICITUD',
            'HORA SOLICITUD',
            'FECHA HORA ENVIADO',
            'FECHA HORA RECEPCIONADO'
        ];

        let origen_datos;
        if (selected.length === 0) {
            origen_datos = data;
        } else {
            origen_datos = data.filter(e => selected.includes(e.id));
        }

        const d = origen_datos.map(item => {
            return {
                empresa: item.empresa,
                con_digitacion: item.jornal ? 'SI' : 'NO',
                cod: item.code,
                apellidos_nombres: item.nombre_completo,
                responsable: item.nombre_completo_jefe,
                dni: item.rut,
                desde: item.fecha_salida,
                hasta: item.fecha_regreso,
                motivo_permiso: item.motivo_permiso_id,
                predio: item.zona_labor_id,
                horas: item.horas > 8 ? 8 : item.horas,
                hora_salida: item.hora_salida,
                hora_regreso: item.hora_regreso,
                con_goce: item.goce == 0 ? 'NO' : 'SI',
                cargado_por: item.nombre_completo_usuario || '',
                fecha_solicitud: item.fecha_solicitud,
                hora_solicitud: item.hora,
                fecha_hora_enviado: item.fecha_hora_enviado,
                fecha_hora_recepcionado: item.fecha_hora_recepcionado,
            };
        });

        Axios({
            url: '/descargar/formularios',
            data: {headings, data: d},
            method: 'POST',
            responseType: 'blob'
        })
            .then(response => {
                console.log(response);
                let blob = new Blob([response.data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' })
                let link = document.createElement('a')
                link.href = window.URL.createObjectURL(blob)
                link.download = `FORMULARIOS_PERMISO-${filtro.estado == 0 ? "NO_ENVIADOS" : "ENVIADOS"}-${filtro.desde}-${filtro.hasta}.xlsx`
                link.click();
            });
    }

    const handleEliminar = id => {
        Swal.fire({
            title: '¿Deseas eliminar este registro?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, borrarlo',
            cancelButtonText: 'Cancelar'
        })
            .then(result => {
                if (result.value) {
                    Axios.delete(`/api/formulario-permiso/${id}`)
                        .then(res => {
                            Swal.fire({
                                title: res.data.message,
                                icon: res.status < 400 ? 'success' : 'error'
                            })
                            .then(() => setReloadDatos(!reloadDatos));
                        })
                        .catch(err => {
                            console.log(err.response);

                            if (usuario.permisos == 2) {
                                Swal.fire({
                                    title: 'Este formulario es de un día anterior. ¿Estás seguro que deseas eliminarlo?',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Si, borrarlo',
                                    cancelButtonText: 'Cancelar'
                                })
                                    .then(result => {
                                        if (result.value) {
                                            Axios.delete(`/api/formulario-permiso/${id}/admin`)
                                            .then(res => {
                                                Swal.fire({
                                                    title: res.data.message,
                                                    icon: res.status < 400 ? 'success' : 'error'
                                                })
                                                .then(() => setReloadDatos(!reloadDatos));
                                            })
                                        }
                                    });
                                return;
                            } else {
                                Swal.fire({
                                    title: err.response.data.message,
                                    icon: 'error'
                                });
                                return;
                            }
                        });
                }
            });
    }

    const handleMarcarFirmado = id => {
        Swal.fire({
            title: '¿Se firmó este formulario?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'Cancelar'
        })
            .then(result => {
                if (result.value) {
                    Axios.put(`/api/formulario-permiso/marcar-firmado/${id}`, {
                        usuario_id: usuario.id
                    })
                        .then(res => {
                            Swal.fire({
                                title: res.data.message,
                                icon: res.status < 400 ? 'success' : 'error'
                            })
                                .then(() => setReloadDatos(!reloadDatos));
                        })
                        .catch(err => {
                            console.error(err);
                            Swal.fire({
                                title: err.response.data.message,
                                icon: 'error'
                            })
                        });
                }
            })
    }

    const handleMarcarEnviado = id => {
        Swal.fire({
            title: '¿Se envió este formulario?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'Cancelar'
        })
            .then(result => {
                if (result.value) {
                    Axios.put(`/api/formulario-permiso/marcar-enviado/${id}`, {
                        usuario_id: usuario.id
                    })
                        .then(res => {
                            Swal.fire({
                                title: res.data.message,
                                icon: res.status < 400 ? 'success' : 'error'
                            })
                                .then(() => setReloadDatos(!reloadDatos));
                        })
                        .catch(err => {
                            console.error(err);
                            Swal.fire({
                                title: err.response.data.message,
                                icon: 'error'
                            })
                        });
                }
            })
    }

    const handleMarcarCargado = id => {
        Swal.fire({
            title: '¿Se cargó este formulario?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'Cancelar'
        })
            .then(result => {
                if (result.value) {
                    Axios.put(`/api/formulario-permiso/marcar-cargado/${id}`, {
                        usuario_id: usuario.id
                    })
                        .then(res => {
                            Swal.fire({
                                title: res.data.message,
                                icon: res.status < 400 ? 'success' : 'error'
                            })
                                .then(() => setReloadDatos(!reloadDatos));
                        })
                        .catch(err => {
                            console.error(err);
                            Swal.fire({
                                title: err.response.data.message,
                                icon: 'error'
                            })
                        });
                }
            })
    }

    const handleMarcarRecepcionado = id => {
        Swal.fire({
            title: '¿Se recepcionó este formulario?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'Cancelar'
        })
            .then(result => {
                if (result.value) {
                    Axios.put(`/api/formulario-permiso/marcar-recepcionado/${id}`, {
                        usuario_id: usuario.id
                    })
                        .then(res => {
                            Swal.fire({
                                title: res.data.message,
                                icon: res.status < 400 ? 'success' : 'error'
                            })
                                .then(() => setReloadDatos(!reloadDatos));
                        })
                        .catch(err => {
                            console.error(err);
                            Swal.fire({
                                title: err.response.data.message,
                                icon: 'error'
                            })
                        });
                }
            })
    }

    useEffect(() => {
        let intentos = 0;
        function fetchFormulariosPermisos() {
            intentos++;
            Axios.post('/api/formulario-permiso/get-all', {...filtro, usuario_id: usuario.id})
                .then(res => {
                    const { data } = res;

                    message['success']({
                        content: `Se encontraron ${data.length} registros`
                    });

                    const formularios = data.map(item => {
                        return {
                            ...item,
                            key: item.id,
                            fecha_solicitud: `${item.fecha_solicitud} ${item.hora}`,
                            desde: `${item.fecha_salida} ${item.hora_salida}`,
                            hasta: `${item.fecha_regreso} ${item.hora_regreso}`,
                        }
                    });

                    setData(formularios);
                })
                .catch(err => {
                    console.log(err);
                    if (intentos < 3) {
                        fetchFormulariosPermisos();
                    }
                });
        }

        if (filtro.rut === '' || filtro.rut.length >= 8) {
            fetchFormulariosPermisos();
        }
    }, [ filtro.desde, filtro.hasta, filtro.estado, filtro.goce, filtro.usuario_carga_id, filtro.rut, reloadDatos ]);

    useEffect(() => {
        setFiltro({ ...filtro, usuario_carga_id: 0 });
        let intentos = 0;
        function fetchUsuariosCarga() {
            intentos++;
            Axios.post('/api/formulario-permiso/get-usuarios-carga', {
                desde: filtro.desde,
                hasta: filtro.hasta,
                estado: filtro.estado,
                goce: filtro.goce
            })
                .then(res => setUsuariosCarga(res.data))
                .catch(err => {
                    if (intentos < 5) {
                        fetchUsuariosCarga();
                    }
                    console.error(err)
                });
        }
        fetchUsuariosCarga();
    }, [filtro.desde, filtro.hasta, filtro.goce, filtro.estado]);

    return (
        <>
            <div className="row">
                <div className="col-md-4">
                    Desde - Hasta:<br />
                    <DatePicker.RangePicker
                        style={{ width: '100%' }}
                        placeholder={['Desde', 'Hasta']}
                        onChange={(date, dateString) => {
                            setFiltro({
                                ...filtro,
                                desde: dateString[0],
                                hasta: dateString[1],
                            });
                        }}
                        value={[moment(filtro.desde), moment(filtro.hasta)]}
                    />
                </div>
                <div className="col-md-4">
                    Estado:<br />
                    <select
                        className="form-control"
                        value={filtro.estado}
                        onChange={e => setFiltro({ ...filtro, estado: e.target.value })}
                    >
                        <option value="0">GENERADOS</option>
                        <option value="2">ENVIADO</option>
                        <option value="3">RECEPCIONADO</option>
                    </select>
                </div>
                <div className="col-md-4">
                    Busqueda por DNI:<br />
                    <Input
                        size="small"
                        placeholder="Mínimo 8 caracteres"
                        value={filtro.rut}
                        onChange={e => setFiltro({ ...filtro, rut: e.target.value })}
                        allowClear
                    />
                </div>
            </div>
            <div className="row">
                <div className="col-md-4">
                    ¿Con goce?<br />
                    <select
                        className="form-control"
                        value={filtro.goce}
                        onChange={e => setFiltro({ ...filtro, goce: e.target.value })}
                    >
                        <option value="2">-</option>
                        <option value="0">NO</option>
                        <option value="1">SI</option>
                    </select>
                </div>
                {usuario.permisos === 2 && (
                    <div className="col-md-4">
                        Cargado por:<br />
                        <select
                            className="form-control"
                            value={filtro.usuario_carga_id}
                            onChange={e => setFiltro({ ...filtro, usuario_carga_id: e.target.value})}
                        >
                            <option value={0} key={0}>TODOS</option>
                            {usuariosCarga.map(option => <option value={option.id} key={option.id}>{ `${option.nombre_completo}` }</option>)}
                        </select>
                    </div>
                )}
            </div>
            <br />
            <div className="row">
                <div className="col-md-4">
                    <button className="btn btn-success btn-sm" onClick={() => handleExportar([])}>
                        <i className="fas fa-file-excel"></i> Exportar TODOS
                    </button>
                </div>
            </div>
            <br />
            <TablaFP
                data={data}
                filtro={filtro}
                handleEliminar={handleEliminar}
                handleMarcarFirmado={handleMarcarFirmado}
                handleMarcarEnviado={handleMarcarEnviado}
                handleMarcarRecepcionado={handleMarcarRecepcionado}
                handleMarcarCargado={handleMarcarCargado}
                handleExportar={handleExportar}
                setReloadDatos={setReloadDatos}
                reloadDatos={reloadDatos}
            />
        </>
    );
}
