import React, { useState, useEffect } from 'react';
import moment from 'moment';
import { DatePicker, message, Tooltip } from 'antd';
import { MDBDataTableV5 } from 'mdbreact';
import Axios from 'axios';
import Swal from 'sweetalert2';

export const TablaFormulariosPermisos = ({ reloadDatos, setReloadDatos }) => {
    const { usuario } = JSON.parse(sessionStorage.getItem('data'));
    const [filtro, setFiltro] = useState({
        desde: moment().format('YYYY-MM-DD').toString(),
        hasta: moment().format('YYYY-MM-DD').toString(),
        estado: 0,
        // usuario_carga_id: 0
    });

    let _columns = [];
    if (usuario.permisos == 1) {
        _columns = [
            {
                label: 'Fecha Solicitud',
                field: 'fecha_solicitud'
            },
            {
                label: 'Hora',
                field: 'hora'
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
                label: 'Responsable',
                field: 'nombre_completo_jefe',
            },
            {
                label: 'Desde',
                field: 'desde'
            },
            {
                label: 'Hasta',
                field: 'hasta'
            },
            {
                label: 'Horas',
                field: 'horas'
            },
            {
                label: 'Motivo',
                field: 'motivo_permiso'
            },
            {
                label: 'Predio',
                field: 'zona_labor'
            },
            {
                label: 'Con Goce',
                field: 'goce_checkbox',
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
                label: 'Hora',
                field: 'hora'
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
                label: 'Responsable',
                field: 'nombre_completo_jefe',
            },
            {
                label: 'Desde',
                field: 'desde'
            },
            {
                label: 'Hasta',
                field: 'hasta'
            },
            {
                label: 'Horas',
                field: 'horas'
            },
            {
                label: 'Motivo',
                field: 'motivo_permiso'
            },
            {
                label: 'Predio',
                field: 'zona_labor'
            },
            {
                label: 'Con Goce',
                field: 'goce_checkbox',
            },
            {
                label: 'Cargado por',
                field: 'nombre_completo_usuario'
            },
            {
                label: 'Fecha Firmado',
                field: 'fecha_hora_firmado'
            },
            {
                label: 'Fecha Envio',
                field: 'fecha_hora_enviado',
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

    const handleExportar = () => {
        console.log(datatable.rows);
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
            'FECHA HORA FIRMADO',
            'FECHA HORA ENVIADO'
        ];

        const data = datatable.rows.map(item => {
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
                fecha_hora_firmado: item.fecha_hora_firmado,
                fecha_hora_enviado: item.fecha_hora_enviado
            };
        });

        Axios({
            url: '/descargar/formularios',
            data: {headings, data},
            method: 'POST',
            responseType: 'blob'
        })
            .then(response => {
                console.log(response);
                let blob = new Blob([response.data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' })
                let link = document.createElement('a')
                link.href = window.URL.createObjectURL(blob)
                link.download = `FORMULARIOS_PERMISO-${filtro.estado == 0 ? "NO_FIRMADOS" : "FIRMADOS"}-${filtro.desde}-${filtro.hasta}.xlsx`
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
                            console.log(err);
                            Swal.fire({
                                title: 'Error al borrar el registro',
                                icon: 'error'
                            });
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
                            desde: `${item.fecha_salida} ${item.hora_salida}`,
                            hasta: `${item.fecha_regreso} ${item.hora_regreso}`,
                            goce_checkbox: item.estado == 0 ? (
                                <CheckboxGoce item={item} />
                            ) : (item.goce == 0 ? 'NO' : 'SI'),
                            acciones: (
                                <div className="btn-group">
                                    <Tooltip title="Ver documento">
                                        <a className="btn btn-primary btn-sm" href={`/ficha/formulario-permiso/${item.id}`} target="_blank">
                                            <i className="fas fa-search"/>
                                        </a>
                                    </Tooltip>
                                    {item.estado == 0 && (
                                        <>
                                            <Tooltip title="Editar Formulario">
                                                <a className="btn btn-primary btn-sm" href={`/formularios-permisos/editar/${item.id}`} target="_blank">
                                                    <i className="far fa-edit" />
                                                </a>
                                            </Tooltip>
                                            <Tooltip title="Marcar como FIRMADO">
                                                <button className="btn btn-outline-primary btn-sm" onClick={() => handleMarcarFirmado(item.id)}>
                                                    <i className="fas fa-check" />
                                                </button>
                                            </Tooltip>
                                            {item.fecha_solicitud === moment().format('DD/MM/YYYY') && (
                                                <Tooltip title="Eliminar">
                                                    <button className="btn btn-danger btn-sm" onClick={() => handleEliminar(item.id)}>
                                                        <i className="fas fa-trash-alt" />
                                                    </button>
                                                </Tooltip>
                                            )}
                                        </>
                                    )}
                                    {(item.estado == 1) ? (
                                        <>
                                            <Tooltip title="Marca como ENVIADO">
                                                <button className="btn btn-outline-warning btn-sm" onClick={() => handleMarcarEnviado(item.id)}>
                                                    <i className="fas fa-check" />
                                                </button>
                                            </Tooltip>
                                        </>
                                    ) : ''}
                                    {(item.estado == 2 & usuario.permisos == 2) ? (
                                        <>
                                            <Tooltip title="Marca como RECEPCIONADO">
                                                <button className="btn btn-outline-warning btn-sm" onClick={() => handleMarcarRecepcionado(item.id)}>
                                                    <i className="fas fa-check" />
                                                </button>
                                            </Tooltip>
                                        </>
                                    ) : ''}
                                    {(item.estado == 3 & usuario.permisos == 2) ? (
                                        <>
                                            <Tooltip title="Marca como SUBIDO EN EL SISTEMA">
                                                <button className="btn btn-outline-warning btn-sm" onClick={() => handleMarcarCargado(item.id)}>
                                                    <i className="fas fa-check" />
                                                </button>
                                            </Tooltip>
                                        </>
                                    ) : ''}
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
                        fetchFormulariosPermisos();
                    }
                });
        }

        fetchFormulariosPermisos();
    }, [ filtro, reloadDatos ]);

    return (
        <>
            <div className="row">
                <div className="col-md-5">
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
                <div className="col-md-1"></div>
                <div className="col-md-5">
                    <button className="btn btn-success btn-sm" onClick={handleExportar}>
                        <i className="fas fa-file-excel"></i> Exportar
                    </button>
                </div>
            </div>
            <div className="row">
                <div className="col-md-5">
                    Estado:<br />
                    <select
                        className="form-control"
                        value={filtro.estado}
                        onChange={e => setFiltro({ ...filtro, estado: e.target.value })}
                    >
                        <option value="0">GENERADOS</option>
                        <option value="1">FIRMADOS</option>
                        <option value="2">ENVIADO</option>
                        <option value="3">RECEPCIONADO</option>
                        <option value="4">SUBIDO</option>
                    </select>
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

const CheckboxGoce = ({ item }) => {

    const [checked, setChecked] = useState(item.goce);

    const handleCheckGoce = id => {

        setChecked(!checked);
        Axios.put(`/api/formulario-permiso/toggle-goce/${id}`)
            .then(res => setChecked(res.data.goce));
    }

    return (
        <>
            <input type="checkbox" disabled={item.estado !== 0} checked={checked} onChange={e => handleCheckGoce(item.id)} />
        </>
    );
}
