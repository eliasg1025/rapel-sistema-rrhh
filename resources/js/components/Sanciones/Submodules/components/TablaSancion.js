import React, { useState, useEffect } from 'react';
import moment from 'moment';
import { DatePicker, message, Tooltip } from 'antd';
import { MDBDataTableV5 } from 'mdbreact';
import Axios from 'axios';
import Swal from 'sweetalert2';
import {TablaS} from "./TablaS";

export const TablaSancion = ({ reloadDatos, setReloadDatos }) => {
    const { usuario } = JSON.parse(sessionStorage.getItem('data'));
    const [filtro, setFiltro] = useState({
        desde: moment().format('YYYY-MM-DD').toString(),
        hasta: moment().format('YYYY-MM-DD').toString(),
        estado: 0,
        incidencia_id: '0',
        usuario_carga_id: 0,
    });
    const [usuariosCarga, setUsuariosCarga] = useState([]);
    const [data, setData] = useState([]);

    useEffect(() => {
        let intentos = 0;
        function fetchSanciones() {
            intentos++;
            Axios.post('/api/sancion/get-all', {...filtro, usuario_id: usuario.id})
                .then(res => {
                    const { data } = res;

                    message['success']({
                        content: `Se encontraron ${data.length} registros`
                    });

                    const formularios = data.map(item => {
                        return {
                            ...item,
                            key: item.id,
                            fecha_solicitud: `${item.fecha_solicitud}`,
                            desde: `${item.fecha_salida} ${item.hora_salida}`,
                            hasta: `${item.fecha_regreso} ${item.hora_regreso}`,
                        }
                    });

                    setData(formularios);
                })
                .catch(err => {
                    console.log(err);
                    if (intentos < 3) {
                        fetchSanciones();
                    }
                });
        }

        fetchSanciones();
    }, [ filtro.desde, filtro.hasta, filtro.estado, filtro.incidencia_id, filtro.usuario_carga_id, reloadDatos ]);

    useEffect(() => {
        setFiltro({ ...filtro, usuario_carga_id: 0 });
        let intentos = 0;
        function fetchUsuariosCarga() {
            intentos++;
            Axios.post('/api/sancion/get-usuarios-carga', {
                desde: filtro.desde,
                hasta: filtro.hasta,
                estado: filtro.estado,
                incidencia_id: filtro.incidencia_id
            })
                .then(res => {
                   setUsuariosCarga(res.data);
                })
                .catch(err => {
                    if (intentos < 5) {
                        fetchUsuariosCarga();
                    }
                    console.error(err)
                });
        }

        fetchUsuariosCarga();
    }, [filtro.desde, filtro.hasta, filtro.estado]);

    const handleExportar = () => {
        console.log(datatable.rows);
        const headings = [
            'EMPRESA',
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
            'TIPO',
            'REGIMEN',
            'OFICIO',
            'CARGADO POR',
            'FECHA SOLICITUD',
            'INCIDENCIA',
            'OBSERVACION',
        ];

        const data = datatable.rows.map(item => {
            return {
                empresa: item.empresa,
                cod: item.code,
                apellidos_nombres: item.nombre_completo,
                responsable: 'RRHH',
                dni: item.rut,
                desde: item.desde,
                hasta: item.hasta,
                motivo_permiso: '',
                predio: item.zona_labor_id,
                horas: item.horas > 8 ? 8 : item.horas,
                hora_salida: '',
                hora_regreso: '',
                tipo: item.documento,
                regimen: item.regimen,
                oficio: item.oficio,
                cargado_por: item.nombre_completo_usuario || '',
                fecha_solicitud: item.fecha_solicitud,
                incidencia: item.incidencia,
                observacion: item.observacion
            };
        });

        Axios({
            url: '/descargar',
            data: {headings, data},
            method: 'POST',
            responseType: 'blob'
        })
            .then(response => {
                console.log(response);
                let blob = new Blob([response.data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' })
                let link = document.createElement('a')
                link.href = window.URL.createObjectURL(blob)
                link.download = `SANCIONES-${filtro.estado == 0 ? "NO_ENVIADO" : "ENVIADOS"}-${filtro.desde}-${filtro.hasta}.xlsx`
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
                    Axios.delete(`/api/sancion/${id}`)
                        .then(res => {
                            Swal.fire({
                                title: res.data.message,
                                icon: res.status < 400 ? 'success' : 'error'
                            })
                                .then(() => setReloadDatos(!reloadDatos));
                        })
                        .catch(err => {
                            console.log(err);
                            Swal.fire({
                                title: 'Error al borrar el registro',
                                icon: 'error'
                            });
                        });
                }
            });
    }

    const handleMarcarEnviado = id => {
        Swal.fire({
            title: '¿Se envió este documento?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'Cancelar'
        })
            .then(result => {
                if (result.value) {
                    Axios.put(`/api/sancion/marcar-enviado/${id}`, {
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

    const handleMarcarSubido = id => {
        Swal.fire({
            title: '¿Se cargó este documento?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'Cancelar'
        })
            .then(result => {
                if (result.value) {
                    Axios.put(`/api/sancion/marcar-subido/${id}`, {
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
            });
    }

    return (
        <>
            <div className="row">
                <div className="col-md-4">
                    Desde - Hasta:<br />
                    <DatePicker.RangePicker
                        placeholder={['Desde', 'Hasta']}
                        style={{ width: '100%' }}
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
                    Tipo documento:<br />
                    <select
                        className="form-control"
                        value={filtro.incidencia_id}
                        onChange={e => setFiltro({ ...filtro, incidencia_id: e.target.value })}
                    >
                        <option value="0">TODOS</option>
                        <option value="1">MEMORANDUM</option>
                        <option value="2">SUSPENCION</option>
                    </select>
                </div>
                <div className="col-md-4">
                    Estado:<br />
                    <select
                        className="form-control"
                        value={filtro.estado}
                        onChange={e => setFiltro({ ...filtro, estado: e.target.value })}
                    >
                        <option value="0">GENERADO</option>
                        <option value="1">ENVIADO</option>
                        <option value="2">SUBIDO</option>
                    </select>
                </div>
            </div>
            <div className="row">
                {usuario.sanciones === 2 && (
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
                    <button className="btn btn-success btn-sm" onClick={handleExportar}>
                        <i className="fas fa-file-excel" /> Exportar
                    </button>
                </div>
            </div>
            <br />
            <TablaS
                sanciones={data}
                filtro={filtro}
                handleEliminar={handleEliminar}
                handleMarcarEnviado={handleMarcarEnviado}
                handleMarcarSubido={handleMarcarSubido}
            />
        </>
    );
}
