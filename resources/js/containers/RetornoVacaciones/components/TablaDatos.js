import React from 'react';
import { Table } from 'antd';

export const TablaDatos = ({ data, loading }) => {

    const columns = [
        {
            title: 'Empresa',
            dataIndex: 'Empresa',
            ellipsis: true,
        },
        {
            title: 'RUT',
            dataIndex: 'RutTrabajador'
        },
        {
            title: 'Trabajador',
            dataIndex: 'Trabajador',
            ellipsis: true,
        },
        {
            title: 'Fecha Inicio',
            dataIndex: 'FechaInicio',
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
            dataIndex: 'Oficio',
            ellipsis: true,
        },
        {
            title: 'Regimen',
            dataIndex: 'Regimen'
        },
        {
            title: 'Zona Labor',
            dataIndex: 'ZonaLabor',
            ellipsis: true,
        },
    ];

    return (
        <>
            <Table
                columns={columns}
                scroll={{ x: 1000 }}
                dataSource={data}
                loading={loading}
                size="small"
                bordered
            />
        </>
    );
}
