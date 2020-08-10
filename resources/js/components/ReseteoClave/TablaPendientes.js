import React, { useState, useEffect } from 'react';
import moment from 'moment';
import { DatePicker, message, Tooltip } from 'antd';
import { MDBDataTableV5 } from 'mdbreact';
import Axios from 'axios';
import Swal from 'sweetalert2';

import Modal from '../Modal';

const TablaPendientes = ({ reloadDatos, setReloadDatos }) => {
    const { usuario } = JSON.parse(sessionStorage.getItem('data'));
    const [filtro, setFiltro] = useState({
        desde: moment().format('YYYY-MM-DD').toString(),
        hasta: moment().format('YYYY-MM-DD').toString(),
        estado: 0,
        usuario_carga_id: 0
    });
    const [isVisible, setIsVisible] = useState(false);
    const [modalContent, setModalContent] = useState(null);
    const [usuariosCarga, setUsuariosCarga] = useState([]);

    let _columns = [];
    if (usuario.reseteo_clave == 1) {
        _columns = [
            {
                label: 'Fecha Solicitud',
                field: 'fecha_solicitud',
                sort: 'disabled',
                width: 150
            },
            {
                label: 'Hora',
                field: 'hora'
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
                label: 'Hora',
                field: 'hora'
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
            },
            {
                label: 'Empresa',
                field: 'empresa',
                sort: 'disabled',
                width: 150,
            },
            {
                label: 'Cargado por',
                field: 'nombre_completo_usuario',
            },
            {
                label: 'Clave sugerida',
                field: 'clave'
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
        const headings = [
            'FECHA SOLICITUD',
            'HORA',
            'RUT',
            'TRABAJADOR',
            'EMPRESA',
            'CARGADO POR',
            'CLAVE SUGERIDA',
            'ATENDIDO POR',
        ];
        const data = datatable.rows.map(item => {
            return {
                fecha_solicitud: item.fecha_solicitud,
                hora: item.hora,
                dni: item.rut,
                trabajador: item.nombre_completo,
                empresa: item.empresa,
                cargado_por: item?.nombre_completo_usuario || '',
                clave: (filtro.estado == 0 && usuario.reseteo_clave == 1) ? '' : item.clave,
                atendido_por: item?.nombre_completo_usuario2 || '',
            }
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
                link.download = `RESETEO-CLAVE-${filtro.estado == 0 ? "PENDIENTES" : "ATENDIDOS"}-${filtro.desde}-${filtro.hasta}.xlsx`
                link.click();
            })
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

    const handleVerCambio = item => {
        console.log(item);
        setIsVisible(true);
        setModalContent(
            <div className="container">
                Nueva clave: <b>{item.clave}</b><br />
                Atendido por: <b>{item.nombre_completo_usuario2}</b>
            </div>
        );
    }

    useEffect(() => {
        Axios.post('/api/atencion-reseteo-clave/get-all', {
            usuario_id: usuario.id,
            usuario_carga_id: filtro.usuario_carga_id,
            desde: filtro.desde,
            hasta: filtro.hasta,
            estado: filtro.estado
        })
            .then(res => {
                const { data } = res;

                message['success']({
                    content: `Se encontraron ${data.length} registros`
                });

                const atenciones = data.map(item => {
                    return {
                        ...item,
                        acciones: (
                            <div className="btn-group">
                                {item.estado == 0 ? (
                                    <>
                                        {usuario.reseteo_clave == 2 && (
                                            <Tooltip title="Marca como ATENDIDO">
                                                <button className="btn btn-primary btn-sm" onClick={() => handleResolver(item.id)}>
                                                    <i className="fas fa-check"/>
                                                </button>
                                            </Tooltip>
                                        )}
                                        <button className="btn btn-danger btn-sm" onClick={() => handleEliminar(item.id)}>
                                            <i className="fas fa-trash-alt" />
                                        </button>
                                    </>
                                ) : (
                                    <button className="btn btn-light btn-sm" onClick={() => handleVerCambio(item)}>
                                        <i className="fas fa-eye" /> Clave
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
    }, [filtro.desde, filtro.hasta, filtro.estado, filtro.usuario_carga_id, reloadDatos]);

    useEffect(() => {
        setFiltro({ ...filtro, usuario_carga_id: 0 });
        let intentos = 0;
        function fetchUsuariosCarga() {
            intentos++;
            Axios.post('/api/atencion-reseteo-clave/get-usuarios-carga', {
                desde: filtro.desde,
                hasta: filtro.hasta,
                estado: filtro.estado
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
    }, [filtro.desde, filtro.hasta, filtro.estado, reloadDatos]);

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
                    Estado:<br />
                    <select
                        className="form-control"
                        value={filtro.estado}
                        onChange={e => setFiltro({ ...filtro, estado: e.target.value })}
                    >
                        <option value="0">PENDIENTES</option>
                        <option value="1">ATENDIDOS</option>
                    </select>
                </div>
                {usuario.reseteo_clave == 2 && (
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
            <Modal
                title="Cambio de clave"
                isVisible={isVisible}
                setIsVisible={setIsVisible}
            >
                {modalContent}
            </Modal>
        </>
    );
}

export default TablaPendientes;
