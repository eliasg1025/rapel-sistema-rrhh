import React from 'react';
import { Table } from 'antd';

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
            title: 'APELLIDOS Y NOMBRES',
            dataIndex: 'nombre_completo_trabajador'
        },
        {
            title: 'CONTINGENCIA',
            dataIndex: 'contingencia'
        },
        {
            title: 'FUNDO',
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
            title: 'TOTAL',
            dataIndex: 'total_dias',
            render: (value) => <b>{ value }</b>
        },
        {
            title: 'OBSERVACION(ES)',
            dataIndex: 'observacion'
        },
        {
            title: 'ALERTA',
            dataIndex: 'consideracion'
        },
        {
            title: 'Acciones',
            dataIndex: 'acciones',
            render: (_, record) => {
                return informe?.estado == 0 ? (
                    <div className="btn-group">
                        <div className="btn btn-primary btn-sm" onClick={() => editRow(record)}>
                            <i className="fas fa-edit"></i>
                        </div>
                        <div className="btn btn-danger btn-sm" onClick={() => deleteRow(record.id)}>
                            <i className="fas fa-trash-alt"></i>
                        </div>
                    </div>
                ) : null;
            }
        }
    ];

    return (
        <Table
            size="small"
            columns={columns}
            dataSource={registros}
            bordered
        />
    );
}
