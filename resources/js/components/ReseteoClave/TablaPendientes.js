import React, { useState, useEffect } from 'react';
import moment from 'moment';
import { DatePicker, message } from 'antd';
import { MDBDataTableV5 } from 'mdbreact';
import Axios from 'axios';
import Swal from 'sweetalert2';

const TablaPendientes = ({ reloadDatos, setReloadDatos }) => {
    const { usuario } = JSON.parse(sessionStorage.getItem('data'));
    const [filtro, setFiltro] = useState({
        desde: moment().format('YYYY-MM-DD').toString(),
        hasta: moment().format('YYYY-MM-DD').toString(),
        estado: 0,
    });

    let _columns = [];
    if (filtro.estado == 1) {
        _columns = [
            {
                label: 'Fecha Solicitud',
                field: 'fecha_solicitud',
                sort: 'disabled',
                width: 150
            },
            {
                label: 'Estado',
                field: 'estado_name',
            },
            {
                label: 'RUT',
                field: 'rut',
                sort: 'disabled',
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
                label: 'Acciones',
                field: 'acciones',
                sort: 'disabled'
            }
        ];
    } else {
        _columns = [
            {
                label: 'Fecha Solicitud',
                field: 'fecha_solicitud',
                sort: 'disabled',
                width: 150
            },
            {
                label: 'RUT',
                field: 'rut',
                sort: 'disabled',
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
                label: 'Acciones',
                field: 'acciones',
                sort: 'disabled'
            }
        ];
    }

    const [datatable, setDatatable] = useState({
        columns: _columns,
        rows: []
    });

    const handleExportar = () => {
        console.log('exportar');
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
                    Axios.delete(`/api/atencion-reseteo-clave/${id}`)
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

    const handleResolver = id => {
        Axios.put(`/api/atencion-reseteo-clave/resolver/${id}`, {
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
            });
    }

    useEffect(() => {
        Axios.post('/api/atencion-reseteo-clave/get-all', {
            usuario_id: usuario.id,
            desde: filtro.desde,
            hasta: filtro.hasta,
            estado: filtro.estado
        })
            .then(res => {
                const { data } = res;
                console.log(data);

                message['success']({
                    content: `Se encontraron ${data.length} registros`
                });

                const atenciones = data.map(item => {
                    return {
                        ...item,
                        estado_name: item.estado == 0 ? 'PENDIENTE' : 'RESUELTO',
                        acciones: (
                            <div className="btn-group">
                                {usuario.reseteo_clave == 2 && (
                                    <button className="btn btn-primary btn-sm" onClick={() => handleResolver(item.id)}>
                                        <i className="fas fa-check"/>
                                    </button>
                                )}
                                {item.fecha_solicitud === moment().format('YYYY-MM-DD') && (
                                    <button className="btn btn-danger btn-sm" onClick={() => handleEliminar(item.id)}>
                                        <i className="fas fa-trash-alt" />
                                    </button>
                                )}
                            </div>
                        )
                    }
                });

                setDatatable({
                    ...datatable,
                    rows: atenciones
                });
            })
            .catch(err => console.error(err));
    }, [filtro.desde, filtro.hasta, filtro.estado, reloadDatos]);

    return (
        <>
            <div className="d-flex justify-content-between">
                <div>
                    <DatePicker.RangePicker
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
                <div>
                    <select
                        className="form-control"
                        value={filtro.estado}
                        onChange={e => setFiltro({ ...filtro, estado: e.target.value })}
                    >
                        <option value="0">PENDIENTE</option>
                        <option value="1">ATENDIDO</option>
                    </select>
                </div>
                <div>
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
                entries={10}
                pagesAmount={10}
                data={datatable}
                searchTop
                searchBottom={false}
            />
        </>
    );
}

export default TablaPendientes;
