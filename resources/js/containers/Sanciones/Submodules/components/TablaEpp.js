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
