import React, { useEffect, useState } from 'react';
import { Table, DatePicker, message, Tooltip } from 'antd';
import moment from 'moment';
import Axios from 'axios';
import Swal from 'sweetalert2';

export const TablaEpp = ({ reloadData, setReloadData }) => {

    const { usuario } = JSON.parse(sessionStorage.getItem('data'));
    const [filtro, setFiltro] = useState({
        desde: moment().subtract(1, 'days').format('YYYY-MM-DD').toString(),
        hasta: moment().add(1, 'days').format('YYYY-MM-DD').toString(),
    });
    const [data, setData] = useState([]);

    useEffect(() => {
        fetchSanciones();
    }, [filtro, reloadData]);

    function fetchSanciones() {
        Axios.post('/api/sancion-epp/get', {...filtro, usuario_id: usuario.id})
            .then(res => {
                const { data } = res;

                message['success']({
                    content: `Se encontraron ${data.length} registros`
                });

                setData(data.map(item => {
                    return {
                        ...item,
                        key: item.id
                    }
                }));
            })
            .catch(err => {
                console.log(err);
            });
    }

    function handleExportar() {
        console.log(data);

        const headings = [
            'Empresa',
            'Fecha Solicitud',
            'RUT',
            'Trabajador',
            'Fecha Incidencia',
            'Regimen',
            'Zona Labor',
            'Motivo',
            'EPP(s)'
        ];

        const d = data.map(item => {
            return {
                empresa: item.empresa,
                fecha_solicitud: item.fecha_solicitud,
                dni: item.rut,
                trabajador: item.nombre_completo,
                fecha_incidencia: item.fecha_incidencia,
                regimen: item.regimen,
                zona_labor: item.zona_labor,
                motivo: item.motivo,
                epps: item.epps
            };
        });

        Axios({
            url: '/descargar',
            data: {headings, data: d},
            method: 'POST',
            responseType: 'blob'
        })
            .then(response => {
                console.log(response);
                let blob = new Blob([response.data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' })
                let link = document.createElement('a')
                link.href = window.URL.createObjectURL(blob)
                link.download = `REGISTROS-SANCIONES-EPPS-${filtro.estado == 0 ? "NO_ENVIADO" : "ENVIADOS"}-${filtro.desde}-${filtro.hasta}.xlsx`
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
                    Axios.delete(`/api/sancion-epp/${id}`)
                        .then(res => {
                            Swal.fire({
                                title: res.data.message,
                                icon: res.status < 400 ? 'success' : 'error'
                            })
                                .then(() => setReloadData(!reloadData));
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

    const columns = [
        {
            title: 'Empresa',
            dataIndex: 'empresa'
        },
        {
            title: 'Fecha Solicitud',
            dataIndex: 'fecha_solicitud'
        },
        {
            title: 'RUT',
            dataIndex: 'rut',
        },
        {
            title: 'Nombre',
            dataIndex: 'nombre_completo',
        },
        {
            title: 'Fecha Incidencia',
            dataIndex: 'fecha_incidencia'
        },
        {
            title: 'Contador',
            dataIndex: 'contador',
        },
        {
            title: 'Regimen',
            dataIndex: 'regimen'
        },
        {
            title: 'Zona Labor',
            dataIndex: 'zona_labor'
        },
        {
            title: 'Motivo',
            dataIndex: 'motivo',
        },
        {
            title: 'EPP(s)',
            dataIndex: 'epps'
        },
        {
            title: 'Accciones',
            render: (_, record) => (
                <>
                    <div className="btn-group">
                        {record.sancion_id && (
                            <Tooltip title="Ver Sanción Generada">
                                <a className="btn btn-primary btn-sm" href={`/ficha/sancion/${record.sancion_id}`} target="_blank">
                                    <i className="fas fa-search"/>
                                </a>
                            </Tooltip>
                        )}
                        <Tooltip title="Eliminar">
                            <button className="btn btn-danger btn-sm" onClick={() => handleEliminar(record.id)}>
                                <i className="fas fa-trash-alt" />
                            </button>
                        </Tooltip>
                    </div>
                </>
            )
        }
    ];

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
            <Table
                size="small"
                columns={columns}
                dataSource={data}
            />
        </>
    );
}
