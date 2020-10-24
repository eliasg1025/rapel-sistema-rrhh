import React from 'react';
import { Table, Tooltip } from 'antd';

export const TablaDescansos = ({ informe, registros, deleteRow, editRow }) => {

    const columns = [
        {
            title: 'COD.',
            dataIndex: 'code',
        },
        {
            title: 'DNI',
            dataIndex: 'rut'
        },
        {
            title: 'Apellidos Y Nombres',
            dataIndex: 'nombre_completo_trabajador',
        },
        {
            title: 'Contingencia',
            dataIndex: 'contingencia'
        },
        {
            title: 'Fundo',
            dataIndex: 'zona_labor'
        },
        {
            title: 'DEL',
            dataIndex: 'fecha_inicio'
        },
        {
            title: 'AL',
            dataIndex: 'fecha_fin'
        },
        {
            title: 'Total',
            dataIndex: 'total_dias',
            render: (value) => <b>{ value }</b>
        },
        {
            title: 'Observación(es)',
            dataIndex: 'observacion'
        },
        {
            title: 'N° Registro',
            dataIndex: 'numero_registro'
        },
        {
            title: 'Fecha Emisión',
            dataIndex: 'fecha_emision'
        },
        {
            title: 'Alerta',
            dataIndex: 'consideracion',
            width: 250,
            render: (value) => {
                const consideracion = JSON.parse(value);
                return value && (
                    <>
                        {consideracion.permisos.map(item => <div key={item}>- {item}</div>)}
                        {consideracion.asistencias.map(item => <div key={item}>- {item}</div>)}
                    </>
                )
            }
        },
        {
            title: 'Acciones',
            dataIndex: 'acciones',
            fixed: 'right',
            render: (_, record) => {
                return informe?.estado == 0 ? (
                    <div className="btn-group">
                        <Tooltip title="Editar Registro">
                            <div className="btn btn-primary btn-sm" onClick={() => editRow(record)}>
                                <i className="fas fa-edit"></i>
                            </div>
                        </Tooltip>
                        <Tooltip title="Borrar registro">
                            <div className="btn btn-danger btn-sm" onClick={() => deleteRow(record.id)}>
                                <i className="fas fa-trash-alt"></i>
                            </div>
                        </Tooltip>
                    </div>
                ) : null;
            }
        }
    ];

    return (
        <Table
            size="small"
            pagination={{ pageSize: 25 }}
            scroll={{ x: 1300 }}
            columns={columns}
            dataSource={registros}
            bordered
        />
    );
}
