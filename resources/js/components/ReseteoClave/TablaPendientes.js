import React, { useState, useEffect } from 'react';
import moment from 'moment';
import { DatePicker, message } from 'antd';
import { MDBDataTableV5 } from 'mdbreact';
import Axios from 'axios';

const TablaPendientes = () => {
    const { usuario } = JSON.parse(sessionStorage.getItem('data'));
    const [filtro, setFiltro] = useState({
        desde: moment().format('YYYY-MM-DD').toString(),
        hasta: moment().format('YYYY-MM-DD').toString()
    });

    const [datatable, setDatatable] = useState({
        columns: [
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
        ],
        rows: []
    });

    const handleExportar = () => {
        console.log('exportar');
    }

    useEffect(() => {
        Axios.post('/api/atencion-reseteo-clave/get-all', {
            usuario_id: usuario.id,
            desde: filtro.desde,
            hasta: filtro.hasta,
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
                                <button className="btn btn-danger btn-sm" onClick={() => eliminarEleccionAfp(item.id)}>
                                    <i className="fas fa-trash-alt" />
                                </button>
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
    }, [filtro.desde, filtro.hasta]);

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
