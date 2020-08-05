import React, { useState, useEffect } from 'react';
import moment from 'moment';
import { DatePicker, message } from 'antd';
import { MDBDataTableV5 } from 'mdbreact';
import Axios from 'axios';

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
                field: 'goce',
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

    useEffect(() => {
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
                        goce: item.estado == 0 ? (
                            <CheckboxGoce item={item} />
                        ) : (item.goce == 0 ? 'NO' : 'SI'),
                        acciones: (
                            <div className="btn-group">
                                <a className="btn btn-primary btn-sm" href={`/ficha/formulario-permiso/${item.id}`} target="_blank">
                                    <i className="fas fa-search"/>
                                </a>
                                {item.estado == 0 && (
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
                    rows: formularios
                });
            })
            .catch(err => {
                console.error(err);
            });
    }, [ filtro, reloadDatos ]);

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
                    <button className="btn btn-secondary" onClick={() => setReloadDatos(!reloadDatos)}>
                        <i className="fas fa-sync-alt"></i>
                    </button>
                </div>
                <div>
                    <select
                        className="form-control"
                        value={filtro.estado}
                        onChange={e => setFiltro({ ...filtro, estado: e.target.value })}
                    >
                        <option value="0">GENERADO</option>
                        <option value="1">FIRMADO</option>
                        <option value="2">CARGADO</option>
                        <option value="3">ARCHIVADO</option>
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
