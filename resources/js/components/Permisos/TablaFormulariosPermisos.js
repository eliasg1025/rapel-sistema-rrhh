import React, { useState, useEffect } from 'react';
import moment from 'moment';
import { DatePicker, message } from 'antd';
import { MDBDataTableV5 } from 'mdbreact';

export const TablaFormulariosPermisos = ({
    reloadDatos,
    setReloadDatos
}) => {
    const { usuario } = JSON.parse(sessionStorage.getItem('data'));
    const [filtro, setFiltro] = useState({
        desde: moment().format('YYYY-MM-DD').toString(),
        hasta: moment().format('YYYY-MM-DD').toString(),
        estado: 0,
        // usuario_carga_id: 0
    });

    let columns = [];
    if (usuario.permisos == 1) {
        columns = [
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
    } else {
        columns = [
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
        columns: columns,
        rows: []
    });

    const handleExportar = () => {
        console.log('exportar');
    }

    useEffect(() => {
        console.log(filtro);
    }), [filtro];

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
                entries={10}
                pagesAmount={10}
                data={datatable}
                searchTop
                searchBottom={false}
            />
        </>
    );
}
