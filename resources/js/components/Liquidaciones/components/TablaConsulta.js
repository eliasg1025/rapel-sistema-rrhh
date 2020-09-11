import React from 'react';
import { Table } from 'antd';

export const TablaConsulta = () => {

    const columns = [
        {
            title: 'Empresa',
            dataIndex: 'empresa'
        },
        {
            title: 'RUT',
            dataIndex: 'rut'
        }
    ];

    return (
        <>
            <h5>Liquidaciones</h5>
            <Table
                columns={columns}
            />
            <br />
            <h5>Utilidades</h5>
            <Table
                columns={columns}
            />
        </>
    );
}
