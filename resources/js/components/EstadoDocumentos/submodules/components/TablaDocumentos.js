import React from 'react';
import { Table } from 'antd';

export const TablaDocumentos = ({ data, reloadData, loading }) => {

    const columns = [
        {
            title: 'Empresa',
            dataIndex: 'empresa'
        },
        {
            title: 'Periodo',
            dataIndex: 'periodo',
        },
        {
            title: 'Nombre Completo',
            dataIndex: 'nombre_completo'
        },
        {
            title: 'Regimen',
            dataIndex: 'regimen'
        },
        {
            title: 'Estado',
            dataIndex: 'estado'
        }
    ];

    return (
        <Table
            columns={columns} dataSource={data} size="small"
        />
    );
}
