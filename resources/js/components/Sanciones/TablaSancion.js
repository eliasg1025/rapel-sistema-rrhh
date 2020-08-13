import React, { useState, useEffect } from 'react';
import moment from 'moment';
import { DatePicker, message, Tooltip } from 'antd';
import { MDBDataTableV5 } from 'mdbreact';
import Axios from 'axios';
import Swal from 'sweetalert2';

export const TablaSancion = ({ reloadDatos, setReloadDatos }) => {
    const { usuario } = JSON.parse(sessionStorage.getItem('data'));
    const [filtro, setFiltro] = useState({
        desde: moment().format('YYYY-MM-DD').toString(),
        hasta: moment().format('YYYY-MM-DD').toString(),
        estado: 0,
        incidencia_id: '0',
    });

    let _columns = [];
    if ( usuario.sanciones == 1 ) {
        _columns = [
            {
                label: 'Fecha Solicitud',
                field: 'fecha_solicitud'
            },
            {
                label: 'RUT',
                field: 'rut',
                sort: 'disabled'
            },
            {
                label: 'Trabajador',
                field: 'nombre_completo',
                sort: 'disabled',
                width: 270,
            },
            {
                label: 'Empresa',
                field: 'empresa',
                sort: 'disabled',
                width: 150,
            },
            {
                label: 'Incidencia',
                field: 'incidencia',
            },
            {
                label: 'Fecha Incidencia',
                field: 'fecha_incidencia',
            },
            {
                label: 'Tipo',
                field: 'documento'
            },
            {
                label: 'Predio',
                field: 'zona_labor'
            },
            {
                label: 'Observación',
                field: 'observacion'
            },
            {
                label: 'Acciones',
                field: 'acciones',
                sort: 'disabled'
            }
        ]
    } else {
        _columns = [
            {
                label: 'Fecha Solicitud',
                field: 'fecha_solicitud'
            },
            {
                label: 'RUT',
                field: 'rut',
                sort: 'disabled'
            },
            {
                label: 'Trabajador',
                field: 'nombre_completo',
                sort: 'disabled',
                width: 270,
            },
            {
                label: 'Empresa',
                field: 'empresa',
                sort: 'disabled',
                width: 150,
            },
            {
                label: 'Incidencia',
                field: 'incidencia',
            },
            {
                label: 'Fecha Incidencia',
                field: 'fecha_incidencia',
            },
            {
                label: 'Tipo',
                field: 'documento'
            },
            {
                label: 'Predio',
                field: 'zona_labor'
            },
            {
                label: 'Cargado por',
                field: 'nombre_completo_usuario'
            },
            {
                label: 'Observación',
                field: 'observacion'
            },
            {
                label: 'Acciones',
                field: 'acciones',
                sort: 'disabled'
            }
        ]
    }

    const [datatable, setDatatable] = useState({
        columns: _columns,
        rows: []
    });

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
                            acciones: (
                                <div className="btn-group">
                                    <Tooltip title="Ver documento">
                                        <a className="btn btn-primary btn-sm" href={`/ficha/sancion/${item.id}`} target="_blank">
                                            <i className="fas fa-search"/>
                                        </a>
                                    </Tooltip>
                                    {item.estado == 0 && (
                                        <>
                                            <Tooltip title="Editar Sancion">
                                                <a className="btn btn-primary btn-sm" href={`/sanciones/editar/${item.id}`} target="_blank">
                                                    <i className="far fa-edit" />
                                                </a>
                                            </Tooltip>
                                            <Tooltip title="Marca como ENVIADO">
                                                <button className="btn btn-outline-warning btn-sm" onClick={() => handleMarcarEnviado(item.id)}>
                                                    <i className="fas fa-check" />
                                                </button>
                                            </Tooltip>
                                            {item.fecha_solicitud === moment().format('DD-MM-YYYY') && (
                                                <Tooltip title="Eliminar">
                                                    <button className="btn btn-danger btn-sm" onClick={() => handleEliminar(item.id)}>
                                                        <i className="fas fa-trash-alt" />
                                                    </button>
                                                </Tooltip>
                                            )}
                                        </>
                                    )}
                                    {(item.estado == 1 && usuario.sanciones == 2) && (
                                        <Tooltip title="Marca como SUBIDO">
                                            <button className="btn btn-outline-warning btn-sm" onClick={() => handleMarcarSubido(item.id)}>
                                                <i className="fas fa-check" />
                                            </button>
                                        </Tooltip>
                                    )}
                                </div>
                            )
                        }
                    });

                    setDatatable({
                        ...datatable,
                        rows: formularios
                    });
                })
                .catch(err => {
                    console.log(err);
                    if (intentos < 3) {
                        fetchSanciones();
                    }
                });
        }

        fetchSanciones();
    }, [ filtro, reloadDatos ]);

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
                responsable: '',
                dni: item.rut,
                desde: item.desde,
                hasta: item.hasta,
                motivo_permiso: '',
                predio: item.zona_labor_id,
                horas: item.horas > 8 ? 8 : item.horas,
                hora_salida: '',
                hora_regreso: '',
                tipo: item.documento,
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
            <br />
            <div className="row">
                <div className="col-md-4">
                    <button className="btn btn-success btn-sm" onClick={handleExportar}>
                        <i className="fas fa-file-excel"></i> Exportar
                    </button>
                </div>
            </div>
            <br />
            <MDBDataTableV5
                hover
                responsive
                entriesOptions={[10, 20, 25]}
                small
                entries={10}
                pagesAmount={10}
                data={datatable}
                searchTop
                searchBottom={false}
                className="text-small"
            />
        </>
    );
}
