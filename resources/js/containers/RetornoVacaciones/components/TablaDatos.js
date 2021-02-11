import React from 'react';
import { Table } from 'antd';

export const TablaDatos = ({ data, loading }) => {

    const columns = [
        {
            title: 'Empresa',
            dataIndex: 'Empresa'
        },
        {
            title: 'RUT',
            dataIndex: 'RutTrabajador'
        },
        {
            title: 'Trabajador',
            dataIndex: 'Trabajador'
        },
        {
            title: 'Fecha Inicio',
            dataIndex: 'FechaInicio'
        },
        {
            title: 'Fecha Retorno',
            dataIndex: 'FechaRetorno',
        },
        {
            title: 'Dias',
            dataIndex: 'Dias'
        },
        {
            title: 'Oficio',
            dataIndex: 'Oficio'
        },
        {
            title: 'Regimen',
            dataIndex: 'Regimen'
        },
        {
            title: 'Zona Labor',
            dataIndex: 'ZonaLabor'
        },
    ];

    return (
        <>
            <Table
                columns={columns}
                dataSource={data}
                loading={loading}
                size="small"
                bordered
            />
        </>
    );
}
